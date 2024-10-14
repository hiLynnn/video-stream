<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\UsersDeviceHistory;

require(base_path() . '/public/device-detector/vendor/autoload.php');
use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

class IndexController extends MainAdminController
{
	
    public function index()
    {   
    	if (Auth::check()) {
                        
            return redirect('admin/dashboard'); 
        }
 
        return view('admin.index');
    }
	
	/**
     * Do user login
     * @return $this|\Illuminate\Http\RedirectResponse
     */
	 
    public function postLogin(Request $request)
    {
    	
    //echo bcrypt('123456');
    //exit;	


    	
      $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');


		$remember_me = $request->has('remember') ? true : false; 
		
         if (Auth::attempt($credentials, $remember_me)) {

            if(Auth::user()->status=='0'){
                \Auth::logout();
                return redirect('/admin')->withErrors(trans('words.account_banned'));
            }

            return $this->handleUserWasAuthenticated($request);
        }

       // return array("errors" => 'The email or the password is invalid. Please try again.');
        //return redirect('/admin');
       return redirect('/admin')->withErrors(trans('words.email_password_invalid'));
        
    }
    
     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request)
    {

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        if(Auth::user()->usertype=='Admin' OR Auth::user()->usertype=='Sub_Admin')
        {
            return redirect('admin/dashboard'); 
        }
        else
        {

            $user_id=Auth::user()->id;
            /***Save Device***/
            $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

            $dd = new DeviceDetector($userAgent);

            $dd->parse();

            if ($dd->isBot()) {
              // handle bots,spiders,crawlers,...
              $botInfo = $dd->getBot();
            } else {
              $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
              $osInfo = $dd->getOs();
              $device = $dd->getDeviceName();
              $brand = $dd->getBrandName();
              $model = $dd->getModel();

                
            if($brand)
              {
                $user_device_name= $brand.' '.$model.' '.$osInfo['platform'].' '.$device;
              }
              else
              {
                $user_device_name= $osInfo['name'].$osInfo['version'].' '.$osInfo['platform'].' '.$device;
              }

                //Save History
                $user_device_obj = new UsersDeviceHistory;

                $user_device_obj->user_id = $user_id;
                $user_device_obj->user_device_name=$user_device_name;   
                $user_device_obj->user_session_name=Session::getId();   
                $user_device_obj->save();

            }

            /***Save Device End***/
            return redirect('dashboard'); 
        }
 
    }
    
    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect('admin/');
    }
    	
}
