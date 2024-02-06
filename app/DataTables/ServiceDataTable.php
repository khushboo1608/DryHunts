<?php
namespace App\DataTables;
use App\Models\Service;
use DB;
class ServiceDataTable
{
    public function all()
    {
        $data = Service::orderBy('created_at','desc')->get();
        return $data;
    }
}
