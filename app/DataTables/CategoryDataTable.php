<?php
namespace App\DataTables;
use App\Models\Category;
use DB;
class CategoryDataTable
{
    public function all()
    {
        $data = Category::orderBy('created_at','desc')->get();
        // echo "<pre>";
        // print_r($data);die;
        return $data;
    }
}
