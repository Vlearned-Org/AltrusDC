<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EconomicTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'Supply Chain Manager', 'Economic Director', '2024', '1000000000', '500000000', '1500000000', 
                '66.67', '33.33', '100', '2000000000', '800000000', '200000000', '100000000', '3100000000',
                '1200000000', '600000000', '50000000', '100000000', '80000000', '70000000', '50000000', 
                '2150000000', '950000000'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'supply_chain_pic', 'economic_value_pic', 'fiscal_year', 'local_vendor_spending', 
            'international_vendor_spending', 'total_expenditure', 'local_percentage', 
            'international_percentage', 'total_percentage', 'goods_revenue', 'services_revenue',
            'investments_revenue', 'other_income', 'total_value_generated', 'operating_expenses',
            'employee_wages', 'financial_institutions_payments', 'shareholders_payments',
            'government_payments', 'income_tax', 'community_investment', 'total_value_distributed',
            'value_retained'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}