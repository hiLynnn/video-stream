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

 require(base_path() . '/public/cashfree/common.php');
  

class CashfreeController extends Controller
{
	 
    public function get_cashfree_session_id(Request $request)
    {
         
        $input = $request->all();

        $order_id= 'PS_WEB_'.rand(0,9999).time();
         
        if(getPaymentGatewayInfo(10,'mode')=="sandbox")
         {
            $baseUrl= "https://sandbox.cashfree.com/pg/orders";  
         }
         else
         {
             $baseUrl= "https://api.cashfree.com/pg/orders";
         }

         $plan_id = Session::get('plan_id');
          
         $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();

         $plan_amount=$plan_info->plan_price;
         $customer_id=Auth::user()->id;
         $customer_name=Auth::user()->name;
         $customer_email=Auth::user()->email;
         $customer_phone=Auth::user()->phone;

         $return_url=\URL::to('cashfree/success/');

         $appId= getPaymentGatewayInfo(10,'cashfree_appid');
         $secret= getPaymentGatewayInfo(10,'cashfree_secret_key');
 
        $post_fields =json_encode([
            'order_id' => $order_id,
            'order_amount' => $plan_amount,
            'order_currency' => 'INR',
            'customer_details' => ['customer_id'=>"$customer_id",'customer_name'=>$customer_name,'customer_email'=>$customer_email,'customer_phone'=>$customer_phone],
            'order_meta' => ['return_url'=>$return_url.'?order_id={order_id}'],
            
        ]);

        //print_r($post_fields);exit;

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>  $post_fields,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "content-type: application/json",
            "x-client-id: ".$appId,
            "x-client-secret: ".$secret,
            "x-api-version: 2022-09-01"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

 
        if ($err) {
            echo "cURL Error #:" . $err;
            exit;
        } else {
            //echo $response;
            
            $transaction = json_decode($response);
            $paymentSessionId = $transaction->payment_session_id;

            echo $paymentSessionId; 
            exit;
        }
        
    }

    public function cashfree_success()
    {   
        if(!Auth::check())
        {

            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect()->back();            
        }


         $orderId = $_GET["order_id"]; 

         $appId= getPaymentGatewayInfo(10,'cashfree_appid');
         $secret= getPaymentGatewayInfo(10,'cashfree_secret_key');
 
         if(getPaymentGatewayInfo(10,'mode')=="sandbox")
         {
            $baseUrl= "https://sandbox.cashfree.com/pg/orders/$orderId";  
         }
         else
         {
            $baseUrl= "https://api.cashfree.com/pg/orders/$orderId";
         }

  
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $baseUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'x-client-id: '.$appId,
            'x-client-secret: '.$secret,
            'x-api-version: 2022-09-01'
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);

        $result = json_decode($response, true);


        if($result["order_status"] == 'PAID')
        {
               $payment_id= $result["order_id"];
                
                $user_id=Auth::user()->id;
                $user_email=Auth::user()->email;           
                $user = User::findOrFail($user_id);

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

                $user->plan_id = $plan_id;                    
                $user->start_date = strtotime(date('m/d/Y'));             
                $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));
                
                $user->plan_amount = $plan_amount;
                $user->save();

                //Check duplicate
                $trans_info = Transactions::where('user_id',$user_id)->where('payment_id',$payment_id)->first();

                if($trans_info=="")
                {
                    $payment_trans = new Transactions;

                    $payment_trans->user_id = $user_id;
                    $payment_trans->email = $user_email;
                    $payment_trans->plan_id = $plan_id;
                    $payment_trans->gateway = 'Cashfree';
                    $payment_trans->payment_amount = $plan_amount;
                    $payment_trans->payment_id = $payment_id;

                    $payment_trans->coupon_code = $coupon_code;
                    $payment_trans->coupon_percentage = $coupon_percentage;

                    $payment_trans->date = strtotime(date('m/d/Y H:i:s'));    
                    $payment_trans->save();

                }

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
            else
            {
                Session::flash('plan_id',Session::get('plan_id'));

                \Session::flash('error_flash_message',trans('words.payment_failed'));
                return redirect('dashboard');     
            }

    }

    
}
