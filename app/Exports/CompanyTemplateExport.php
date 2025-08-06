<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [
                'Altrus Technology Inc.',
                'Jakarta, Indonesia',
                '2024-01-01',
                '#3B82F6',
                'To provide innovative technology solutions',
                'To be the leading tech company in Southeast Asia',
                'true',
                'true',
                'true',
                'false',
                'true',
                'Community development programs'
            ],
            [
                'Green Solutions Ltd.',
                'Singapore',
                '2024-02-01',
                '#10B981',
                'Sustainable business solutions',
                'A greener future for all',
                'true',
                'true',
                'true',
                'true',
                'true',
                'Environmental conservation initiatives'
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
            'location',
            'reporting_date',
            'color_code',
            'mission',
            'vision',
            'carbon_footprint_reduction',
            'sustainable_sourcing',
            'energy_efficiency',
            'waste_reduction',
            'employee_engagement',
            'other_sustainability_goals'
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