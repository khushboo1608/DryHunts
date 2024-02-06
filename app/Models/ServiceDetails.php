<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetails extends Model
{
    use HasFactory;
    use HasFactory;
    public $table = "service_details";
    protected $primaryKey = 'service_detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'service_detail_id',
        'service_id',        
        'service_original_price',
        'service_discount_price',
        'service_unit',
        'service_quantity',
        'service_detail_status',        
    ];
}
