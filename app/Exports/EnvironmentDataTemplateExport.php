<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnvironmentDataTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'Electricity Consumption', 'Environmental Manager', 'kWh', '0.85', '1200', '1150', '1300',
                '1400', '1350', '1250', '1100', '1050', '1000', '1100', '1200', '1300', '14400'
            ],
            [
                'Water Consumption', 'Facility Manager', 'Liters', '0.001', '5000', '4800', '5200',
                '5500', '5300', '5100', '4900', '4700', '4500', '4800', '5000', '5200', '60000'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'metrics', 'person_in_charge', 'unit', 'emission_factor', 'april', 'may', 'june',
            'july', 'august', 'september', 'october', 'november', 'december', 'january',
            'february', 'march', 'total_kg_co2'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}