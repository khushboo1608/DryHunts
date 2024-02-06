<?php
namespace App\DataTables;
use App\Models\Testimonial;
use DB;
class TestimonialDataTable
{
    public function all()
    {
        $data = Testimonial::orderBy('created_at','desc')->get();
        return $data;
    }
}
