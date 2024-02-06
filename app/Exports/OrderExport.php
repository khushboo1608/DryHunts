<?php

namespace App\Exports;

use App\Models\Order;

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
class OrderExport implements FromCollection, WithHeadings, WithEvents,WithTitle,WithStrictNullComparison
{
    public function collection()
    {       
        // return Order::all();
        return Order::select('order_id','user_id',
        'rate','rate_comment','order_amount','order_discount_amount','payment_type','payment_transection_id','order_type','cancel_reason','request_for','quotation_pdf','quotation_remark','order_status')->get();
    }

    public function headings(): array
    {
        return [
            'Request Id',
            'User Id',
            'Rate',
            'Rate Comment',
            'Request Amount',
            'Request Discount Amount',
            'Payment Type',
            'Payment Transection Id',
            'Request Type',
            'Cancel Reason',
            'Request For',
            'Quotation Pdf',
            'Quotation Remark',
            'Request Status'
        ];
    }

    public function title(): string
    {
        return 'Order';
    }
    
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A','Z') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                 }
                 $event->sheet->getDelegate()->getStyle('A1:N1')
                ->getFont()
                ->setBold(true);
            },
        ];
    }
   

}

