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

require(base_path() . '/public/stripe_web/vendor/autoload.php');

class StripeController extends Controller
{
     
    
    public function stripe_pay()
    {   
        $plan_id = Session::get('plan_id');  

        $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();
        $plan_name=$plan_info->plan_name;
        $plan_days=$plan_info->plan_days;
        $amount=$plan_info->plan_price*100;

        if(Session::get('coupon_percentage'))
        {   
            //If coupon used
            $discount_price_less =  $amount * Session::get('coupon_percentage') / 100;

            $plan_amount=$amount - $discount_price_less;

            $coupon_code= Session::get('coupon_code');
            $coupon_percentage= Session::get('coupon_percentage');

        }
        else
        {
            //If no coupon used
            $plan_amount=$amount;
            $coupon_code= NULL;
            $coupon_percentage= NULL;
        }

        $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';  

        $success_url=\URL::to('stripe/success/');
        $fail_url=\URL::to('stripe/fail/');   

        $stripe_secret_key=getPaymentGatewayInfo(2,'stripe_secret_key');

        \Stripe\Stripe::setApiKey($stripe_secret_key);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [[
              'price_data' => [
                'currency' => $currency_code,
                'product_data' => [
                  'name' => $plan_name,
                ],
                'unit_amount' => $plan_amount,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $success_url.'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $fail_url,
          ]);
 
        return Redirect::away($session->url);      

     }
     
    public function stripe_success()
    {
          
        $plan_id = Session::get('plan_id');

        $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();
        $plan_name=$plan_info->plan_name;
        $plan_days=$plan_info->plan_days;
        $amount=$plan_info->plan_price;

        //$plan_name=Session::get('plan_name').' membership';

        $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';

        $stripe_secret_key=getPaymentGatewayInfo(2,'stripe_secret_key');

        \Stripe\Stripe::setApiKey($stripe_secret_key);

        $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);

        $payment_id = $session->payment_intent;

        if($session->status == 'complete') 
        {
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

            /**
            * Write Here Your Database insert logic.
            */

            $user_id=Auth::user()->id;
   
            $user = User::findOrFail($user_id);

            $user->plan_id = $plan_id;                    
            $user->start_date = strtotime(date('m/d/Y'));             
            $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));            
            $user->plan_amount = $plan_amount;
            //$user->subscription_status = 0;
            $user->save();


            $payment_trans = new Transactions;

            $payment_trans->user_id = Auth::user()->id;
            $payment_trans->email = Auth::user()->email;
            $payment_trans->plan_id = $plan_id;
            $payment_trans->gateway = 'Stripe';
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

            Session::flash('plan_id',Session::get('plan_id'));
            Session::flash('coupon_code',Session::get('coupon_code'));
            Session::flash('coupon_percentage',Session::get('coupon_percentage'));

            \Session::flash('success',trans('words.payment_success'));
            return redirect('dashboard');
        }
        else
        {
            Session::flash('plan_id',Session::get('plan_id'));
            Session::flash('coupon_code',Session::get('coupon_code'));
            Session::flash('coupon_percentage',Session::get('coupon_percentage'));

            \Session::flash('error_flash_message','Payment fail!');
            return redirect('dashboard');
        }

         
    }    

    public function stripe_fail()
    {
         Session::flash('plan_id',Session::get('plan_id'));

        \Session::flash('error_flash_message','Payment fail!');
        return redirect('dashboard'); 
    }
}