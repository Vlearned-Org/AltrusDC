<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentData extends Model
{
    use HasFactory;

    protected $table = 'environment_data';

    protected $fillable = [
        'metrics',
        'person_in_charge',
        'unit',
        'emission_factor',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'january',
        'february',
        'march',
        'total_kg_co2'
    ];

    protected $casts = [
        'emission_factor' => 'float',
        'april' => 'float',
        'may' => 'float',
        'june' => 'float',
        'july' => 'float',
        'august' => 'float',
        'september' => 'float',
        'october' => 'float',
        'november' => 'float',
        'december' => 'float',
        'january' => 'float',
        'february' => 'float',
        'march' => 'float',
        'total_kg_co2' => 'float',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->total_kg_co2 = $model->calculateTotal();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Calculate the total as sum of all months
     */
    public function calculateTotal()
    {
        $months = [
            'april', 'may', 'june', 'july', 'august', 'september',
            'october', 'november', 'december', 'january', 'february', 'march'
        ];

        $total = 0;
        foreach ($months as $month) {
            $total += (float) ($this->$month ?? 0);
        }

        return $total;
    }
}