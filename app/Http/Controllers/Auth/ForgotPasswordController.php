<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    
      public function forget_password()
      {        
         return view('pages.user.forget_password');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function forget_password_submit(Request $request)
      {

        $inputs = $request->all();

        if(getcong('recaptcha_on_forgot_pass'))
        { 
              $request->validate([
                  'email' => 'required|email|exists:users',
                  'g-recaptcha-response' => 'required'
              ]);
        }
        else
        {
              $request->validate([
                'email' => 'required|email|exists:users',
            ]);
        }

        //check reCaptcha
        if(getcong('recaptcha_on_forgot_pass'))
        {

          $recaptcha_response= $inputs['g-recaptcha-response'];
          
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
              curl_setopt($ch, CURLOPT_HEADER, 0);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, [
                  'secret' => getcong('recaptcha_secret_key'),
                  'response' => $recaptcha_response,
                  'remoteip' => $_SERVER['REMOTE_ADDR']
              ]);
      
              $resp = json_decode(curl_exec($ch));
              curl_close($ch);

              //dd($resp);exit;
          
              if ($resp->success!=true) {

                  \Session::flash('error_flash_message', 'Captcha timeout or duplicate');
                  return \Redirect::back();                
              }  
        }
          
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
          Mail::send('emails.forget_password', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
          
          \Session::flash('flash_message', 'We have e-mailed your password reset link!');
          return redirect()->back();
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function reset_password($token) { 
         return view('pages.user.reset_password', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function reset_password_submit(Request $request)
      {
        $inputs = $request->all();

        if(getcong('recaptcha_on_forgot_pass'))
        {  
              $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'g-recaptcha-response' => 'required'
            ]);
        }
        else
        {
              $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ]);
        }

        //check reCaptcha
        if(getcong('recaptcha_on_forgot_pass'))
        {

          $recaptcha_response= $inputs['g-recaptcha-response'];
          
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
              curl_setopt($ch, CURLOPT_HEADER, 0);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, [
                  'secret' => getcong('recaptcha_secret_key'),
                  'response' => $recaptcha_response,
                  'remoteip' => $_SERVER['REMOTE_ADDR']
              ]);
      
              $resp = json_decode(curl_exec($ch));
              curl_close($ch);

              //dd($resp);exit;
          
              if ($resp->success!=true) {

                  \Session::flash('error_flash_message', 'Captcha timeout or duplicate');
                  return \Redirect::back();                
              }  
        }
          
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
            \Session::flash('error_flash_message',  'Invalid token!');
            return redirect()->back();
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
          
          \Session::flash('flash_message',  'Your password has been changed!');
          return redirect('/login');
       }
     
}
