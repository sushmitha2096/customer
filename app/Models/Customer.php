<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    

    public static function register($table,$post_data){
		
		return $result = DB::table($table)->insertGetId($post_data);
    }
    
     public static function verifyOtp($table,$post_data){
		
		return $result = DB::table('users')->select('user_id','phone','email','otp','unique_code')
				->where('user_id','=',$post_data['user_id'])
				->where('otp','=',$post_data['otp'])
				->first();
	}
}
