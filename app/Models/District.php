<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public $table = "districts";
    protected $primaryKey = 'district_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'district_id',
        'state_id', 
        'district_name',
        'district_status'             
    ];
    public function stateData() {
        return $this->hasOne('App\Models\State', 'state_id', 'state_id');
    }
}
