<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('social_data', function (Blueprint $table) {
            $table->id();
          
            
            // Basic employee counts
            $table->integer('total_employees_start')->nullable();
            $table->integer('total_employees_end')->nullable();
            $table->string('pic_name')->nullable();
            
            // Employee by category - Management
            $table->integer('management_male')->nullable();
            $table->integer('management_female')->nullable();
            $table->integer('management_below_30')->nullable();
            $table->integer('management_30_to_50')->nullable();
            $table->integer('management_above_50')->nullable();
            
            // Employee by category - Executive
            $table->integer('executive_male')->nullable();
            $table->integer('executive_female')->nullable();
            $table->integer('executive_below_30')->nullable();
            $table->integer('executive_30_to_50')->nullable();
            $table->integer('executive_above_50')->nullable();
            
            // Employee by category - Non-Executive
            $table->integer('non_executive_male')->nullable();
            $table->integer('non_executive_female')->nullable();
            $table->integer('non_executive_below_30')->nullable();
            $table->integer('non_executive_30_to_50')->nullable();
            $table->integer('non_executive_above_50')->nullable();
            
            // Employee by category - General Worker
            $table->integer('general_worker_male')->nullable();
            $table->integer('general_worker_female')->nullable();
            $table->integer('general_worker_below_30')->nullable();
            $table->integer('general_worker_30_to_50')->nullable();
            $table->integer('general_worker_above_50')->nullable();
            
            // Race and Ethnicity
            $table->integer('malay_employees')->nullable();
            $table->integer('chinese_employees')->nullable();
            $table->integer('indian_employees')->nullable();
            $table->integer('other_ethnicity_employees')->nullable();
            
            // Board of Directors
            $table->integer('directors_male')->nullable();
            $table->integer('directors_female')->nullable();
            $table->integer('directors_below_30')->nullable();
            $table->integer('directors_30_to_50')->nullable();
            $table->integer('directors_above_50')->nullable();
            
            // Employee Turnover
            $table->integer('management_turnover')->nullable();
            $table->integer('executive_turnover')->nullable();
            $table->integer('non_executive_turnover')->nullable();
            $table->integer('general_worker_turnover')->nullable();
            
            // New Hires
            $table->integer('management_new_hires')->nullable();
            $table->integer('executive_new_hires')->nullable();
            $table->integer('non_executive_new_hires')->nullable();
            $table->integer('general_worker_new_hires')->nullable();
            
            // Employment Type Percentages
            $table->decimal('percentage_permanent', 5, 2)->nullable();
            $table->decimal('percentage_temporary', 5, 2)->nullable();
            $table->decimal('percentage_contract', 5, 2)->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_data');
    }
};