<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talukas extends Model
{
    use HasFactory;
    public $table = "talukas";
    protected $primaryKey = 'taluka_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'taluka_id',
        'district_id',
        'state_id', 
        'taluka_name',
        'taluka_status'             
    ];
    
    public function districtData() {
        return $this->hasOne('App\Models\District', 'district_id', 'district_id');
    }
    public function stateData() {
        return $this->hasOne('App\Models\State', 'state_id', 'state_id');
    }
}
