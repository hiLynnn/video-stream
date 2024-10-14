<?php

namespace App\Http\Controllers;

use Auth;
use App\User; 
use App\Transactions;
use App\SubscriptionPlan;
use App\Coupons;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Str;

use Session;
use Redirect;
use Input;
 
class MollieController extends Controller
{
	 
    public function mollie_pay(Request $request)
    {   

        $data =  \Request::except(array('_token'));
        
        $inputs = $request->all();

        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }   
         
        //$currency_code='EUR';
        $currency_code=getcong('currency_code')?getcong('currency_code'):'EUR';

         $plan_id = Session::get('plan_id'); 
         //$plan_id = 6;
         $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();                 
         $plan_name=$plan_info->plan_name;         
         $amount=$plan_info->plan_price;

         if(Session::get('coupon_percentage'))
          {   
              //If coupon used
              $discount_price_less =  $amount * Session::get('coupon_percentage') / 100;

              $plan_amount=number_format($amount - $discount_price_less,2);

              $coupon_code= Session::get('coupon_code');
              $coupon_percentage= Session::get('coupon_percentage');

          }
          else
          {
              //If no coupon used
              $plan_amount=number_format($amount,2);
              $coupon_code= NULL;
              $coupon_percentage= NULL;
          }
           

          $user_id=Auth::user()->id;           
          $user = User::findOrFail($user_id);

          $name = $user->name;
          $email= $user->email;
          $phone= $user->phone?$user->phone:'';

        
          $mollie_api_key=getPaymentGatewayInfo(7,'mollie_api_key');
          $success_url=\URL::to('mollie/success/');
          $cancel_url=\URL::to('mollie/fail/');

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mollie.com/v2/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER =>array('Authorization: Bearer '.$mollie_api_key),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('amount[currency]' => $currency_code,'amount[value]' => $plan_amount,'description' => $plan_name,'redirectUrl' => $success_url,'cancelUrl' => $cancel_url),
          ));
          //'method' => 'creditcard'

           
          $response = json_decode(curl_exec($curl));

          curl_close($curl);           

            
        $payment_id=$response->id;  
        Session::put('mollie_payment_id', $payment_id);
 
        $redirect_url=$response->_links->checkout->href;
          
        return redirect($redirect_url);

    }

    public function mollie_success()
    {

        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }
         
        $mollie_payment_id=Session::get('mollie_payment_id');

        $mollie_api_key=getPaymentGatewayInfo(7,'mollie_api_key');

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mollie.com/v2/payments/'.$mollie_payment_id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPHEADER =>array('Authorization: Bearer '.$mollie_api_key),
          CURLOPT_CUSTOMREQUEST => 'GET' 
        ));

        //curl_setopt($curl, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);


        //echo $response->status;

        if($response->status=="paid")
        {

        $payment_id = $response->id;

        $plan_id = Session::get('plan_id');

        $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();
        $plan_name=$plan_info->plan_name;
        $plan_days=$plan_info->plan_days;
        $amount=$plan_info->plan_price;

        if(Session::get('coupon_percentage'))
        {   
            //If coupon used
            $discount_price_less =  $amount * Session::get('coupon_percentage') / 100;

            $plan_amount=$amount - $discount_price_less;

            $coupon_code= Session::get('coupon_code');
            $coupon_percentage= Session::get('coupon_percentage');

            //Update Counpon Used
            Coupons::where('coupon_code', $coupon_code)->update([
                'coupon_used'=> DB::raw('coupon_used+1') 
            ]);

        }
        else
        {
            //If no coupon used
            $plan_amount=$amount;
            $coupon_code= NULL;
            $coupon_percentage= NULL;
        }
 
        $user_id=Auth::user()->id;           
        $user = User::findOrFail($user_id);

        $user->plan_id = $plan_id;                    
        $user->start_date = strtotime(date('m/d/Y'));             
        $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));
        
        $user->plan_amount = $plan_amount;
        $user->save();


        $payment_trans = new Transactions;

        $payment_trans->user_id = Auth::user()->id;
        $payment_trans->email = Auth::user()->email;
        $payment_trans->plan_id = $plan_id;
        $payment_trans->gateway = 'mollie';
        $payment_trans->payment_amount = $plan_amount;
        $payment_trans->payment_id = $payment_id;

        $payment_trans->coupon_code = $coupon_code;
        $payment_trans->coupon_percentage = $coupon_percentage;

        $payment_trans->date = strtotime(date('m/d/Y H:i:s'));                    
        $payment_trans->save();

        Session::flash('coupon_code',Session::get('coupon_code'));
        Session::flash('coupon_percentage',Session::get('coupon_percentage'));

        Session::flash('plan_id',Session::get('plan_id'));
         
         //Subscription Create Email
        $user_full_name=$user->name;

        $data_email = array(
            'name' => $user_full_name
             );    
 
         try{

               \Mail::send('emails.subscription_created', $data_email, function($message) use ($user,$user_full_name){
                    $message->to($user->email, $user_full_name)
                        ->from(getcong('site_email'), getcong('site_name')) 
                        ->subject('Subscription Created');
                });  
            
            }catch (\Throwable $e) {
             
                \Log::info($e->getMessage());  
                           
            }


        \Session::flash('success',trans('words.payment_success'));
        return redirect('dashboard');
      }
      else
      {

        Session::flash('coupon_code',Session::get('coupon_code'));
        Session::flash('coupon_percentage',Session::get('coupon_percentage'));

        Session::flash('plan_id',Session::get('plan_id'));

        \Session::flash('error_flash_message',trans('words.payment_failed'));
        return redirect('dashboard');
      }

    }

    public function mollie_fail()
    {

        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }

        Session::flash('coupon_code',Session::get('coupon_code'));
        Session::flash('coupon_percentage',Session::get('coupon_percentage'));

        Session::flash('plan_id',Session::get('plan_id'));

        \Session::flash('error_flash_message',trans('words.payment_failed'));
        return redirect('dashboard');

    }

 
}
