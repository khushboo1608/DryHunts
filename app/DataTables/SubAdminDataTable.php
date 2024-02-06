<?php
namespace App\DataTables;
use App\Models\User;
use DB;
class SubAdminDataTable
{
    public function all()
    {
        $data = User::whereIn('login_type',[3,4])->orderBy('created_at','desc')->get();
        return $data;
    }
}
