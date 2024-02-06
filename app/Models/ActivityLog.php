<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    public $table = "activity_logs";
    protected $primaryKey = 'activity_log_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'activity_log_id', 
        'user_id',
        'order_id',
        'description'             
    ];

    public function OrderData() {
        return $this->hasMany('App\Models\Order', 'order_id', 'order_id');
    }

    public function UserData() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
