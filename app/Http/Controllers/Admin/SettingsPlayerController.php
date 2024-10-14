<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Player;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 

class SettingsPlayerController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');          
         
    }
    public function player_settings()
    { 
    	if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('admin/dashboard');
            
        }

        $page_title=trans('words.player_settings');
        
        $settings = Player::findOrFail('1');
 
        
        return view('admin.pages.settings.player',compact('page_title','settings'));
    }	 
    
    public function update_player_settings(Request $request)
    {  
    	  
    	$settings = Player::findOrFail('1');
 
	    
	    $data =  \Request::except(array('_token')) ;
	    
	      

	    $inputs = $request->all();

         
		$settings->player_style = $inputs['player_style'];
        $settings->player_vector_icons = $inputs['player_vector_icons'];  
        $settings->autoplay = $inputs['autoplay'];
        //$settings->pip_mode = $inputs['pip_mode'];
        $settings->rewind_forward = $inputs['rewind_forward'];

		$settings->player_watermark = $inputs['player_watermark'];
        $settings->player_logo = $inputs['player_logo'];
        $settings->player_logo_position = $inputs['player_logo_position'];  
        $settings->player_url = $inputs['player_url'];
        
        $settings->player_default_ads = $inputs['player_default_ads'];
		  
	    $settings->save(); 
        
 
	    Session::flash('flash_message', trans('words.successfully_updated'));

        return redirect()->back();
    }


    public function player_ad_settings()
    { 
    	if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('admin/dashboard');
            
        }

        $page_title=trans('words.player_ad_settings');
        
        $settings = Player::findOrFail('1');
 
        
        return view('admin.pages.settings.player_ads',compact('page_title','settings'));
    }	 
    
    public function update_player_ad_settings(Request $request)
    {  
    	  
    	$settings = Player::findOrFail('1');
 
	    
	    $data =  \Request::except(array('_token')) ;
	    
	      

	    $inputs = $request->all();
 
        $settings->vast_type = $inputs['vast_type'];

        if($inputs['vast_type']=="Local")
        {
            $settings->vast_url = $inputs['ad_video_local'];
        }
        else
        {
            $settings->vast_url = $inputs['ad_video_url'];
        }

        $settings->custom_ad1_source = $inputs['custom_ad1_source'];
        $settings->custom_ad1_timestart = $inputs['custom_ad1_timestart'];
        $settings->custom_ad1_link = $inputs['custom_ad1_link'];
        
        $settings->custom_ad2_source = $inputs['custom_ad2_source'];
        $settings->custom_ad2_timestart = $inputs['custom_ad2_timestart'];
        $settings->custom_ad2_link = $inputs['custom_ad2_link'];

        $settings->custom_ad3_source = $inputs['custom_ad3_source'];
        $settings->custom_ad3_timestart = $inputs['custom_ad3_timestart'];
        $settings->custom_ad3_link = $inputs['custom_ad3_link'];
        
		  
	    $settings->save(); 
        
 
	    Session::flash('flash_message', trans('words.successfully_updated'));

        return redirect()->back();
    }
     
}
