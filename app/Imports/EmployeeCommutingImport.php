<?php

namespace App\Imports;

use App\Models\EmployeeCommuting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class EmployeeCommutingImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new EmployeeCommuting([
            'employee_name' => $row['employee_name'],
            'department' => $row['department'] ?? null,
            'mode_of_transport' => $row['mode_of_transport'] ?? null,
            'type_of_fuel' => $row['type_of_fuel'] ?? null,
            'distance_traveled' => $row['distance_traveled'] ?? null,
            'commence_date' => $this->parseDate($row['commence_date'] ?? null),
            'end_date' => $this->parseDate($row['end_date'] ?? null),
            'exclude_public_holidays' => $row['exclude_public_holidays'] ?? null,
            'exclude_weekends' => $row['exclude_weekends'] ?? null,
            'leave_days' => $row['leave_days'] ?? null,
            'unpaid_other_leave' => $row['unpaid_other_leave'] ?? null,
            'mc_days' => $row['mc_days'] ?? null,
            'days_commuting' => $row['days_commuting'] ?? null,
            'km_petrol' => $row['km_petrol'] ?? null,
            'km_diesel' => $row['km_diesel'] ?? null,
            'year' => $row['year'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'employee_name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'mode_of_transport' => 'nullable|string|max:255',
            'type_of_fuel' => 'nullable|string|max:255',
            'distance_traveled' => 'nullable|numeric|min:0',
            'commence_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:commence_date',
            'exclude_public_holidays' => 'nullable|integer|min:0',
            'exclude_weekends' => 'nullable|integer|min:0',
            'leave_days' => 'nullable|integer|min:0',
            'unpaid_other_leave' => 'nullable|integer|min:0',
            'mc_days' => 'nullable|integer|min:0',
            'days_commuting' => 'nullable|integer|min:0',
            'km_petrol' => 'nullable|numeric|min:0',
            'km_diesel' => 'nullable|numeric|min:0',
            'year' => 'nullable|string|max:4',
        ];
    }

    private function parseDate($date)
    {
        if (empty($date)) return null;
        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}