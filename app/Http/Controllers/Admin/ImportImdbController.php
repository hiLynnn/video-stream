<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Language;
use App\Genres;
use App\ActorDirector;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str; 

class ImportImdbController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');	
         
    }

    public function find_imdb_movie()
    { 
        $movie_id= $_GET['id'];
    
        $default_language=set_tmdb_language();
         
        //For Movies Details
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/$movie_id?language=$default_language&append_to_response=videos,credits",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer ".getcong('tmdb_api_key'),
            "accept: application/json"
        ],
        ]);

        $response_obj = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $result= json_decode($response_obj);
 

        if(isset($result))
        {   

            $response['imdb_status']    = 'success';             
            $response['imdbid']         = $result->imdb_id;
            $response['imdb_rating']         = round($result->vote_average,1);
            $response['imdb_votes']         = '';

            $response['title']          = $result->title;

            $minutes = $result->runtime;

            $hours = floor($minutes / 60);
            $min = $minutes - ($hours * 60);

            $response['runtime']        = $hours."h ".$min."m";
            $response['released']       = date('m/d/Y',strtotime($result->release_date));

            //Get Lang
            $lang_list=$result->spoken_languages[0]->english_name;
            $response['language']          = Language::getLanguageID($lang_list);   
            
            //Get Genre
            //$genre_names          = $result->genres;

            foreach($result->genres as $gname)
            { 
                $genre[]= Genres::getGenresID($gname->name);
            }

            //print_r($genre);
            //exit;

            $response['genre']=$genre;

            //$cast_result= json_decode($cast_response);

            $cast_length = count($result->credits->cast);

            for($cn=0;$cn<= 10;$cn++)
            {   
                if(isset($result->credits->cast[$cn]))
                {
                $a_id = $result->credits->cast[$cn]->id;
                $a_name = $result->credits->cast[$cn]->original_name;
                 
                $ad_info = ActorDirector::where('ad_name',$a_name)->where('ad_type','actor')->first();

                if(!$ad_info)
                {
                    //Get Actor Details
                    $curl1 = curl_init();

                    curl_setopt_array($curl1, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/person/$a_id?language=$default_language",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Bearer ".getcong('tmdb_api_key'),
                        "accept: application/json"
                    ],
                    ]);

                    $actor_response = curl_exec($curl1);
                    $err1 = curl_error($curl1);

                    curl_close($curl1);

                    $actor_result= json_decode($actor_response); 
                    
                    $ad_bio = $actor_result->biography;
                    $ad_birthdate = $actor_result->birthday;
                    $ad_place_of_birth = $actor_result->place_of_birth;

                    //Get Actor Details End

                    $ad_obj = new ActorDirector;
        
                    $ad_slug = Str::slug($a_name, '-',null);

                    $ad_obj->ad_type = 'actor'; 
                    $ad_obj->ad_name = addslashes($a_name); 
                    $ad_obj->ad_bio = addslashes($ad_bio); 
                    $ad_obj->ad_birthdate = strtotime($ad_birthdate); 
                    $ad_obj->ad_place_of_birth = addslashes($ad_place_of_birth); 
                    $ad_obj->ad_tmdb_id = $a_id; 
                    $ad_obj->ad_slug = $ad_slug;

                    if($result->credits->cast[$cn]->profile_path!="")
                    {
                        $cast_profile_path = 'https://image.tmdb.org/t/p/w300'.$result->credits->cast[$cn]->profile_path;
 
                        $cast_file_name = parse_url($cast_profile_path, PHP_URL_PATH);
     
                        $cast_image_source           =   $cast_profile_path;
                        $cast_save_to                =   public_path('/upload/images/'.basename($cast_file_name));
                        
                        grab_image($cast_image_source,$cast_save_to);
    
                        $ad_obj->ad_image = 'upload/images/'.basename($cast_file_name);
                    }
                     
                    
                    $ad_obj->save();
                }                 
 
                $a_id=ActorDirector::getActorDirectorID($a_name);

                $actors_names[]="<option value='".$a_id."' selected>$a_name</option>";
                }
            }

            $response['actors']=$actors_names;

            $crew_length = count($result->credits->crew);
 
            for($cn=0;$cn<= $crew_length;$cn++)
            {
                //echo $crew_result->crew[$cn]->job;
                if(isset($result->credits->crew[$cn]->job) AND $result->credits->crew[$cn]->job == "Director")
                {
                        $d_id = $result->credits->cast[$cn]->id;
                        $d_name =  $result->credits->crew[$cn]->name;
                        
                        //Add Director
                        $ad_info = ActorDirector::where('ad_name',addslashes($d_name))->where('ad_type','director')->first();

                        if(!$ad_info)
                        {
                            //Get Actor Details
                            $curl2 = curl_init();

                            curl_setopt_array($curl2, [
                            CURLOPT_URL => "https://api.themoviedb.org/3/person/$d_id?language=$default_language",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => [
                                "Authorization: Bearer ".getcong('tmdb_api_key'),
                                "accept: application/json"
                            ],
                            ]);

                            $director_response = curl_exec($curl2);
                            $err1 = curl_error($curl2);

                            curl_close($curl2);

                            $director_result= json_decode($director_response); 
                            
                            $ad_bio = $director_result->biography;
                            $ad_birthdate = $director_result->birthday;
                            $ad_place_of_birth = $director_result->place_of_birth;

                            //Get Actor Details End

                            $ad_obj = new ActorDirector;
                
                            $ad_slug = Str::slug($d_name, '-',null);

                            $ad_obj->ad_type = 'director'; 
                            $ad_obj->ad_name = addslashes($d_name); 
                            $ad_obj->ad_bio = addslashes($ad_bio); 
                            $ad_obj->ad_birthdate = strtotime($ad_birthdate); 
                            $ad_obj->ad_place_of_birth = addslashes($ad_place_of_birth); 
                            $ad_obj->ad_tmdb_id = $d_id; 
                            $ad_obj->ad_slug = $ad_slug;

                          
                        if($result->credits->crew[$cn]->profile_path!="")
                        {
                            $crew_profile_path = 'https://image.tmdb.org/t/p/w300'.$result->credits->crew[$cn]->profile_path;

                            $crew_file_name = parse_url($crew_profile_path, PHP_URL_PATH);
    
                            $crew_image_source           =   $crew_profile_path;
                            $crew_save_to                =   public_path('/upload/images/'.basename($crew_file_name));
                            
                            grab_image($crew_image_source,$crew_save_to);

                            $ad_obj->ad_image = 'upload/images/'.basename($crew_file_name);
                        }
                        
                        
                        $ad_obj->save();
                    }                 

 
                    $d_id=ActorDirector::getActorDirectorID($d_name);

                    $director_names[]="<option value='".$d_id."' selected>$d_name</option>";
                }
                else
                {
                        $director_names[]='';
                }
                
            }
             
            $response['director']=$director_names;
 
            $response['plot']  = $result->overview;
 
            $poster_path = 'https://image.tmdb.org/t/p/w300'.$result->poster_path.'?language='.$default_language;
            
            $get_file_name = parse_url($poster_path, PHP_URL_PATH);

            $response['thumbnail']          = $poster_path;
            $response['thumbnail_name']  =basename($get_file_name);


            $backdrop_path = 'https://image.tmdb.org/t/p/w780'.$result->backdrop_path.'?language='.$default_language;

            $backdrop_file_name = parse_url($backdrop_path, PHP_URL_PATH);

            $response['poster']          = $backdrop_path;
            $response['poster_name']  =basename($backdrop_file_name);

            //Get Trailer
            $videos_length = count($result->videos->results);

            for($vn=0;$vn<= $videos_length;$vn++)
            {
                if(isset($result->videos->results[$vn]->type) AND $result->videos->results[$vn]->type == "Trailer")
                {
                    $response['trailer_url'] = 'https://www.youtube.com/watch?v='.$result->videos->results[$vn]->key;
                }                 
            }

        }
        else
        {
            $response['imdb_status']    = 'fail';
        }
        //echo $obj->Title;
         //echo $_GET['id'];

         echo json_encode($response);
         exit;
    }
 
}
