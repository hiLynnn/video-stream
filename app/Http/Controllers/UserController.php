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
use Carbon\Carbon;

use PayOS\PayOS;


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
    public $Order_id;
      
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
        foreach ($transactions_list as $transaction) {
            $formatted_date = $transaction->formatDate($transaction->date);
        }
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

    public function createPaymentLink(Request $request) {
        if(!Auth::check())
        {
            \Session::flash('error_flash_message', trans('words.access_denied'));
            return redirect('login');            
        }
        $YOUR_DOMAIN = route('public-payment-index');
        $cancelUrl   = route('public.index');
        $data = [
            "orderCode" => intval(substr(strval(microtime(true) * 10000), -6)),
            "amount" => 2000,
            "description" => "Thanh toán đơn hàng",
            "returnUrl" => $YOUR_DOMAIN,
            "cancelUrl" => $cancelUrl,
        ];
        error_log($data['orderCode']);
        Session::put('order_id', $data['orderCode']);
        $PAYOS_CLIENT_ID = "23bd3644-9c91-42c9-bc12-2b0f9757ded6";
        $PAYOS_API_KEY = "e44c05ab-ae6d-47a4-b184-e5c19fab6450";
        $PAYOS_CHECKSUM_KEY = "726a194eb054027adecf5a08dfa24717fc480645f31c7c33bdecde39d6dd6ad6";

        $payOS = new PayOS($PAYOS_CLIENT_ID, $PAYOS_API_KEY, $PAYOS_CHECKSUM_KEY);
        try {
            $response = $payOS->createPaymentLink($data);
            // $response = $payOS->getPaymentLinkInformation(615638);
            // dd($response);
            return redirect($response['checkoutUrl']);
            // return $response;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function successPayment(Request $request){
        $PAYOS_CLIENT_ID = "23bd3644-9c91-42c9-bc12-2b0f9757ded6";
        $PAYOS_API_KEY = "e44c05ab-ae6d-47a4-b184-e5c19fab6450";
        $PAYOS_CHECKSUM_KEY = "726a194eb054027adecf5a08dfa24717fc480645f31c7c33bdecde39d6dd6ad6";
        $payOS = new PayOS($PAYOS_CLIENT_ID, $PAYOS_API_KEY, $PAYOS_CHECKSUM_KEY);
        try{
            $order_id = session::get('order_id');
            $response = $payOS->getPaymentLinkInformation($order_id);
            if($response['status'] === "PAID"){
                $order = [
                    'user_id' =>  Auth::User()->id,
                    'email'   => Auth::User()->email,
                    'plan_id' => 1,
                    'payment_amount' => $response['amount'],
                    'gateway'  => '',
                    'date'     => Carbon::now()->format('Y-m-d'),
                    'payment_id' => 0 ,
                ];
                $order = Transactions::create($order);
                $updatuser = User::where('id', Auth::User()->id)->update(['plan_id' => 2]);
                Session::forget('order_id');
                return response()->json([
                    "error" => 0,
                    "message" => "Success",
                    "data" => $response,
                    "order" => $order,
                    "updatuser" => $updatuser
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getCode(),
                "message" => $th->getMessage(),
                "data" => null
            ]);
    }
       
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
