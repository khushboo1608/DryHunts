<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $table = "carts";
    protected $primaryKey = 'cart_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cart_id',
        'user_id',
        'service_id',
        'service_detail_id',
        'cart_service_unit',
        'cart_service_quantity',
        'cart_service_original_price',
        'cart_service_discount_price',
        'cart_status',     
    ];
    public function ServiceData() {
        return $this->hasOne('App\Models\Service', 'service_id', 'service_id');
    }
}
