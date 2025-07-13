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
        Schema::create('social_data', function (Blueprint $table) {
    $table->id();
    $table->foreignId('company_id')->constrained();
    $table->integer('year');
    
    // Employee Composition
    $table->integer('total_employees_start')->nullable();
    $table->integer('total_employees_end')->nullable();
    
    // By Category
    $table->json('management_breakdown')->nullable(); // {male, female, below_30, etc.}
    $table->json('executive_breakdown')->nullable();
    $table->json('non_executive_breakdown')->nullable();
    $table->json('general_worker_breakdown')->nullable();
    
    // Turnover
    $table->integer('management_turnover')->nullable();
    $table->integer('executive_turnover')->nullable();
    $table->integer('non_executive_turnover')->nullable();
    $table->integer('general_worker_turnover')->nullable();
    
    // Ethnicity
    $table->integer('malay_employees')->nullable();
    $table->integer('chinese_employees')->nullable();
    $table->integer('indian_employees')->nullable();
    $table->integer('other_ethnicity_employees')->nullable();
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_data');
    }
};
