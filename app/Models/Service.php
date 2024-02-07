<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $table = "service";
    protected $primaryKey = 'service_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'service_id',
        'category_id',
        'sub_categories_id',
        'service_name',
        'service_description',
        'service_single_image',
        'service_multiple_image',
        'service_price',
        'service_sku',
        'is_popular',
        'service_status',        
    ];
    
    
    public function CategoryData() {
        return $this->hasOne('App\Models\Category', 'category_id', 'category_id');
    }
    public function SubCategoryData() {
        return $this->hasOne('App\Models\SubCategory', 'sub_categories_id', 'sub_categories_id');
    }
    public function ServiceDetails() {
        return $this->hasMany('App\Models\ServiceDetails', 'service_id', 'service_id');
    }
}
