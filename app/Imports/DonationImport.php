<?php

namespace App\Imports;

use App\Models\Donation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class DonationImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new Donation([
            'pic_name' => $row['pic_name'] ?? null,
            'organization_name' => $row['organization_name'],
            'donor_name' => $row['donor_name'],
            'donation_date' => $this->parseDate($row['donation_date'] ?? null),
            'amount' => $row['amount'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'pic_name' => 'nullable|string|max:255',
            'organization_name' => 'required|string|max:255',
            'donor_name' => 'required|string|max:255',
            'donation_date' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
        ];
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }
        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}