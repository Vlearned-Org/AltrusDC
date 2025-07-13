<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialData extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'year', 'total_employees_start', 'total_employees_end',
        'management_breakdown', 'executive_breakdown', 'non_executive_breakdown',
        'general_worker_breakdown', 'management_turnover', 'executive_turnover',
        'non_executive_turnover', 'general_worker_turnover', 'malay_employees',
        'chinese_employees', 'indian_employees', 'other_ethnicity_employees'
    ];

    protected $casts = [
        'management_breakdown' => 'array',
        'executive_breakdown' => 'array',
        'non_executive_breakdown' => 'array',
        'general_worker_breakdown' => 'array',
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