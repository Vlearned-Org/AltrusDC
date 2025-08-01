<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('economic', function (Blueprint $table) {
            $table->id();
            
            // Common Fields
            $table->string('supply_chain_pic')->nullable();
            $table->string('economic_value_pic')->nullable();
            $table->year('fiscal_year');
            
            // Supply Chain Management Section
            $table->decimal('local_vendor_spending', 15, 2)->nullable();
            $table->decimal('international_vendor_spending', 15, 2)->nullable();
            $table->decimal('total_expenditure', 15, 2)->nullable();
            $table->decimal('local_percentage', 5, 2)->nullable();
            $table->decimal('international_percentage', 5, 2)->nullable();
            $table->decimal('total_percentage', 5, 2)->nullable();
            
            // Economic Value Generated Section
            $table->decimal('goods_revenue', 15, 2)->nullable();
            $table->decimal('services_revenue', 15, 2)->nullable();
            $table->decimal('investments_revenue', 15, 2)->nullable();
            $table->decimal('other_income', 15, 2)->nullable();
            $table->decimal('total_value_generated', 15, 2)->nullable();
            
            // Economic Value Distributed Section
            $table->decimal('operating_expenses', 15, 2)->nullable();
            $table->decimal('employee_wages', 15, 2)->nullable();
            $table->decimal('financial_institutions_payments', 15, 2)->nullable();
            $table->decimal('shareholders_payments', 15, 2)->nullable();
            $table->decimal('government_payments', 15, 2)->nullable();
            $table->decimal('income_tax', 15, 2)->nullable();
            $table->decimal('community_investment', 15, 2)->nullable();
            $table->decimal('total_value_distributed', 15, 2)->nullable();
            $table->decimal('value_retained', 15, 2)->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('fiscal_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('economic');
    }
};