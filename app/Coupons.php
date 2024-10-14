<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $table = 'coupons';

    protected $fillable = ['coupon_code', 'coupon_percentage','coupon_user_limit'];


	public $timestamps = false;
 
	 
	
	public static function getCouponInfo($id) 
    { 
		return Coupons::find($id);
	}

	
}
