<?php
namespace App\DataTables;
use App\Models\District;
use DB;
class DistrictDataTable
{
    public function all()
    {
        // $data = Banner::where('is_disable',0)->get();
        $data = District::orderBy('created_at','desc')->get();
        return $data;
    }
    
}
