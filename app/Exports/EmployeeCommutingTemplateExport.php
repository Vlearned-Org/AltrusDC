<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeCommutingTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'John Doe', 'IT Department', 'Car', 'Petrol', '25.5', '2024-01-01', '2024-12-31',
                '10', '104', '15', '5', '3', '230', '5865', '0', '2024'
            ],
            [
                'Jane Smith', 'HR Department', 'Motorcycle', 'Petrol', '15.2', '2024-01-01', '2024-12-31',
                '10', '104', '12', '2', '1', '235', '3572', '0', '2024'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'employee_name', 'department', 'mode_of_transport', 'type_of_fuel', 'distance_traveled',
            'commence_date', 'end_date', 'exclude_public_holidays', 'exclude_weekends', 'leave_days',
            'unpaid_other_leave', 'mc_days', 'days_commuting', 'km_petrol', 'km_diesel', 'year'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}