<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DonationTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'John Manager',
                'Red Cross Indonesia',
                'Altrus Technology Inc.',
                '2024-01-15',
                '50000000'
            ],
            [
                'Jane Director',
                'Yayasan Pendidikan Anak',
                'Green Solutions Ltd.',
                '2024-02-20',
                '25000000'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'pic_name',
            'organization_name',
            'donor_name',
            'donation_date',
            'amount'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}