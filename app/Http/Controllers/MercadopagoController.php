<?php

namespace App\Http\Controllers;

use Auth;
use App\User; 
use App\Transactions;
use App\SubscriptionPlan;
use App\Coupons;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;

require(base_path() . '/public/mercadopago/vendor/autoload.php');
 
class MercadopagoController extends Controller
{
       
    public function mercadopago_pay()
    {   
        $mercadopago_mode= getPaymentGatewayInfo(12,'mode');
        $mercadopago_access_token= getPaymentGatewayInfo(12,'mercadopago_access_token');
        
        $plan_id = Session::get('plan_id');
 
        $plan_info = SubscriptionPlan::where('id',$plan_id)->first();
        $plan_name=$plan_info->plan_name;
        $amount=$plan_info->plan_price;


        $success_url=\URL::to('mercadopago/success');
        $failure_url=\URL::to('mercadopago/fail');
        
        // Replace with your MercadoPago API credentials
        \MercadoPago\SDK::setAccessToken($mercadopago_access_token);

        // Create a preference for the payment
        $preference = new \MercadoPago\Preference();

        $item = new \MercadoPago\Item();
        $item->title = $plan_name;
        $item->quantity = 1;
        $item->unit_price = $amount;

        $preference->items = [$item];
        $preference->back_urls = [
            "success" => $success_url,
            "failure" => $failure_url,
            "pending" => $failure_url,
        ];
        $preference->auto_return = "approved"; // Optional: Auto-redirect on successful payment

        $preference->save();


        return redirect($preference->init_point);
        exit;
         
    }

   
    public function mercadopago_success()
    {   
       
        $payment_id=$_GET['payment_id'];
        $payment_status=$_GET['status'];
         
        
            if ($payment_status == 'approved') {
            
                $plan_id = Session::get('plan_id');

                $plan_info = SubscriptionPlan::where('id',$plan_id)->first();
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

                $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';

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
                $payment_trans->gateway = 'Mercado Pago';
                $payment_trans->payment_amount = $plan_amount;
                $payment_trans->payment_id = $payment_id;

                $payment_trans->coupon_code = $coupon_code;
                $payment_trans->coupon_percentage = $coupon_percentage;

                $payment_trans->date = strtotime(date('m/d/Y H:i:s'));                    
                $payment_trans->save();

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

                Session::flash('coupon_code',Session::get('coupon_code'));
                Session::flash('coupon_percentage',Session::get('coupon_percentage'));

                Session::flash('plan_id',Session::get('plan_id'));
 
                \Session::flash('success',trans('words.payment_success'));
                return redirect('dashboard'); 
        
            }
            else{

                Session::flash('coupon_code',Session::get('coupon_code'));
                Session::flash('coupon_percentage',Session::get('coupon_percentage'));

                Session::flash('plan_id',Session::get('plan_id'));
 
                \Session::flash('error_flash_message',trans('words.payment_failed'));
                return redirect('dashboard');
            }    
            
    }

    public function mercadopago_fail()
    {   
        \Session::put('error_flash_message',trans('words.payment_failed'));
        return redirect('dashboard');
    }
     
      
}