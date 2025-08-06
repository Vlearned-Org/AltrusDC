<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [
                'John Doe',
                'john@example.com',
                'password123',
                '2024-01-01 00:00:00'
            ],
            [
                'Jane Smith',
                'jane@example.com',
                'password456',
                ''
            ]
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'email_verified_at'
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
