<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    public $table = "testimonials";
    protected $primaryKey = 'testimonial_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'testimonial_id',
        'testimonial_title',
        'testimonial_image',
        'testimonial_description',
        'pincode_id',
        'taluka_id',
        'district_id',
        'state_id', 
        'category_id',
        'service_id',
        'testimonial_status'         
    ];

    public function pincodeData() {
        return $this->hasOne('App\Models\Pincode', 'pincode_id', 'pincode_id');
    }
    
    public function talukaData() {
        return $this->hasOne('App\Models\Talukas', 'taluka_id', 'taluka_id');
    }
    
    public function districtData() {
        return $this->hasOne('App\Models\District', 'district_id', 'district_id');
    }
    public function stateData() {
        return $this->hasOne('App\Models\State', 'state_id', 'state_id');
    }

}
