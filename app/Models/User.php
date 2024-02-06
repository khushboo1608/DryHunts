<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_type',
        'name',
        'email',
        'phone',
        'is_verified',
        'otp',
        'wallet',
        'password',
        'imageurl',
        'state_id',
        'district_id',
        'taluka_id',
        'pincode_id',
        'gst_number',
        'firebase_uid',
        'is_disable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function AauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function UserAuthMaster() {
        return $this->hasMany('App\Models\UserAuthMaster', 'user_id', 'id');
    }
}
