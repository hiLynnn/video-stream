<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;
use Session;
use App\UsersDeviceHistory;

require(base_path() . '/public/device-detector/vendor/autoload.php');
use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

class FacebookController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
    
            $user = Socialite::driver('facebook')->user();

            //print_r($user);
             
            $facebook_id= $user->id;
            $user_name= $user->name;
            $user_email= $user->email?$user->email:$facebook_id.'@facebook.com';
             
            $finduser = User::where('facebook_id', $facebook_id)->orwhere('email', $user_email)->first();
     
            if($finduser){
     
                Auth::login($finduser);

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
    
                return redirect('/dashboard');
     
            }else{
                
                $newUser = User::create([
                    'name' => $user_name,
                    'email' => $user_email,
                    'password' => bcrypt('123456dummy')
                ]);
    
                Auth::login($newUser);

                $user_id=$newUser->id;

                $user = User::findOrFail($user_id);

                $user->facebook_id = $facebook_id;
                $user->save(); 

                 
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
     
                return redirect('/dashboard');
            }
    
        } catch (Exception $e) {
            //dd($e->getMessage());

            Session::flash('login_flash_error', 'Login failed');
            return redirect('/login');
        }
    }
}
