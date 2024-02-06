<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallary extends Model
{
    use HasFactory;
    public $table = "gallaries";
    protected $primaryKey = 'gallary_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'gallary_id', 
        'gallary_image',
        'gallary_status'             
    ];
}
