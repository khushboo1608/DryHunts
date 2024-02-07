<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    // INSERT INTO `notifications`(`notifications_id`, `notification_click`, `notification_type`, `no_type`, `user_id`, `order_id`, `notification_title`, `notification_msg`, `notification_image`, `notification_status`, `created_at`, `updated_at`) 
    public $table='notifications';
    protected $primaryKey = 'notifications_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'notifications_id',
        'notification_click',
        'notification_type',
        'no_type',
        'user_id',
        'order_id',
        'notification_title',
        'notification_msg',
        'notification_image',
        'notification_status'
    ];
}
