<?php
namespace App\Http\Controllers;

use App\ComboVideo;
use App\Episodes;
use Auth;
use App\User;
use App\Slider;
use App\Series;
use App\Movies;
use App\HomeSections;
use App\Sports;
use App\Pages;
use App\RecentlyWatched;
use App\LiveTV;
use App\UsersDeviceHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
require(base_path() . '/public/device-detector/vendor/autoload.php');
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);
class IndexController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function getViewVideo(string $slug,int $id){
        $movie = Movies::where("id", $id)->where('video_slug',$slug)->first();
        $combo = ComboVideo::where('ref_id', $id)->first();
        $video_current = null;
        if(!blank($movie )){
            $video_current = [
                "id" => $movie->id,
                "video_slug" => $movie->video_slug,
                "video_url" => $movie->video_url,
                "video_image" => $movie->video_image,
                "video_image_thumb" => $movie->video_image_thumb,
                "name" => $movie->video_title,
                "is_serie" => false,
                "url" => route('public.view-video',['slug'=> $movie->video_slug,'id'=> $movie->id]),
                "except_id"=>  $combo?->id ?? 0,
                "url_get_info" => route('api.get-video-info', ["id"=> $combo?->id]),
            ];
        }
        return view('pages.index',compact('video_current'));
    }

    public function getViewSerie(string $slug,int $serie_id,int $episode_id){
        $episode = Episodes::where("id", $episode_id)->where("episode_series_id", $serie_id)->first();
        $combo = ComboVideo::where('ref_id', $serie_id)->first();
        $video_current = null;
        if(!blank($episode )){
            $video_current = [
                "id" => $episode->id,
                "video_slug" => $episode->video_slug,
                "video_url" => $episode->video_url,
                "video_image" => $episode->video_image,
                "video_image_thumb" => $episode->video_image,
                "name" => $episode->video_title,
                "is_serie" => true,
                "url_get_info" => route('api.get-video-info', ["id"=> $combo?->id]),
                "url" => route('public.view-series',['slug'=> $episode->video_slug,'id'=> $serie_id,'episode'=> $episode_id]),
                "except_id"=>  $combo?->id ?? 0
            ];
        }
        return view('pages.index',compact('video_current'));
    }
    public function searchVideo(Request $request)
    {
        $query = request()->input('q');
    
   
        if (blank($query)) {
            return redirect()->back()->withErrors('Please enter a search term.');
        }
    
   
        $movies = Movies::where('video_title', 'LIKE', '%' . $query . '%')
                        ->orWhere('video_slug', 'LIKE', '%' . $query . '%')
                        ->first();
    

        $series = Series::where('series_name', 'LIKE', '%' . $query . '%')
                        ->first();

        $video_current = null;

        if($movies){
                $video_current = [
                    "id" => $movies->id,
                    "video_slug" => $movies->video_slug,
                    "video_url" => $movies->video_url,
                    "video_image" => $movies->video_image,
                    "video_image_thumb" => $movies->video_image_thumb,
                    "name" => $movies->video_title,
                    "is_serie" => false,
                    "url" => route('public.view-video', ['slug' => $movies->video_slug, 'id' => $movies->id]),
                    "except_id"=> 0,
                    "url_get_info" => route('api.get-video-info', ["id"=> $movies?->id]),
                ];
        }
    
        if($series){
            $episodes = Episodes::where('episode_series_id', $series->id)->first();
            if($episodes){
                $video_current = [
                    "id" => $episodes->id,
                    "video_slug" => $episodes->video_slug,
                    "video_url" => $episodes->video_url,
                    "video_image" => $episodes->video_image,
                    "video_image_thumb" => $episodes->video_image,
                    "name" => $episodes->video_title,
                    "is_serie" => true,
                    "url_get_info" => route('api.get-video-info', ["id" => $series->id]),
                    "url" => route('public.view-series', ['slug' => $episodes->video_slug, 'id' => $series->id, 'episode' => $episodes->id]),
                    "except_id"=> 0,
                ];
            }
            else{
                return view('pages.index', [
                    'video_current' => $video_current,
                    'not_found' => 'Không tìm thấy video',
                ]);
            }
        }
    
        return view('pages.index', compact('video_current'));
    }
    


    public function oldIndex()
    {
        // if(!$this->alreadyInstalled())
        // {
        //     return redirect('public/install');
        // }

    	$slider= Slider::where('status',1)->whereRaw("find_in_set('Home',slider_display_on)")->orderby('id','DESC')->get();

        if(Auth::check())
        {
            $current_user_id=Auth::User()->id;

            if(getcong('menu_movies')==0 AND getcong('menu_shows')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Movies')->where('video_type','!=','Episodes')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_sports')==0 AND getcong('menu_livetv')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Sports')->where('video_type','!=','LiveTV')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_livetv')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','LiveTV')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_sports')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Sports')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_movies')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Movies')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_shows')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Episodes')->orderby('id','DESC')->get();
            }
            else
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->orderby('id','DESC')->get();
            }

        }
        else
        {
            $recently_watched = array();
        }

        $upcoming_movies = Movies::where('upcoming',1)->orderby('id','DESC')->get();
        $upcoming_series = Series::where('upcoming',1)->orderby('id','DESC')->get();
        // dd($upcoming_movies->count());
        //dd($upcoming_movies);exit;

        $home_sections = HomeSections::where('status',1)->orderby('id')->get();

        return view('pages.index-old',compact('slider','recently_watched','upcoming_movies','upcoming_series','home_sections'));

    }


    public function home_collections($slug, $id)
    {
        $home_section = HomeSections::where('id',$id)->where('status',1)->first();

        //echo $home_section->post_type;exit;

        if($home_section->post_type=="Movie")
        {
            return view('pages.home.movies',compact('home_section'));
        }
        else if($home_section->post_type=="Shows")
        {
            return view('pages.home.shows',compact('home_section'));
        }
        else if($home_section->post_type=="LiveTV")
        {
            return view('pages.home.livetv',compact('home_section'));
        }
        else if($home_section->post_type=="Sports")
        {
            return view('pages.home.sports',compact('home_section'));
        }
        else
        {
            return view('pages.home_section',compact('home_section'));
        }

    }

    public function alreadyInstalled()
    {

        return file_exists(base_path('/public/.lic'));
    }

    public function search_elastic()
    {
        $keyword = $_GET['s'];

        if(getcong('menu_movies'))
        {
            $s_movies_list = Movies::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

        }
        else
        {
            $s_movies_list =array();
        }

        if(getcong('menu_shows'))
        {
            $s_series_list = Series::where('status',1)->where("series_name", "LIKE","%$keyword%")->orderBy('series_name')->get();
        }
        else
        {
            $s_series_list=array();
        }

        if(getcong('menu_sports'))
        {
            $s_sports_list = Sports::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();
        }
        else
        {
            $s_sports_list=array();
        }

        if(getcong('menu_livetv'))
        {
            $live_tv_list = LiveTV::where('status',1)->where("channel_name", "LIKE","%$keyword%")->orderBy('channel_name')->get();
        }
        else
        {
            $live_tv_list=array();
        }


        return view('_particles.search_elastic',compact('s_movies_list','s_series_list','s_sports_list','live_tv_list'));

    }

    public function search()
    {
        $keyword = $_GET['s'];

        $movies_list = Movies::where('status',1)->where('upcoming',0)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

        $series_list = Series::where('status',1)->where('upcoming',0)->where("series_name", "LIKE","%$keyword%")->orderBy('series_name')->get();

        $sports_video_list = Sports::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

        $live_tv_list = LiveTV::where('status',1)->where("channel_name", "LIKE","%$keyword%")->orderBy('channel_name')->get();

        return view('pages.search',compact('movies_list','series_list','sports_video_list','live_tv_list'));
    }

    public function sitemap()
    {
        return response()->view('pages.sitemap')->header('Content-Type', 'text/xml');
    }

    public function sitemap_misc()
    {
        $pages_list = Pages::where('status',1)->orderBy('id')->get();

        return response()->view('pages.sitemap_misc',compact('pages_list'))->header('Content-Type', 'text/xml');
    }


    public function sitemap_movies()
    {
        $movies_list = Movies::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_movies',compact('movies_list'))->header('Content-Type', 'text/xml');
    }

    public function sitemap_show()
    {
        $series_list = Series::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_show',compact('series_list'))->header('Content-Type', 'text/xml');
    }

    public function sitemap_sports()
    {
        $sports_video_list = Sports::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_sports',compact('sports_video_list'))->header('Content-Type', 'text/xml');
    }

    public function sitemap_livetv()
    {
        $live_list = LiveTV::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_livetv',compact('live_list'))->header('Content-Type', 'text/xml');
    }

    public function login()
    {
        if (Auth::check()) {

            return redirect('dashboard');
        }

        return view('pages.user.login');
    }

    public function postLogin(Request $request)
    {


        $data =  \Request::except(array('_token'));
        $inputs = $request->all();

        if(getcong('recaptcha_on_login'))
        {
            $rule=array(
                'email' => 'required|email',
                'password' => 'required',
                'g-recaptcha-response' => 'required'
                 );
        }
        else
        {
            $rule=array(
                'email' => 'required|email',
                'password' => 'required'
                 );
        }

         $validator = \Validator::make($data,$rule);

        if ($validator->fails())
        {
                Session::flash('login_flash_error', 'required');
                return redirect()->back()->withInput()->withErrors($validator->messages());
         }

         //check reCaptcha
          if(getcong('recaptcha_on_login'))
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

            $credentials = $request->only('email', 'password');

            $remember_me = $request->has('remember') ? true : false;

            if (Auth::attempt($credentials, $remember_me)) {

                if(Auth::user()->status=='0' AND Auth::user()->deleted_at!=NULL){
                    \Auth::logout();

                    Session::flash('login_flash_error', 'required');
                    return redirect('/login')->withInput()->withErrors(trans('words.account_delete_msg'));
                }

                if(Auth::user()->status=='0'){
                    \Auth::logout();
                    Session::flash('login_flash_error', 'required');
                    return redirect('/login')->withInput()->withErrors(trans('words.account_banned'));
                 }

                return $this->handleUserWasAuthenticated($request);
            }

            Session::flash('login_flash_error', 'required');
            return redirect('/login')->withInput()->withErrors(trans('words.email_password_invalid'));


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

        /*$previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        */

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


    public function signup()
    {
        return view('pages.user.signup');
    }

    public function postSignup(Request $request)
    {


        $data =  \Request::except(array('_token'));

        $inputs = $request->all();

        if(getcong('recaptcha_on_signup'))
        {
            $rule=array(
                'name' => 'required',
                'email' => 'required|email|max:200|unique:users',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required',
                'g-recaptcha-response' => 'required'
                 );

        }
        else
        {
            $rule=array(
                'name' => 'required',
                'email' => 'required|email|max:200|unique:users',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required'
                 );
        }


         $validator = \Validator::make($data,$rule);

        if ($validator->fails())
        {
                Session::flash('signup_flash_error', 'required');
                return redirect()->back()->withInput()->withErrors($validator->messages());
        }

        //check reCaptcha
        if(getcong('recaptcha_on_signup'))
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

        $user = new User;

        //$confirmation_code = str_random(30);


        $user->usertype = 'User';
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password= bcrypt($inputs['password']);
        $user->save();

        //Welcome Email

        try{
            $user_name=$inputs['name'];
            $user_email=$inputs['email'];

            $data_email = array(
                'name' => $user_name,
                'email' => $user_email
                );

            \Mail::send('emails.welcome', $data_email, function($message) use ($user_name,$user_email){
                $message->to($user_email, $user_name)
                ->from(getcong('site_email'), getcong('site_name'))
                ->subject('Welcome to '.getcong('site_name'));
            });
        }catch (\Throwable $e) {

            \Log::info($e->getMessage());
        }


        Session::flash('signup_flash_message', trans('words.account_created_successfully'));

        return redirect('signup');


    }


    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user_id=Auth::user()->id;

        //Delete session file
        $user_session_name=Session::getId();
        \Session::getHandler()->destroy($user_session_name);

        $user_device_obj = UsersDeviceHistory::where('user_id',$user_id)->where('user_session_name',$user_session_name);
        $user_device_obj->delete();

        Auth::logout();

        return redirect('/');
    }

    public function logout_user_remotely($user_session_name)
    {
        $user_id=Auth::user()->id;

        $user_obj = User::findOrFail($user_id);

        //Push Notification on Mobile
       $content = array("en" => "Logout device remotely");

        $fields = array(
                'app_id' => getcong_app('onesignal_app_id'),
                'included_segments' => array('all'),
                'data' => array("foo" => "bar", "logout_remote"=>"1"),
                'filters' => array(array('field' => 'tag', 'key' => 'user_session', 'relation' => '=', 'value' => $user_session_name)),
                'headings'=> array("en" => getcong_app('app_name')),
                'contents' => $content
            );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.getcong_app('onesignal_rest_key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $notify_res = curl_exec($ch);

        curl_close($ch);

        //dd($notify_res);
        //exit;


        //Delete session file
        \Session::getHandler()->destroy($user_session_name);

        $user_device_obj = UsersDeviceHistory::where('user_id',$user_id)->where('user_session_name',$user_session_name);
        $user_device_obj->delete();


        \Session::flash('success', 'Logout device remotely successfully...');

        return redirect('/dashboard');
    }

    public function check_user_remotely_logout_or_not($user_session_name)
    {


        $user_device_obj = UsersDeviceHistory::where('user_session_name',$user_session_name)->first();
        //dd($user_device_obj);
        //exit;

        if($user_device_obj)
        {
           echo "true";
        }
        else
        {
          echo "false";
        }
    }
}
