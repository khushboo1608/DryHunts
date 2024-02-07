<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubCategory extends Model
{
    use HasFactory;
    public $table = 'sub_categories';
    protected $primaryKey = 'sub_categories_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sub_categories_id', 
        'category_id',
        'sub_categories_name',
        'sub_categories_image',   
        'sub_categories_status',          
    ];

    public function CategoryData() {
        return $this->hasOne('App\Models\Category', 'category_id', 'category_id');
    }

}


