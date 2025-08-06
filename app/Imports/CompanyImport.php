<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class CompanyImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Company([
            'name' => $row['name'],
            'location' => $row['location'] ?? null,
            'reporting_date' => $this->parseDate($row['reporting_date'] ?? null),
            'color_code' => $row['color_code'] ?? null,
            'mission' => $row['mission'] ?? null,
            'vision' => $row['vision'] ?? null,
            'carbon_footprint_reduction' => $this->parseBoolean($row['carbon_footprint_reduction'] ?? null),
            'sustainable_sourcing' => $this->parseBoolean($row['sustainable_sourcing'] ?? null),
            'energy_efficiency' => $this->parseBoolean($row['energy_efficiency'] ?? null),
            'waste_reduction' => $this->parseBoolean($row['waste_reduction'] ?? null),
            'employee_engagement' => $this->parseBoolean($row['employee_engagement'] ?? null),
            'other_sustainability_goals' => $row['other_sustainability_goals'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'reporting_date' => 'nullable|date',
            'color_code' => 'nullable|string|max:7',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'carbon_footprint_reduction' => 'nullable|boolean',
            'sustainable_sourcing' => 'nullable|boolean',
            'energy_efficiency' => 'nullable|boolean',
            'waste_reduction' => 'nullable|boolean',
            'employee_engagement' => 'nullable|boolean',
            'other_sustainability_goals' => 'nullable|string',
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

    private function parseBoolean($value)
    {
        if (is_null($value) || $value === '') {
            return false;
        }

        return in_array(strtolower($value), ['true', '1', 'yes', 'on']);
    }
}