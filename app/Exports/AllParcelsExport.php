<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class AllParcelsExport implements FromQuery, WithHeadings, WithMapping
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

    public function map($parcel): array
    {
        $arr_val = [
            $parcel->created_at->format('F j, Y h:i A') ?? 'N/A',
            $parcel->external_tracking ?? 'N/A',
            ucwords($parcel->sender->address) ?? 'N/A',
            ucwords($parcel->reciever->address) ?? 'N/A',
            $parcel->toCountry->name ?? 'N/A',
            $parcel->payment->name ?? 'N/A',
            $parcel->paymentStatus->name ?? 'N/A',
            $parcel->parcelStatus->name ?? 'N/A',
            $parcel->weight ?? 'N/A',
            $parcel->freight_type ?? 'N/A',
            'ƒ '.$parcel->amount_total

        ];

        return $arr_val;
    }
}
