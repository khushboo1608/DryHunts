<?php
namespace App\DataTables;
use App\Models\Pincode;
use DB;
class PincodeDataTable
{
    public function all()
    {
        // $data = Banner::where('is_disable',0)->get();
        $data = Pincode::orderBy('created_at','desc')->get();
        return $data;
    }
    
}
