<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Language;
use App\Genres;
use App\ActorDirector;
use App\Movies;
use App\Series;
use App\Season; 
use App\Episodes; 
use App\Sports;
use App\SportsCategory;
use App\LiveTV;
use App\TvCategory;
use App\Slider;
use App\HomeSections;
use App\SubscriptionPlan;
use App\PaymentGateway;
use App\Pages;
use App\Coupons;
use App\Watchlist;
use App\RecentlyWatched;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str; 

class ActionsController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
          
    }
 

    public function ajax_status(Request $request)
    {  
       
       //$data =  \Request::except(array('_token'));

        $inputs = $request->all(); 
        //dd($inputs);exit;

        $post_id=$inputs['id'];
        $value=$inputs['value'];
        $action_for=$inputs['action_for'];
        
        if($action_for=="lang_status")
        {

            $data_obj = Language::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="genres_status")
        {

            $data_obj = Genres::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="movie_status")
        {

            $data_obj = Movies::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="shows_status")
        {

            $data_obj = Series::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="season_status")
        {

            $data_obj = Season::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="episode_status")
        {

            $data_obj = Episodes::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="sports_status")
        {

            $data_obj = Sports::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="sports_cat_status")
        {

            $data_obj = SportsCategory::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="livetv_status")
        {

            $data_obj = LiveTV::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="livetv_cat_status")
        {

            $data_obj = TvCategory::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="slider_status")
        {

            $data_obj = Slider::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="home_sec_status")
        {

            $data_obj = HomeSections::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else if($action_for=="payment_status")
        {

            $data_obj = PaymentGateway::findOrFail($post_id);        
     
            if($value=="true")
            {
                $data_obj->status = 1; 
 
            }
            else
            {
                $data_obj->status = 0; 
            }        
             
            $data_obj->save();             
            $response['status'] = 1;
            
        }
        else
        {
            $response['status'] = 0;
        }     

        echo json_encode($response);
        exit;   
    }

    public function ajax_delete(Request $request)
    {  
        
        $inputs = $request->all(); 
        //dd($inputs);exit;

        if(!isset($inputs['id']))
        {
            $response['status'] = 0;           
              
            echo json_encode($response);
            exit;

        }
        
        if(is_array($inputs['id']))
        {
            $post_ids=$inputs['id'];
        }
        else
        {
            $post_id=$inputs['id'];
        }

        //echo $post_id;exit;
         
        //$post_id=$inputs['id'];
        $action_for=$inputs['action_for'];
        
        if($action_for=="lang_delete")
        {
            $data_obj = Language::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="genres_delete")
        {
            $data_obj = Genres::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="movies_delete")
        {
            $recently_obj = RecentlyWatched::where('video_type','Movies')->where('video_id',$post_id)->delete();

            $watchlist_obj = Watchlist::where('post_type','Movies')->where('post_id',$post_id)->delete();     

            $data_obj = Movies::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="movies_delete_selected")
        {
            foreach($post_ids as $pid){
                
                $recently_obj = RecentlyWatched::where('video_type','Movies')->where('video_id',$pid)->delete();

                $watchlist_obj = Watchlist::where('post_type','Movies')->where('post_id',$pid)->delete();

                $data_obj = Movies::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="shows_delete")
        {
           $season_obj = Season::where('series_id',$post_id)->delete();
           $episodes_obj = Episodes::where('episode_series_id',$post_id)->delete();

            $data_obj = Series::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="shows_delete_selected")
        {
            foreach($post_ids as $pid){
                
               $season_obj = Season::where('series_id',$pid)->delete();
               $episodes_obj = Episodes::where('episode_series_id',$pid)->delete();

                $data_obj = Series::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="season_delete")
        {   
            $episodes_obj = Episodes::where('episode_season_id',$post_id)->delete();

            $data_obj = Season::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="season_delete_selected")
        {
            foreach($post_ids as $pid){
                 
               $episodes_obj = Episodes::where('episode_season_id',$pid)->delete();

                $data_obj = Season::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="episodes_delete")
        {
            $recently_obj = RecentlyWatched::where('video_type','Episodes')->where('video_id',$post_id)->delete();

            $watchlist_obj = Watchlist::where('post_type','Episodes')->where('post_id',$post_id)->delete();

            $data_obj = Episodes::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="episodes_delete_selected")
        {
            foreach($post_ids as $pid){
                
                $recently_obj = RecentlyWatched::where('video_type','Episodes')->where('video_id',$pid)->delete();

                $watchlist_obj = Watchlist::where('post_type','Episodes')->where('post_id',$pid)->delete();
                
                $data_obj = Episodes::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="actors_delete")
        {
            $data_obj = ActorDirector::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="actors_delete_selected")
        {
            foreach($post_ids as $pid){
 
                $data_obj = ActorDirector::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="sports_cat_delete")
        {
            $data_obj = SportsCategory::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="sports_delete")
        {
            $recently_obj = RecentlyWatched::where('video_type','Sports')->where('video_id',$post_id)->delete();

            $watchlist_obj = Watchlist::where('post_type','Sports')->where('post_id',$post_id)->delete();

            $data_obj = Sports::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="sports_delete_selected")
        {
            foreach($post_ids as $pid){
                
                $recently_obj = RecentlyWatched::where('video_type','Sports')->where('video_id',$pid)->delete();

                $watchlist_obj = Watchlist::where('post_type','Sports')->where('post_id',$pid)->delete();
                
                $data_obj = Sports::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="livetv_cat_delete")
        {
            $data_obj = TvCategory::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="livetv_delete")
        {
            $recently_obj = RecentlyWatched::where('video_type','LiveTV')->where('video_id',$post_id)->delete();

            $watchlist_obj = Watchlist::where('post_type','LiveTV')->where('post_id',$post_id)->delete();

            $data_obj = LiveTV::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="livetv_delete_selected")
        {
            foreach($post_ids as $pid){
                 
                $recently_obj = RecentlyWatched::where('video_type','LiveTV')->where('video_id',$pid)->delete();

                $watchlist_obj = Watchlist::where('post_type','LiveTV')->where('post_id',$pid)->delete();

                $data_obj = LiveTV::findOrFail($pid);
                $data_obj->delete();

            }
            
            $response['status'] = 1;
        }
        else if($action_for=="slider_delete")
        {
            $data_obj = Slider::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="home_sec_delete")
        {
            $data_obj = HomeSections::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="plan_delete")
        {
            $data_obj = SubscriptionPlan::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }        
        else if($action_for=="page_delete")
        {
            if($post_id!=5)
            {
                $data_obj = Pages::findOrFail($post_id);
                $data_obj->delete(); 
                
                $response['status'] = 1;    
            }
            else
            {
                $response['status'] = 0;    
            }        
        }
        else if($action_for=="user_delete")
        {
            if($post_id==1)
            { 
                $response['status'] = 0;
            }
            else
            { 
                //Change Status
                $user_obj = User::findOrFail($post_id); 
                $user_obj->status=0;
                $user_obj->save(); 

                $data_obj = User::findOrFail($post_id);
                $data_obj->delete(); 
             
                $response['status'] = 1;     
            }
                   
        }
        else if($action_for=="coupon_delete")
        {
            $data_obj = Coupons::findOrFail($post_id);
            $data_obj->delete(); 
             
            $response['status'] = 1;            
        }
        else if($action_for=="user_restore")
        {
            //$data_obj = User::find($post_id);
            $data_obj = User::onlyTrashed()->where('id', $post_id)->restore();
            
             //Change Status
             $user_obj = User::findOrFail($post_id); 
             $user_obj->status=1;
             $user_obj->save(); 
              
            $response['status'] = 1;            
        }
        else if($action_for=="permanent_user_delete")
        {
            if($post_id==1)
            { 
                $response['status'] = 0;
            }
            else
            {
                $watchlist_obj = Watchlist::where('user_id',$post_id)->delete();                
                $recently_obj = RecentlyWatched::where('user_id',$post_id)->delete();

                $data_obj = User::onlyTrashed()->find($post_id);

                $data_obj->forceDelete(); 
                  
                $response['status'] = 1;     
            }
                   
        }   
        else
        {
            $response['status'] = 0;            
        }     

        echo json_encode($response);
        exit;    
             
    }
     
}
