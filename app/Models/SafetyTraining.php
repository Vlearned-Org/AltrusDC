<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic_name',
        'training_name',
        'fiscal_year',
        'training_hours',
        'participants_count',
        'training_datetime'
    ];

    protected $casts = [
        'training_datetime' => 'datetime',
        'training_hours' => 'decimal:2'
    ];
}