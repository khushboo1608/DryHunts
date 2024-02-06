<?php

namespace App\Exports;

use App\Models\State;

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
class StateExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return State::all();
        return State::select('state_id','state_name','state_status')->get();
    }

    public function headings(): array
    {
        return [
            'State Id',
            'State Name',
            'State Status'
        ];
    }

    public function title(): string
    {
        return 'State';
    }
    
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A','Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                 }
                 $event->sheet->getDelegate()->getStyle('A1:C1')
                ->getFont()
                ->setBold(true);
            },
        ];
    }
   

}

