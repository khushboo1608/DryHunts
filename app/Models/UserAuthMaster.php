<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class UserAuthMaster extends Model
{
    use HasApiTokens, HasFactory;
    public $table = "user_auth_master";
    protected $fillable = [
        'user_auth_id',
        'user_id',
        'oauth_access_token_id',
        'device_type',
        'device_token'
    ];
}
