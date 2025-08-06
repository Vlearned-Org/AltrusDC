<?php

namespace App\Imports;

use App\Models\BusinessTravel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class BusinessTravelImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new BusinessTravel([
            'pic_name' => $row['pic_name'] ?? null,
            'account' => $row['account'] ?? null,
            'fiscal_year' => $row['fiscal_year'] ?? null,
            'employee_name' => $row['employee_name'],
            'destination' => $row['destination'],
            'transport_mode' => $row['transport_mode'],
            'departure_date' => $this->parseDate($row['departure_date'] ?? null),
            'return_date' => $this->parseDate($row['return_date'] ?? null),
            'purpose' => $row['purpose'] ?? null,
            'distance_km' => $row['distance_km'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'employee_name' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'transport_mode' => 'required|in:' . implode(',', array_keys(BusinessTravel::getTransportModes())),
            'pic_name' => 'nullable|string|max:100',
            'account' => 'nullable|string|max:255',
            'fiscal_year' => 'nullable|string|max:255',
            'departure_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
            'purpose' => 'nullable|string',
            'distance_km' => 'nullable|numeric|min:0',
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