<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    public $table = "states";
    protected $primaryKey = 'state_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'state_id', 
        'state_name',
        'state_status'             
    ];
}
