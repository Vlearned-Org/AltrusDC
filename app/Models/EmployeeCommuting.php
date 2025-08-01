<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCommuting extends Model
{
    use HasFactory;

    protected $table = 'employee_commuting';

    protected $fillable = [
        'employee_name',
        'department',
        'mode_of_transport',
        'type_of_fuel',
        'distance_traveled',
        'commence_date',
        'end_date',
        'exclude_public_holidays',
        'exclude_weekends',
        'leave_days',
        'unpaid_other_leave',
        'mc_days',
        'days_commuting',
        'km_petrol',
        'km_diesel',
        
        'year',
    ];

    protected $casts = [
        'commence_date' => 'date',
        'end_date' => 'date',
        'distance_traveled' => 'decimal:2',
        'km_petrol' => 'decimal:2',
        'km_diesel' => 'decimal:2',
    ];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Calculate commuting days automatically
    public function calculateCommutingDays()
    {
        $totalDays = $this->end_date->diffInDays($this->commence_date) + 1;
        $excludedDays = $this->exclude_public_holidays + $this->exclude_weekends + $this->leave_days + $this->unpaid_other_leave + $this->mc_days;
        
        $this->days_commuting = max(0, $totalDays - $excludedDays);
        $this->save();
    }
}