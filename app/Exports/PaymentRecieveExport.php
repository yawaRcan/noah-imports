<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class PaymentRecieveExport implements FromQuery, WithHeadings, WithMapping
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
                'Tracking',
                'Sender',
                'Reciever',
                'Destination',
                'Payment method',
                'Payment status',
                'Status',
                'Weight(LB)',
                'Freight type',
                'Amount'
        ];

        return $arr;
    }

    public function map($userAmount): array
    {
        $arr_val = [
            $userAmount->es_delivery_date->format('F j, Y h:i A') ?? 'N/A',
            ucwords($userAmount->user->first_name) ?? 'N/A',
            $userAmount->payment->name ?? 'N/A',
            $userAmount->external_tracking ?? 'N/A',
            $userAmount->amount_total

        ];

        return $arr_val;
    }
}
