<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $table = "banners";
    protected $primaryKey = 'banner_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'banner_id', 
        'banner_name',
        'banner_image',
        'banner_status'             
    ];
}
