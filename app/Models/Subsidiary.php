<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subsidiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
       
    ];

 

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    /**
     * Get the display name with ownership percentage
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} (" . number_format($this->ownership_percentage, 1) . "%)";
    }

    /**
     * Scope for majority-owned subsidiaries (>=50%)
     */
    public function scopeMajorityOwned($query)
    {
        return $query->where('ownership_percentage', '>=', 50);
    }

    /**
     * Scope for minority-owned subsidiaries (<50%)
     */
    public function scopeMinorityOwned($query)
    {
        return $query->where('ownership_percentage', '<', 50);
    }
}