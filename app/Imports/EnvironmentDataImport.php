<?php

namespace App\Imports;

use App\Models\EnvironmentData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class EnvironmentDataImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new EnvironmentData([
            'metrics' => $row['metrics'],
            'person_in_charge' => $row['person_in_charge'] ?? null,
            'unit' => $row['unit'] ?? null,
            'emission_factor' => $row['emission_factor'] ?? null,
            'april' => $row['april'] ?? null,
            'may' => $row['may'] ?? null,
            'june' => $row['june'] ?? null,
            'july' => $row['july'] ?? null,
            'august' => $row['august'] ?? null,
            'september' => $row['september'] ?? null,
            'october' => $row['october'] ?? null,
            'november' => $row['november'] ?? null,
            'december' => $row['december'] ?? null,
            'january' => $row['january'] ?? null,
            'february' => $row['february'] ?? null,
            'march' => $row['march'] ?? null,
            'total_kg_co2' => $row['total_kg_co2'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'metrics' => 'required|string|max:255',
            'person_in_charge' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'emission_factor' => 'nullable|numeric|min:0',
            'april' => 'nullable|numeric|min:0',
            'may' => 'nullable|numeric|min:0',
            'june' => 'nullable|numeric|min:0',
            'july' => 'nullable|numeric|min:0',
            'august' => 'nullable|numeric|min:0',
            'september' => 'nullable|numeric|min:0',
            'october' => 'nullable|numeric|min:0',
            'november' => 'nullable|numeric|min:0',
            'december' => 'nullable|numeric|min:0',
            'january' => 'nullable|numeric|min:0',
            'february' => 'nullable|numeric|min:0',
            'march' => 'nullable|numeric|min:0',
            'total_kg_co2' => 'nullable|numeric|min:0',
        ];
    }
}