<?php

namespace App\Imports;

use App\Models\Economic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class EconomicImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new Economic([
            'supply_chain_pic' => $row['supply_chain_pic'] ?? null,
            'economic_value_pic' => $row['economic_value_pic'] ?? null,
            'fiscal_year' => $row['fiscal_year'] ?? null,
            'local_vendor_spending' => $row['local_vendor_spending'] ?? null,
            'international_vendor_spending' => $row['international_vendor_spending'] ?? null,
            'total_expenditure' => $row['total_expenditure'] ?? null,
            'local_percentage' => $row['local_percentage'] ?? null,
            'international_percentage' => $row['international_percentage'] ?? null,
            'total_percentage' => $row['total_percentage'] ?? null,
            'goods_revenue' => $row['goods_revenue'] ?? null,
            'services_revenue' => $row['services_revenue'] ?? null,
            'investments_revenue' => $row['investments_revenue'] ?? null,
            'other_income' => $row['other_income'] ?? null,
            'total_value_generated' => $row['total_value_generated'] ?? null,
            'operating_expenses' => $row['operating_expenses'] ?? null,
            'employee_wages' => $row['employee_wages'] ?? null,
            'financial_institutions_payments' => $row['financial_institutions_payments'] ?? null,
            'shareholders_payments' => $row['shareholders_payments'] ?? null,
            'government_payments' => $row['government_payments'] ?? null,
            'income_tax' => $row['income_tax'] ?? null,
            'community_investment' => $row['community_investment'] ?? null,
            'total_value_distributed' => $row['total_value_distributed'] ?? null,
            'value_retained' => $row['value_retained'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'supply_chain_pic' => 'nullable|string|max:255',
            'economic_value_pic' => 'nullable|string|max:255',
            'fiscal_year' => 'nullable|string|max:255',
            'local_vendor_spending' => 'nullable|numeric|min:0',
            'international_vendor_spending' => 'nullable|numeric|min:0',
            'total_expenditure' => 'nullable|numeric|min:0',
            'local_percentage' => 'nullable|numeric|min:0|max:100',
            'international_percentage' => 'nullable|numeric|min:0|max:100',
            'total_percentage' => 'nullable|numeric|min:0|max:100',
            'goods_revenue' => 'nullable|numeric|min:0',
            'services_revenue' => 'nullable|numeric|min:0',
            'investments_revenue' => 'nullable|numeric|min:0',
            'other_income' => 'nullable|numeric|min:0',
            'total_value_generated' => 'nullable|numeric|min:0',
            'operating_expenses' => 'nullable|numeric|min:0',
            'employee_wages' => 'nullable|numeric|min:0',
            'financial_institutions_payments' => 'nullable|numeric|min:0',
            'shareholders_payments' => 'nullable|numeric|min:0',
            'government_payments' => 'nullable|numeric|min:0',
            'income_tax' => 'nullable|numeric|min:0',
            'community_investment' => 'nullable|numeric|min:0',
            'total_value_distributed' => 'nullable|numeric|min:0',
            'value_retained' => 'nullable|numeric',
        ];
    }
}