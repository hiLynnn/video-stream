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

require(base_path() . '/public/coingate/vendor/autoload.php');
 
class CoingateController extends Controller
{
       
    public function coingate_pay()
    {   
        $coingate_mode= getPaymentGatewayInfo(11,'mode');
        $coingate_api_key= getPaymentGatewayInfo(11,'coingate_api_key');
        $coingate_receive_currency= getPaymentGatewayInfo(11,'coingate_receive_currency');

        $client = new \CoinGate\Client('YOUR_API_TOKEN', true);

        // if needed you can set configuration parameters later
        $client->setApiKey($coingate_api_key);
        $client->setEnvironment($coingate_mode);  

        $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';
         
        $plan_id = Session::get('plan_id');
 
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

        $success_url=\URL::to('coingate/success');
        $cancel_url=\URL::to('coingate/fail');
          
        $order_id='CGORDER-'.rand(0,999999);

        $params = [
            'order_id'          => $order_id,
            'price_amount'      => $plan_amount,
            'price_currency'    => $currency_code,
            'receive_currency'  => $coingate_receive_currency,
            'cancel_url'        => $cancel_url,
            'success_url'       => $success_url,
            'title'             => $plan_name,
            'description'       => 'Please complete payment'
        ];
        
        try {
            $order = $client->order->create($params);
        
            $order_response = json_encode($order);
            
            Session::put('cg_order_id', $order->id);

            //echo $order->payment_url;
            //echo $order_response;
            return redirect($order->payment_url);
            exit;
        
        } catch (\CoinGate\Exception\ApiErrorException $e) {
            // something went wrong...
            //var_dump($e->getErrorDetails());

            Session::flash('plan_id',Session::get('plan_id'));
            Session::flash('cg_order_id',Session::get('cg_order_id'));

            \Session::put('error_flash_message',trans('words.payment_failed'));
            return redirect('dashboard');
        }
 
    }

   
    public function coingate_success()
    {   
        $coingate_mode= getPaymentGatewayInfo(11,'mode');
        $coingate_api_key= getPaymentGatewayInfo(11,'coingate_api_key');
        $coingate_receive_currency= getPaymentGatewayInfo(11,'coingate_receive_currency');

        $client = new \CoinGate\Client('YOUR_API_TOKEN', true);

        // if needed you can set configuration parameters later
        $client->setApiKey($coingate_api_key);
        $client->setEnvironment($coingate_mode); 

        $cg_order_id = Session::get('cg_order_id');

        $order_info = $client->order->get($cg_order_id);
 
        $status=$order_info->status;
        $order_id=$order_info->id;
         
        
            if ($status == 'paid') {
            
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
                $payment_trans->gateway = 'Coingate';
                $payment_trans->payment_amount = $plan_amount;
                $payment_trans->payment_id = $order_id;

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
                Session::flash('cg_order_id',Session::get('cg_order_id'));

                \Session::flash('success',trans('words.payment_success'));
                return redirect('dashboard'); 
        
            }
            else{

                Session::flash('coupon_code',Session::get('coupon_code'));
                Session::flash('coupon_percentage',Session::get('coupon_percentage'));

                Session::flash('plan_id',Session::get('plan_id'));
                Session::flash('cg_order_id',Session::get('cg_order_id'));

                \Session::flash('error_flash_message',trans('words.payment_failed'));
                return redirect('dashboard');
            }    
            
    }

    public function coingate_fail()
    {   
        \Session::put('error_flash_message',trans('words.payment_failed'));
        return redirect('dashboard');
    }
     
      
}