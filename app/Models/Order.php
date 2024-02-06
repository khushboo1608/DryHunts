<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $table = "orders";
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'user_id',
        'rate',
        'rate_comment',
        'order_amount',
        'order_discount_amount',
        'payment_type',
        'payment_transection_id',
        'order_type',
        'cancel_reason',
        'request_for',
        'quotation_pdf',
        'quotation_remark',
        'state_id',
        'district_id',
        'taluka_id',
        'pincode_id',
        'gst_number',
        'order_status'   
    ];
    public function User() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function OrderDetails() {
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'order_id');
    }
    
    
}
