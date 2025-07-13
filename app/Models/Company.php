<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'reporting_date', 'color_code', 
        'logo_path', 'mission', 'vision', 'sustainability_commitment'
    ];

    public function subsidiaries()
    {
        return $this->hasMany(Subsidiary::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function environmentData()
    {
        return $this->hasMany(EnvironmentData::class);
    }

    public function economicData()
    {
        return $this->hasMany(EconomicData::class);
    }

    public function socialData()
    {
        return $this->hasMany(SocialData::class);
    }

    public function governanceData()
    {
        return $this->hasMany(GovernanceData::class);
    }
}