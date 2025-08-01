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
        Schema::create('environment_data', function (Blueprint $table) {
            $table->id();
        
            
            // Main headers
            $table->string('metrics');  // Changed from specific columns to generic metrics
            $table->string('person_in_charge')->nullable();
            $table->string('unit')->nullable();
            $table->float('emission_factor')->nullable();
            
            // Monthly columns
            $table->float('april')->nullable();
            $table->float('may')->nullable();
            $table->float('june')->nullable();
            $table->float('july')->nullable();
            $table->float('august')->nullable();
            $table->float('september')->nullable();
            $table->float('october')->nullable();
            $table->float('november')->nullable();
            $table->float('december')->nullable();
            $table->float('january')->nullable();
            $table->float('february')->nullable();
            $table->float('march')->nullable();
            
            $table->float('total_kg_co2')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('environment_data');
    }
};