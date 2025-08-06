<?php

namespace App\Exports;

use App\Models\BusinessTravel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BusinessTravelTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [
                'John Doe',
                'Travel Manager',
                'ACCT001',
                '2024',
                'New York, USA',
                'AIRCRAFT',
                '2024-01-15',
                '2024-01-20',
                'Business meeting with clients',
                '8000.50'
            ],
            [
                'Jane Smith',
                'Sales Director',
                'ACCT002',
                '2024',
                'London, UK',
                'TRAIN',
                '2024-02-10',
                '2024-02-12',
                'Conference attendance',
                '500.25'
            ]
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'employee_name',
            'pic_name',
            'account',
            'fiscal_year',
            'destination',
            'transport_mode',
            'departure_date',
            'return_date',
            'purpose',
            'distance_km'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}