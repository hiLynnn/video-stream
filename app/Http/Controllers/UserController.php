<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Slider;
use App\Series;
use App\Movies;
use App\HomeSection;
use App\SubscriptionPlan;
use App\Transactions; 
use App\Watchlist;
use App\Coupons;
use App\UsersDeviceHistory;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Str; 
use Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
      
    public function dashboard()
    {
        if(!Auth::check())
        {

            \Session::flash('error_flash_message', trans('words.access_denied'));

            return redirect('login');
            
        }

        if(Auth::user()->usertype=='Admin' OR Auth::user()->usertype=='Sub_Admin')
        {
            return redirect('admin/dashboard'); 
        }

        $user_id=Auth::user()->id;
        $user = User::findOrFail($user_id);
 
        $transactions_list = Transactions::where('user_id',$user_id)->orderBy('id','DESC')->paginate(10);

        return view('pages.user.dashboard',compact('user','transactions_list'));
    }

    public function profile()
    { 
       
        if(!Auth::check())
        {

            \Session::flash('error_flash_message', trans('words.access_denied'));

            return redirect('login');
            
        }

        if(Auth::User()->usertype=="Admin" OR Auth::User()->usertype=="Sub_Admin")
        { 
            return redirect('admin');            
        } 

        $user_id=Auth::user()->id;
        $user = User::findOrFail($user_id); 

        return view('pages.user.profile',compact('user'));
    } 
    

    public function editprofile(Request $request)
    { 
        
        $id=Auth::user()->id;    
        $user = User::findOrFail($id);

        $data =  \Request::except(array('_token'));
        
        $rule=array(
                'name' => 'required',
                'email' => 'required|email|max:255|unique:users,email,'.$id,
                'user_image' => 'mimes:jpg,jpeg,gif,png'
                 );
        
         $validator = \Validator::make($data,$rule);
 
            if ($validator->fails())
            {
                    return redirect()->back()->withErrors($validator->messages());
            }
        

        $inputs = $request->all();
        
        $icon = $request->file('user_image');
        
                 
        if($icon){

            \File::delete(public_path('/upload/').$user->user_image);            

            //$tmpFilePath = public_path().'/upload/';
            $tmpFilePath = public_path('/upload/');

            $hardPath =  Str::slug($inputs['name'], '-').'-'.md5(time());

            $img = Image::make($icon);

            $img->fit(250, 250)->save($tmpFilePath.$hardPath.'-b.jpg');
 
            $user->user_image = $hardPath.'-b.jpg';
        }
        
        
        $user->name = $inputs['name'];          
        $user->email = $inputs['email']; 
        $user->phone = $inputs['phone'];
         
        if($inputs['password'])
        {
            $user->password = bcrypt($inputs['password']);
        }         
       
        $user->save();

        Session::flash('flash_message', trans('words.successfully_updated'));

        return redirect()->back();
         
         
    }

    public function phone_update(Request $request)
    {
        $id=Auth::user()->id;    
        $user = User::findOrFail($id);

        $data =  \Request::except(array('_token'));
        
        $rule=array(
                'phone' => 'required' 
                 );
        
         $validator = \Validator::make($data,$rule);
 
            if ($validator->fails())
            {
                    return redirect()->back()->withErrors($validator->messages());
            }
        

        $inputs = $request->all();
       
        $user->phone = $inputs['phone'];        
        $user->save();

        Session::flash('flash_message', trans('words.successfully_updated'));

        return redirect()->back();
    }

    public function membership_plan()
    { 

        if(Auth::check())
       {
            if(Auth::User()->usertype=="Admin" OR Auth::User()->usertype=="Sub_Admin")
            { 
                return redirect('admin');            
            } 

        }

         
        $plan_list = SubscriptionPlan::where('status','1')->orderby('id')->get(); 

        return view('pages.payment.plan',compact('plan_list'));
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    

    public function payment_method($plan_id)
    { 

        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }
        if(Auth::User()->usertype=="Admin" OR Auth::User()->usertype=="Sub_Admin")
        { 
            return redirect('admin');            
        } 

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
                    $partnerCode = 'MOMOBKUN20180529';
                    $accessKey = 'klm05TvNBzhg7h7j';
                    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
                    $orderInfo = "Thanh toán qua MoMo";
                    $amount = 10000;
                    $orderId = time() . "";
                    $redirectUrl = "http://localhost:8000/membership_plan";
                    $ipnUrl = "http://localhost:8000/membership_plan";
                    $extraData = "";                    
                        $requestId = time() . "";
                        $requestType = "payWithATM";
                        //before sign HMAC SHA256 signature
                        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                        $signature = hash_hmac("sha256", $rawHash, $secretKey);
                        $data = array('partnerCode' => $partnerCode,
                            'partnerName' => "Test",
                            "storeId" => "MomoTestStore",
                            'requestId' => $requestId,
                            'amount' => $amount,
                            'orderId' => $orderId,
                            'orderInfo' => $orderInfo,
                            'redirectUrl' => $redirectUrl,
                            'ipnUrl' => $ipnUrl,
                            'lang' => 'vi',
                            'extraData' => $extraData,
                            'requestType' => $requestType,
                            'signature' => $signature);
                        $result = $this->execPostRequest($endpoint, json_encode($data));
                        $jsonResult = json_decode($result, true);  // decode json
                        return redirect()->to($jsonResult['payUrl']);


        // $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();

        // if(!$plan_info)
        // {
        //     \Session::flash('flash_message', 'Select plan!');
        //     return redirect('membership_plan'); 
        // }  

        // //For free plan
        // if($plan_info->plan_price <=0)
        // {
        //     $plan_days=$plan_info->plan_days;
        //     $plan_amount=$plan_info->plan_price;
 
        //     $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';

        //     $user_id=Auth::user()->id;           
        //     $user = User::findOrFail($user_id);

        //     $user->plan_id = $plan_id;                    
        //     $user->start_date = strtotime(date('m/d/Y'));             
        //     $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));            
             
        //     $user->plan_amount = $plan_amount;
        //     //$user->subscription_status = 0;
        //     $user->save();


        //     $payment_trans = new Transactions;

        //     $payment_trans->user_id = Auth::user()->id;
        //     $payment_trans->email = Auth::user()->email;
        //     $payment_trans->plan_id = $plan_id;
        //     $payment_trans->gateway = 'NA';
        //     $payment_trans->payment_amount = $plan_amount;
        //     $payment_trans->payment_id = '-';
        //     $payment_trans->date = strtotime(date('m/d/Y H:i:s'));                    
        //     $payment_trans->save();

        //     Session::flash('plan_id',Session::get('plan_id'));

        //     \Session::flash('success',trans('words.payment_success'));
        //      return redirect('dashboard');
        // }

        // Session::put('plan_id', $plan_id);
        // Session::flash('razorpay_order_id',Session::get('razorpay_order_id'));


        // if(Session::get('coupon_percentage'))
        // {   
        //     //If coupon used
        //     $discount_price_less =  $plan_info->plan_price * Session::get('coupon_percentage') / 100;

        // }
        // else
        // {
        //     //If no coupon used
        //     $discount_price_less = 0;
        // }

 
        // return view('pages.payment.payment_method',compact('plan_info','discount_price_less'));
    }
    
    public function my_watchlist()
    {
        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }

        $user_id = Auth::user()->id;

        if(getcong('menu_movies')==0 AND getcong('menu_shows')==0)
        {            
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Movies')->where('post_type','!=','Shows')->orderby('id','DESC')->get();
        }
        else if(getcong('menu_sports')==0 AND getcong('menu_livetv')==0)
        {            
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Sports')->where('post_type','!=','LiveTV')->orderby('id','DESC')->get();
        }
        else if(getcong('menu_sports')==0)
        {
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Sports')->orderby('id','DESC')->get();
        }   
        else if(getcong('menu_livetv')==0)
        {             
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','LiveTV')->orderby('id','DESC')->get();
        }
        else if(getcong('menu_movies')==0)
        {
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Movies')->orderby('id','DESC')->get();
        }   
        else if(getcong('menu_shows')==0)
        {             
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Shows')->orderby('id','DESC')->get();
        }
        else
        {
            $my_watchlist = Watchlist::where('user_id',$user_id)->orderby('id','DESC')->get();
        }

        $movies_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','=','Movies')->orderby('id','DESC')->get();

        $shows_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','=','Shows')->orderby('id','DESC')->get();

        $sports_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','=','Sports')->orderby('id','DESC')->get();

        $livetv_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','=','LiveTV')->orderby('id','DESC')->get();
             

        return view('pages.user.watchlist',compact('movies_watchlist','shows_watchlist','sports_watchlist','livetv_watchlist'));

    }

    public function watchlist_add()
    {
        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }

        $watch_obj = new Watchlist;

        $watch_obj->user_id = Auth::user()->id;
        $watch_obj->post_id = $_GET['post_id'];
        $watch_obj->post_type = $_GET['post_type'];
        $watch_obj->save(); 

        \Session::flash('flash_message', trans('words.add_watchlist_msg'));

        return redirect()->back();
    }

    public function watchlist_remove()
    {       
            if(!Auth::check())
            {
                \Session::flash('error_flash_message', trans('words.access_denied'));
                return redirect('login');            
            }

            $user_id = Auth::user()->id;

            $watch_obj = Watchlist::where('user_id', $user_id)->where('post_id', $_GET['post_id'])->where('post_type', $_GET['post_type'])->delete();

            \Session::flash('flash_message', trans('words.remove_watchlist_msg'));

            return redirect()->back();
    }


    public function apply_coupon_code(Request $request)
    {

        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }

        $data =  \Request::except(array('_token'));         
        
        $inputs = $request->all();

        $user_id=Auth::user()->id;  
        $user = User::findOrFail($user_id);
        $user_email= $user->email;

        $coupon_code=$inputs['coupon_code']; 
        $today_date=strtotime(date('m/d/Y'));

        //check already used or not
        $trans_info = Transactions::where('coupon_code',$coupon_code)->where('user_id',$user_id)->first();

        //dd($trans_info);
        //exit;

        if($trans_info!="")
        {   
            Session::flash('coupon_code',Session::get('coupon_code'));
            Session::flash('coupon_percentage',Session::get('coupon_percentage'));

            \Session::flash('error', trans('words.already_used_coupon_msg'));
             return \Redirect::back();
        }

         
        $coupon_info = Coupons::where('coupon_code',$coupon_code)->first();
         
        //dd($coupon_info);exit;
       if($coupon_info)
       {    
            $coupon_code=$coupon_info->coupon_code;
            $coupon_exp_date=$coupon_info->coupon_exp_date;
            $coupon_status=$coupon_info->status;
            $coupon_user_limit=$coupon_info->coupon_user_limit;
            $coupon_used=$coupon_info->coupon_used;
            $coupon_percentage=$coupon_info->coupon_percentage;


          if($coupon_status==0)
          { 
              \Session::flash('error', trans('words.coupon_disabled_msg'));                 
               return \Redirect::back();
          }

          if($coupon_exp_date < $today_date)
          {
              \Session::flash('error', trans('words.coupon_expired_msg'));               
               return \Redirect::back();
          }

          if($coupon_user_limit <= $coupon_used)
          {
              \Session::flash('error', trans('words.coupon_limit_reached_msg'));
               return \Redirect::back();
          }

             
           Session::put('coupon_code', $coupon_code);
           Session::put('coupon_percentage', $coupon_percentage);

            //Update Counpon Used
            $coupon_id=$coupon_info->id;
            $coupon_obj = Coupons::findOrFail($coupon_id);
            $coupon_obj->increment('coupon_used');                
            $coupon_obj->save();
            
          \Session::flash('success', trans('words.coupon_applied_successfully_msg'));
          return \Redirect::back();   
        }
        else
        {
            \Session::flash('error', trans('words.coupon_wrong_msg'));            
            return \Redirect::back();
        }
    }

    public function account_delete()
    { 

        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }
 
        $user_id=Auth::user()->id;
        $user = User::findOrFail($user_id); 

        $user_name=$user->name;
        $user_email=$user->email;

        //Change Status
        $user_obj = User::findOrFail($user_id); 
        $user_obj->status=0;
        $user_obj->save(); 
  
        //Delete session file
        $user_session_name=Session::getId();        
        \Session::getHandler()->destroy($user_session_name);
 
        $user_device_obj = UsersDeviceHistory::where('user_id',$user_id)->where('user_session_name',$user_session_name);
        $user_device_obj->delete();
        
        $user->delete();
 
        Auth::logout();

        //Account Delete Email

        if(getenv("MAIL_USERNAME"))
        {
             
            $data_email = array(
                'name' => $user_name,
                'email' => $user_email
                );    

            \Mail::send('emails.account_delete', $data_email, function($message) use ($user_name,$user_email){
                $message->to($user_email, $user_name)
                ->from(getcong('site_email'), getcong('site_name'))
                ->subject(trans('words.user_dlt_email_subject'));
            });    
        }

        $response['status'] = 1;

        echo json_encode($response);
        exit;         
    }

    public function delete_account()
    {
        return view('pages.user.delete_account');
    }

    public function delete_account_verify(Request $request)
    {
        $data =  \Request::except(array('_token'));  
        
        $inputs = $request->all();
                
        $rule=array(
                'email' => 'required|email',
                'password' => 'required'                
                 );
         
         $validator = \Validator::make($data,$rule,$messages = ['required' => 'The :attribute field is required.',]);
 
        if ($validator->fails())
        { 
                return redirect()->back()->withErrors($validator->messages());
        }
        
        $email = $inputs['email'];
        $password = $inputs['password'];
         
        $user_info = User::where('email',$email)->first(); 
 
        if (!empty($user_info) && Hash::check($password, $user_info['password'])) 
        {
            $user_id=$user_info->id;

             //Change Status
             $user_obj = User::findOrFail($user_id); 
             $user_obj->status=0;
             $user_obj->save(); 

            $user = User::findOrFail($user_id);

            $user_name=$user->name;
            $user_email=$user->email;

            \Auth::attempt(['email' => $user->email, 'password' => null]);

            //Delete session file
            $user_session_name=Session::getId();        
            \Session::getHandler()->destroy($user_session_name);
    
            $user_device_obj = UsersDeviceHistory::where('user_id',$user_id)->where('user_session_name',$user_session_name);
            $user_device_obj->delete();
            
            $user->delete();

            Auth::logout();

            //Account Delete Email

            if(getenv("MAIL_USERNAME"))
            { 
                $data_email = array(
                    'name' => $user_name,
                    'email' => $user_email
                    );    

                \Mail::send('emails.account_delete', $data_email, function($message) use ($user_name,$user_email){
                    $message->to($user_email, $user_name)
                    ->from(getcong('site_email'), getcong('site_name'))
                    ->subject(trans('words.user_dlt_email_subject'));
                });    
            }
            
            \Session::flash('flash_message', trans('words.user_dlt_success'));
            return redirect('login');

        }
        else
        {
            Session::flash('flash_error', trans('words.email_password_invalid'));
            return redirect()->back()->withErrors($validator->messages());
        }
    }

}
