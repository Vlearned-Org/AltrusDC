<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governance extends Model
{
    use HasFactory;

    protected $fillable = [
        'fiscal_year',
        'anti_corruption_pic',
        'management_trained_pct',
        'executive_trained_pct',
        'non_executive_trained_pct',
        'general_workers_trained_pct',
        'operations_assessed_pct',
        'corruption_incidents_count',
        'human_rights_pic',
        'human_rights_complaints',
        'data_privacy_pic',
        'data_privacy_breaches',
        'whistleblowing_pic',
        'whistleblowing_email',
        'whistleblowing_address'
    ];

    protected $casts = [
        'management_trained_pct' => 'decimal:2',
        'executive_trained_pct' => 'decimal:2',
        'non_executive_trained_pct' => 'decimal:2',
        'general_workers_trained_pct' => 'decimal:2',
        'operations_assessed_pct' => 'decimal:2'
    ];
}