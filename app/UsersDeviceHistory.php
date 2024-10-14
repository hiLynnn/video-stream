<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;

class UsersDeviceHistory extends Model
{
    protected $table = 'users_device_history';

    protected $fillable = ['user_id', 'user_device_name','user_session_name'];

	public $timestamps = false;	  
	 
}
