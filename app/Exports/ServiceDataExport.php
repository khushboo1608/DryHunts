<?php

namespace App\Exports;

use App\Models\Service;

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
class ServiceDataExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return ParentCategory::all();
        return Service::select('service_id','category_id','service_name','service_description','service_single_image','service_multiple_image','service_price','service_sku','service_status')->get();
    }

    public function headings(): array
    {
        return [
            'Service Id',
            'Category Id',
            'Service Name',
            'Service Description',
            'Service Single Image',
            'Service Multiple Image',
            'Service Price',
            'Service SKU',
            'Service Status'
        ];
    }

    public function title(): string
    {
        return 'Service';
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

