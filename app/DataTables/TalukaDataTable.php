<?php
namespace App\DataTables;
use App\Models\Talukas;
use DB;
class TalukaDataTable
{
    public function all()
    {
        // $data = Banner::where('is_disable',0)->get();
        $data = Talukas::orderBy('created_at','desc')->get();
        return $data;
    }
    
}
