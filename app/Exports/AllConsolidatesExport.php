<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class AllConsolidatesExport implements FromQuery, WithHeadings, WithMapping
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

    public function map($consolidate): array
    {
        $arr_val = [
            $consolidate->created_at->format('F j, Y h:i A') ?? 'N/A',
            $consolidate->external_tracking ?? 'N/A',
            ucwords($consolidate->sender->address) ?? 'N/A',
            ucwords($consolidate->reciever->address) ?? 'N/A',
            $consolidate->toCountry->name ?? 'N/A',
            $consolidate->payment->name ?? 'N/A',
            $consolidate->paymentStatus->name ?? 'N/A',
            $consolidate->parcelStatus->name ?? 'N/A',
            $consolidate->weight ?? 'N/A',
            $consolidate->freight_type ?? 'N/A',
            'ƒ '.$consolidate->amount_total

        ];

        return $arr_val;
    }
}
