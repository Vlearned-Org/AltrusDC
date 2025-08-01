<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'waste_type',
        'unit',
        'landfill_hazardous',
        'landfill_non_hazardous',
        'incineration_hazardous',
        'incineration_non_hazardous',
        'recycled_hazardous',
        'recycled_non_hazardous',
        'reused_hazardous',
        'reused_non_hazardous'
    ];
}