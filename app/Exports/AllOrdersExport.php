<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class AllOrdersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        $arr = [
                'Date',
                'Order No',
                'Tracking No',
                'Invoice No',
                'Courier',
                'Receiver',
                'Destination',
                'Payment method',
                'Payment status',
                'Status',
                'AWB',
                'Date ordered',
                'Qty',
                'Price',
                '10% order fee',
                'Subtotal'
        ];

        return $arr;
    }

    public function map($order): array
    {
        $currency = $order->currency->name ?? 'N/A';
        $arr_val = [
            $order->created_at->format('F j, Y h:i A') ?? 'N/A',
            $order->code ?? 'N/A',
            $order->tracking ?? 'N/A',
            $order->invoice ?? 'N/A',
            $order->courierDetail->name ?? 'N/A',
            ucwords($order->shipperAddress->name) ?? 'N/A',
            $order->shipperAddress->country->name ?? 'N/A',
            $order->billing[0]->payment->name ?? 'N/A',
            $order->paymentStatus->name ?? 'N/A',
            $order->status == 0 ? 'Pending' : 'Active',
            $order->awb ?? 'N/A',
            $order->created_at->format('F j, Y h:i A') ?? 'N/A',
            $order->total_qty ?? 'N/A',
            $currency.' '.$order->sub_total,
            $currency.' '.$order->total,
            'ƒ '.$order->amount_converted,

        ];

        return $arr_val;
    }
}
