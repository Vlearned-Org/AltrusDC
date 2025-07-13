<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('economic_data', function (Blueprint $table) {
    $table->id();
    $table->foreignId('company_id')->constrained();
    $table->integer('year');
    
    // Supply Chain
    $table->float('local_vendor_spend')->nullable();
    $table->float('international_vendor_spend')->nullable();
    
    // Economic Value
    $table->float('goods_revenue')->nullable();
    $table->float('services_revenue')->nullable();
    $table->float('investment_revenue')->nullable();
    $table->float('other_income')->nullable();
    
    // Economic Value Distributed
    $table->float('operating_expenses')->nullable();
    $table->float('employee_wages')->nullable();
    $table->float('capital_payments')->nullable();
    $table->float('government_payments')->nullable();
    $table->float('community_investment')->nullable();
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('economic_data');
    }
};
