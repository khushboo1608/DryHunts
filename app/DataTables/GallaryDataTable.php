<?php
namespace App\DataTables;
use App\Models\Gallary;
use DB;
class GallaryDataTable
{
    public function all()
    {
        // $data = Banner::where('is_disable',0)->get();
        $data = Gallary::orderBy('created_at','desc')->get();
        return $data;
    }
    
}
