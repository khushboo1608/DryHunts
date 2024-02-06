<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;
    public $table = "pincodes";
    protected $primaryKey = 'pincode_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pincode_id',
        'taluka_id',
        'district_id',
        'state_id', 
        'pincode',
        'pincode_status'             
    ];

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
