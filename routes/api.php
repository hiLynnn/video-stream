<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1','namespace' => 'API'], function(){
     
    Route::get('/', 'AndroidApiController@index');
    Route::post('app_details', 'AndroidApiController@app_details');    
    Route::post('player_settings', 'AndroidApiController@player_settings');
    Route::post('payment_settings', 'AndroidApiController@payment_settings');
 
    Route::post('login', 'AndroidApiController@postLogin');
    Route::post('signup', 'AndroidApiController@postSignup');
    Route::post('logout', 'AndroidApiController@logout');

    Route::post('login_social', 'AndroidApiController@postSocialLogin');

    Route::post('forgot_password', 'AndroidApiController@forgot_password');

    Route::post('dashboard', 'AndroidApiController@dashboard');
    Route::post('profile', 'AndroidApiController@profile');
    Route::post('profile_update', 'AndroidApiController@profile_update');
    Route::post('account_delete', 'AndroidApiController@account_delete');

    Route::post('check_user_plan', 'AndroidApiController@check_user_plan');
    Route::post('subscription_plan', 'AndroidApiController@subscription_plan');
    Route::post('transaction_add', 'AndroidApiController@transaction_add');


    Route::post('home', 'AndroidApiController@home');
    Route::post('home_collections', 'AndroidApiController@home_collections');   
    Route::post('languages', 'AndroidApiController@languages');  
    Route::post('genres', 'AndroidApiController@genres');  

    Route::post('shows', 'AndroidApiController@shows');  
    Route::post('shows_by_language', 'AndroidApiController@shows_by_language');
    Route::post('shows_by_genre', 'AndroidApiController@shows_by_genre');
 
    Route::post('show_details', 'AndroidApiController@show_details');  
    Route::post('seasons', 'AndroidApiController@seasons');
    Route::post('episodes', 'AndroidApiController@episodes');
    Route::post('episodes_recently_watched', 'AndroidApiController@episodes_recently_watched');
    //Route::post('episodes_details', 'AndroidApiController@episodes_details');  

    Route::post('movies', 'AndroidApiController@movies');  
    Route::post('movies_by_language', 'AndroidApiController@movies_by_language');  
    Route::post('movies_by_genre', 'AndroidApiController@movies_by_genre');  
    Route::post('movies_details', 'AndroidApiController@movies_details');  

    Route::post('sports_category', 'AndroidApiController@sports_category');
    Route::post('sports', 'AndroidApiController@sports');  
    Route::post('sports_by_category', 'AndroidApiController@sports_by_category');
    Route::post('sports_details', 'AndroidApiController@sports_details');    
    

    Route::post('livetv_category', 'AndroidApiController@livetv_category');
    Route::post('livetv', 'AndroidApiController@livetv');
    Route::post('livetv_by_category', 'AndroidApiController@livetv_by_category');
    Route::post('livetv_details', 'AndroidApiController@livetv_details');  

    Route::post('search', 'AndroidApiController@search'); 

    Route::post('my_watchlist', 'AndroidApiController@my_watchlist');
    Route::post('watchlist_add', 'AndroidApiController@watchlist_add');
    Route::post('watchlist_remove', 'AndroidApiController@watchlist_remove');

    Route::post('apply_coupon_code', 'AndroidApiController@apply_coupon_code');

    Route::post('actor_details', 'AndroidApiController@actor_details');
    Route::post('director_details', 'AndroidApiController@director_details');

    Route::post('stripe_token_get', 'AndroidApiController@stripe_token_get'); 

    Route::post('get_braintree_token', 'AndroidApiController@get_braintree_token');
    Route::post('braintree_checkout', 'AndroidApiController@braintree_checkout');

    Route::post('get_paytm_token_id', 'AndroidApiController@create_paytm_token');
    
    Route::post('get_cashfree_token', 'AndroidApiController@get_cashfree_token');

    Route::post('get_payu_hash_new', 'AndroidApiController@payUmoneyHashGenerator_New');

    Route::post('coingate_pay', 'AndroidApiController@coingate_pay');     
    Route::post('coingate_payment_status', 'AndroidApiController@coingate_payment_status');

    Route::post('mollie_pay', 'AndroidApiController@mollie_pay');     
    Route::post('mollie_payment_status', 'AndroidApiController@mollie_payment_status');

    Route::get('user_device_limit_reached', 'AndroidApiController@user_device_limit_reached');
    Route::get('user_active_device_list', 'AndroidApiController@user_active_device_list');
    Route::get('logout_user_remotely', 'AndroidApiController@logout_user_remotely');
    Route::get('check_user_remotely_logout_or_not', 'AndroidApiController@check_user_remotely_logout_or_not');

    //New Filter     
    Route::post('lang_genre_cat_list', 'AndroidApiController@lang_genre_cat_list'); 
    Route::post('movies_filter', 'AndroidApiController@movies_filter');
    Route::post('shows_filter', 'AndroidApiController@shows_filter');
    Route::post('sports_filter', 'AndroidApiController@sports_filter');
    Route::post('livetv_filter', 'AndroidApiController@livetv_filter');    
 
});
