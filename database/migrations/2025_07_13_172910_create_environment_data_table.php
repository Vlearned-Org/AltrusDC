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
    $table->foreignId('company_id')->constrained();
    $table->integer('year');
    
    // Scope 1 Emissions
    $table->float('diesel_consumption')->nullable();
    $table->float('petrol_consumption')->nullable();
    $table->float('lpg_gas')->nullable();
    $table->float('other_gas')->nullable();
    
    // Scope 2 Emissions
    $table->float('electricity_consumption')->nullable();
    $table->float('solar_generated')->nullable();
    
    // Water Management
    $table->float('water_consumption')->nullable();
    $table->float('water_recycled')->nullable();
    
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
