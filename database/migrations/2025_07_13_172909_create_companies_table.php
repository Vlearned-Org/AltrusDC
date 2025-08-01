<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('location');
            $table->date('reporting_date');
            $table->integer('total_subsidiaries')->default(0);
            
            // Branding
            $table->string('color_code');
            $table->string('logo_path')->nullable();
            
            // Mission/Vision
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            
            // Sustainability Goals
            $table->boolean('carbon_footprint_reduction')->default(false);
            $table->boolean('sustainable_sourcing')->default(false);
            $table->boolean('energy_efficiency')->default(false);
            $table->boolean('waste_reduction')->default(false);
            $table->boolean('employee_engagement')->default(false);
            $table->text('other_sustainability_goals')->nullable();
            
            // Subsidiaries
            $table->json('subsidiaries_list')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};