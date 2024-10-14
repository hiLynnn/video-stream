<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Series;
use App\Genres;
use App\Language;
use App\ActorDirector;
use App\Episodes;
use App\Season;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class SeriesController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		check_verify_purchase();  
    }
    public function series_list()    { 
        
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
        {

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('dashboard');
            
         }

        $page_title=trans('words.shows_text');

        $language_list = Language::orderBy('language_name')->get(); 
        
        $genres_list = Genres::orderBy('genre_name')->get();
        
         if(isset($_GET['s']))
        {
            $keyword = $_GET['s'];  
            $series_list = Series::where("series_name", "LIKE","%$keyword%")->orderBy('series_name')->paginate(12);

            $series_list->appends(\Request::only('s'))->links();
        }    
        else if(isset($_GET['language_id']))
        {
            $language_id = $_GET['language_id'];
            $series_list = Series::where("series_lang_id", "=",$language_id)->orderBy('id','DESC')->paginate(12);

            $series_list->appends(\Request::only('language_id'))->links();
        }
        else if(isset($_GET['genres_id']))
        {
            $genres_id = $_GET['genres_id'];
            $series_list = Series::whereRaw("find_in_set('$genres_id',series_genres)")->orderBy('id','DESC')->paginate(12);

            $series_list->appends(\Request::only('genres_id'))->links();
        }
        else
        {

            $series_list = Series::orderBy('id','DESC')->paginate(12);

        }
         
        return view('admin.pages.shows.list',compact('page_title','series_list','language_list','genres_list'));
    }
    
    public function addSeries()    { 
        
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
        {

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('dashboard');
            
         }

        $page_title=trans('words.add_show');

        $language_list = Language::orderBy('language_name')->get();
        $genre_list = Genres::orderBy('genre_name')->get();

        $actor_list = ActorDirector::where('ad_type','actor')->orderBy('ad_name')->get();
        $director_list = ActorDirector::where('ad_type','director')->orderBy('ad_name')->get();

        return view('admin.pages.shows.addedit',compact('page_title','language_list','genre_list','actor_list','director_list'));
    }
    
    public function addnew(Request $request)
    { 
        
        $data =  \Request::except(array('_token')) ;
        
        if(!empty($inputs['id'])){
                
                $rule=array(
                'language' => 'required',
                'series_genres' => 'required',
                'series_name' => 'required'                
                 );
        }else
        {
            $rule=array(
                'language' => 'required',
                'series_genres' => 'required',
                'series_name' => 'required',
                'series_poster' => 'required'                
                 );
        }

        
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withInput()->withErrors($validator->messages());
        } 
        $inputs = $request->all();
        
        if(!empty($inputs['id'])){
           
            $series_obj = Series::findOrFail($inputs['id']);

        }else{

            $series_obj = new Series;

        }

         $series_slug = Str::slug($inputs['series_name'], '-',null);

         $series_obj->upcoming = $inputs['upcoming'];
         $series_obj->series_access = $inputs['series_access'];
         
         $series_obj->series_lang_id = $inputs['language'];
         $series_obj->series_genres = implode(',', $inputs['series_genres']);
         $series_obj->series_name = addslashes($inputs['series_name']);
         $series_obj->series_slug = $series_slug;
         $series_obj->series_info = addslashes($inputs['series_info']);
         
         if(isset($inputs['poster_link']) && $inputs['poster_link']!='')
         {
             $s_image_source           =   $inputs['poster_link'];
             $s_save_to                =   public_path('/upload/images/'.$inputs['series_poster']);
             grab_image($s_image_source,$s_save_to);

            $series_obj->series_poster = 'upload/images/'.$inputs['series_poster'];
 
         }
         else
         {
            $series_obj->series_poster = $inputs['series_poster'];

         }

         $series_obj->status = $inputs['status']; 

         

         if(isset($inputs['actors_id']))
         {
            $series_obj->actor_id = implode(',', $inputs['actors_id']);
         }
         else
         {
            $series_obj->actor_id = null;
         }
         
         if(isset($inputs['director_id']))
         {
            $series_obj->director_id = implode(',', $inputs['director_id']);
         }
         else
         {
            $series_obj->director_id = null;
         }

          
         $series_obj->imdb_id = $inputs['imdb_id'];
         $series_obj->imdb_rating = $inputs['imdb_rating'];
         $series_obj->imdb_votes = $inputs['imdb_votes'];

         $series_obj->content_rating = $inputs['content_rating'];

         $series_obj->seo_title = addslashes($inputs['seo_title']);  
         $series_obj->seo_description = addslashes($inputs['seo_description']);  
         $series_obj->seo_keyword = addslashes($inputs['seo_keyword']);  
         
         if(!empty($inputs['id']) AND $inputs['status']==0)
         {
            $series_id = $inputs['id'];

            $get_all_episodes = Episodes::where('episode_series_id',$series_id)->get();  
            
            foreach ($get_all_episodes as $episodes_data) 
            {
                $episode_video_id=$episodes_data->id;

                DB::table("recently_watched")
                    ->where("video_type", "=", "Episodes")
                    ->where("video_id", "=", $episode_video_id)
                    ->delete();

            }
 
         }

         $series_obj->save();


         //When Series Import From IMDb first time
         $series_id = $series_obj->id;

         if(empty($inputs['id']) AND $inputs['tmdb_id']!=""){

            $get_tmdb_id= $inputs['tmdb_id']; 

            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3/tv/$get_tmdb_id?append_to_response=videos",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlOTg2MGZhMTE3NGQyZjgxNjU4ZGJlMmJiNjViNzdkNCIsInN1YiI6IjY0NWI2ZmM0ZmUwNzdhNWNhZGY3MDY1MSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.87ccv8sWiYaaze3POtbiwvyiBjDJ1qGdkC4PC8iPxy4",
                "accept: application/json"
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $result= json_decode($response);

            $videos_length = count($result->videos->results);

            for($cn=0;$cn<= $videos_length;$cn++)
            {
                if(isset($result->videos->results[$cn]->type) AND $result->videos->results[$cn]->type == "Trailer")
                {
                    $trailer_id= $result->videos->results[$cn]->key;            
                    break;
                }

            }

            $seasons_trailer = isset($trailer_id)?$trailer_id:"";
              
            foreach($result->seasons as $seasons)
            {         
                $season_name=  $seasons->name;
                  
                $season_poster_path = 'https://image.tmdb.org/t/p/w300'.$seasons->poster_path;
 
                $season_poster_name = parse_url($season_poster_path, PHP_URL_PATH);

                $season_image_source           =   $season_poster_path;
                $season_save_to                =   public_path('/upload/images/'.basename($season_poster_name));
                
                grab_image($season_image_source,$season_save_to);
 
                
                $season_obj = new Season;

                $season_slug = Str::slug($season_name, '-');

                $season_obj->series_id = $series_id;
                $season_obj->season_name = addslashes($season_name);
                $season_obj->season_slug = $season_slug;
                $season_obj->season_poster = 'upload/images/'.basename($season_poster_name);
                
                if($seasons_trailer!="")
                {
                    $season_obj->trailer_url = 'https://www.youtube.com/watch?v='.$seasons_trailer;
                }
                else
                {
                    $season_obj->trailer_url =NULL;  
                }
               

                $season_obj->status = 1;

                $season_obj->save();
                
            }
             
         }
         
        
        if(!empty($inputs['id'])){

            \Session::flash('flash_message', trans('words.successfully_updated'));

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', trans('words.added'));

            return \Redirect::back();

        }            
        
         
    }     
   
    
    public function editSeries($series_id)    
    {       
          if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
             }    

          $page_title=trans('words.edit_show');

          $series_info = Series::findOrFail($series_id);

          $language_list = Language::orderBy('language_name')->get();
          $genre_list = Genres::orderBy('genre_name')->get();   

          $actor_list = ActorDirector::where('ad_type','actor')->orderBy('ad_name')->get();
          $director_list = ActorDirector::where('ad_type','director')->orderBy('ad_name')->get();

          return view('admin.pages.shows.addedit',compact('page_title','series_info','language_list','genre_list','actor_list','director_list'));
        
    }	 
    
    public function delete($series_id)
    {
    	if(Auth::User()->usertype=="Admin" OR Auth::User()->usertype=="Sub_Admin")
        {
        	
            $series_obj = Series::findOrFail($series_id);
            $series_obj->delete();

            \Session::flash('flash_message', trans('words.deleted'));
            return redirect()->back();
        }
        else
        {
            \Session::flash('flash_message', trans('words.access_denied'));
            return redirect('admin/dashboard');            
        
        }
    }

     
     
    	
}
