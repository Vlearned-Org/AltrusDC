<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentData extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'year', 'diesel_consumption', 'petrol_consumption',
        'lpg_gas', 'other_gas', 'electricity_consumption', 'solar_generated',
        'water_consumption', 'water_recycled'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}