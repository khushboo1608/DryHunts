<?php

namespace App\Exports;

use App\Models\Testimonial;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

// class UsersExport implements FromCollection, WithHeadings, WithEvents
// {
class TestimonialExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return Taluka::all();
        return Testimonial::select('testimonial_id','testimonial_title','testimonial_image','testimonial_description','pincode_id','taluka_id','district_id','state_id','category_id','service_id','testimonial_status')->get();
    }

    public function headings(): array
    {
        return [
            'Testimonial Id',
            'Testimonial Title',
            'Testimonial Image',
            'Testimonial Description',
            'Pincode Id',
            'Taluka Id',
            'District Id',
            'State Id', 
            'Category Id',
            'Service Id',
            'Testimonial Status'  
        ];
    }

    public function title(): string
    {
        return 'Testimonial';
    }
    
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A','Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                 }
                 $event->sheet->getDelegate()->getStyle('A1:I1')
                ->getFont()
                ->setBold(true);
            },
        ];
    }
   

}

