<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transaction';
    protected $fillable = ['user_id', 'email', 'plan_id', 'payment_amount', 'gateway', 'date','payment_id'];
	public $timestamps = false;
 
	public function formatDate($date){
        return Carbon::parse($date)->format('d-m-Y');
    }
}
