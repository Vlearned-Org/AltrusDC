<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Economic extends Model
{
    use HasFactory;

    protected $table = 'economic';

    protected $fillable = [
        'supply_chain_pic',
        'economic_value_pic',
        'fiscal_year',
        
        // Supply Chain Metrics
        'local_vendor_spending',
        'international_vendor_spending',
        'total_expenditure',
        'local_percentage',
        'international_percentage',
        'total_percentage',
        
        // Economic Value Generated
        'goods_revenue',
        'services_revenue',
        'investments_revenue',
        'other_income',
        'total_value_generated',
        
        // Economic Value Distributed
        'operating_expenses',
        'employee_wages',
        'financial_institutions_payments',
        'shareholders_payments',
        'government_payments',
        'income_tax',
        'community_investment',
        'total_value_distributed',
        'value_retained'
    ];

    protected $casts = [
        'fiscal_year' => 'integer',
        'local_vendor_spending' => 'decimal:2',
        'international_vendor_spending' => 'decimal:2',
        'total_expenditure' => 'decimal:2',
        'local_percentage' => 'decimal:2',
        'international_percentage' => 'decimal:2',
        'total_percentage' => 'decimal:2',
        'goods_revenue' => 'decimal:2',
        'services_revenue' => 'decimal:2',
        'investments_revenue' => 'decimal:2',
        'other_income' => 'decimal:2',
        'total_value_generated' => 'decimal:2',
        'operating_expenses' => 'decimal:2',
        'employee_wages' => 'decimal:2',
        'financial_institutions_payments' => 'decimal:2',
        'shareholders_payments' => 'decimal:2',
        'government_payments' => 'decimal:2',
        'income_tax' => 'decimal:2',
        'community_investment' => 'decimal:2',
        'total_value_distributed' => 'decimal:2',
        'value_retained' => 'decimal:2'
    ];

    // Calculate derived fields
    public function calculateDerivedValues()
    {
        // Supply Chain Calculations
        $this->total_expenditure = $this->local_vendor_spending + $this->international_vendor_spending;
        
        if ($this->total_expenditure > 0) {
            $this->local_percentage = ($this->local_vendor_spending / $this->total_expenditure) * 100;
            $this->international_percentage = ($this->international_vendor_spending / $this->total_expenditure) * 100;
        }
        
        // Economic Value Calculations
        $this->total_value_generated = $this->goods_revenue 
            + $this->services_revenue 
            + $this->investments_revenue 
            + $this->other_income;
            
        $this->total_value_distributed = $this->operating_expenses
            + $this->employee_wages
            + $this->financial_institutions_payments
            + $this->shareholders_payments
            + $this->government_payments
            + $this->community_investment;
            
        $this->value_retained = $this->total_value_generated - $this->total_value_distributed;
        
        return $this;
    }
}