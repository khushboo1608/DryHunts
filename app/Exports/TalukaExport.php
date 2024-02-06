<?php

namespace App\Exports;

use App\Models\Talukas;

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
class TalukaExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return Taluka::all();
        return Talukas::select('taluka_id','district_id','state_id','taluka_name','taluka_status')->get();
    }

    public function headings(): array
    {
        return [
            'Taluka Id',
            'District Id',
            'State Id',
            'Taluka Name',
            'Taluka Status'
        ];
    }

    public function title(): string
    {
        return 'Taluka';
    }
    
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A','Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                 }
                 $event->sheet->getDelegate()->getStyle('A1:E1')
                ->getFont()
                ->setBold(true);
            },
        ];
    }
   

}

