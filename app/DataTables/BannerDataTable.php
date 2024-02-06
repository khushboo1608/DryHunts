<?php
namespace App\DataTables;
use App\Models\Banner;
use DB;
class BannerDataTable
{
    public function all()
    {
        // $data = Banner::where('is_disable',0)->get();
        $data = Banner::orderBy('created_at','desc')->get();
        return $data;
    }
    
}
