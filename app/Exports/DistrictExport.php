<?php

namespace App\Exports;

use App\Models\District;

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
class DistrictExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return District::all();
        return District::select('district_id','state_id','district_name','district_status')->get();
    }

    public function headings(): array
    {
        return [
            'District Id',
            'State Id',
            'District Name',
            'District Status'
        ];
    }

    public function title(): string
    {
        return 'District';
    }
    
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A','Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                 }
                 $event->sheet->getDelegate()->getStyle('A1:D1')
                ->getFont()
                ->setBold(true);
            },
        ];
    }
   

}

