<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialData extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'total_employees_start', 'total_employees_end', 'pic_name',
        
        // Management
        'management_male', 'management_female', 
        'management_below_30', 'management_30_to_50', 'management_above_50',
        
        // Executive
        'executive_male', 'executive_female',
        'executive_below_30', 'executive_30_to_50', 'executive_above_50',
        
        // Non-Executive
        'non_executive_male', 'non_executive_female',
        'non_executive_below_30', 'non_executive_30_to_50', 'non_executive_above_50',
        
        // General Worker
        'general_worker_male', 'general_worker_female',
        'general_worker_below_30', 'general_worker_30_to_50', 'general_worker_above_50',
        
        // Race/Ethnicity
        'malay_employees', 'chinese_employees', 'indian_employees', 'other_ethnicity_employees',
        
        // Board of Directors
        'directors_male', 'directors_female',
        'directors_below_30', 'directors_30_to_50', 'directors_above_50',
        
        // Turnover
        'management_turnover', 'executive_turnover', 'non_executive_turnover', 'general_worker_turnover',
        
        // New Hires
        'management_new_hires', 'executive_new_hires', 'non_executive_new_hires', 'general_worker_new_hires',
        
        // Employment Types
        'percentage_permanent', 'percentage_temporary', 'percentage_contract'
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