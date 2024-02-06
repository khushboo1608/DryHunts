<?php

namespace App\Exports;

use App\Models\User;

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
class SubAdminDataExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return ParentCategory::all();
        return User::select('id','login_type','name','email','phone','is_verified','imageurl','state_id','district_id','taluka_id','pincode_id','gst_number','is_disable')->whereIn('login_type',[3,4])->get();
    }

    public function headings(): array
    {
        return [
            'User Id',
            'User Login Type',
            'User Name',
            'User Email',
            'User Phone No.',
            'Is Verified',
            'User Image',
            'State Id',
            'District Id',
            'Taluka Id',
            'Pincode Id',
            'GST Number',
            'User Status'
        ];
    }

    public function title(): string
    {
        return 'SubAdminData';
    }
    
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A','Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                 }
                 $event->sheet->getDelegate()->getStyle('A1:M1')
                ->getFont()
                ->setBold(true);
            },
        ];
    }  

}

