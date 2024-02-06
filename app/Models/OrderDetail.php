<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    public $table = "order_details";
    protected $primaryKey = 'order_detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_detail_id',
        'order_id',
        'service_id',
        'service_detail_id',
        'order_original_price',
        'order_discount_price',
        'order_unit',
        'order_quantity',
        'order_details_status'   
    ];
    public function ServiceData() {
        return $this->hasOne('App\Models\Service', 'service_id', 'service_id');
    }
}
