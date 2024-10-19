<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transaction';

    protected $fillable = ['user_id', 'email', 'plan_id', 'payment_amount', 'gateway', 'payment_id'];


	public $timestamps = false;
 
	  
}
