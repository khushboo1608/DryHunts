<?php
namespace App\DataTables;
use App\Models\State;
use DB;
class StateDataTable
{
    public function all()
    {
        // $data = Banner::where('is_disable',0)->get();
        $data = State::orderBy('created_at','desc')->get();
        return $data;
    }
    
}
