<?php
namespace App\DataTables;
use App\Models\User;
use DB;
class UserDataTable
{
    public function all()
    {
        $data = User::where('login_type',2)->orderBy('created_at','desc')->get();
        return $data;
    }
}
