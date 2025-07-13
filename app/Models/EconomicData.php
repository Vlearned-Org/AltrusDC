<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicData extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'year', 'local_vendor_spend', 'international_vendor_spend',
        'goods_revenue', 'services_revenue', 'investment_revenue', 'other_income',
        'operating_expenses', 'employee_wages', 'capital_payments', 'government_payments',
        'community_investment'
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