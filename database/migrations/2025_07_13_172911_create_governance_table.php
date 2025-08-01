<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance', function (Blueprint $table) {
            $table->id();
            
            // Dynamic fiscal year tracking
            $table->string('fiscal_year');
            
            // ANTI-BRIBERY AND ANTI-CORRUPTION
            $table->string('anti_corruption_pic');
            
            // Training percentages
            $table->decimal('management_trained_pct', 5, 2);
            $table->decimal('executive_trained_pct', 5, 2);
            $table->decimal('non_executive_trained_pct', 5, 2);
            $table->decimal('general_workers_trained_pct', 5, 2);
            
            // Operations assessed
            $table->decimal('operations_assessed_pct', 5, 2);
            
            // Incidents
            $table->integer('corruption_incidents_count');
            
            // HUMAN RIGHTS
            $table->string('human_rights_pic');
            $table->integer('human_rights_complaints');
            
            // DATA PRIVACY AND SECURITY
            $table->string('data_privacy_pic');
            $table->integer('data_privacy_breaches');
            
            // WHISTLEBLOWING
            $table->string('whistleblowing_pic');
            $table->string('whistleblowing_email');
            $table->string('whistleblowing_address');
            
            $table->timestamps();
            
            // Index for fiscal year queries
            $table->index('fiscal_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance');
    }
};