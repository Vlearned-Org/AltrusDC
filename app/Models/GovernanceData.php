<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernanceData extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'year', 'management_anti_corruption_trained',
        'executive_anti_corruption_trained', 'non_executive_anti_corruption_trained',
        'general_worker_anti_corruption_trained', 'operations_assessed',
        'corruption_incidents', 'human_rights_complaints', 'data_privacy_breaches'
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