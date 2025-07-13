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
        Schema::create('governance_data', function (Blueprint $table) {
    $table->id();
    $table->foreignId('company_id')->constrained();
    $table->integer('year');
    
    // Anti-corruption
    $table->float('management_anti_corruption_trained')->nullable();
    $table->float('executive_anti_corruption_trained')->nullable();
    $table->float('non_executive_anti_corruption_trained')->nullable();
    $table->float('general_worker_anti_corruption_trained')->nullable();
    $table->float('operations_assessed')->nullable();
    $table->integer('corruption_incidents')->nullable();
    
    // Human Rights
    $table->integer('human_rights_complaints')->nullable();
    
    // Data Privacy
    $table->integer('data_privacy_breaches')->nullable();
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('governance_data');
    }
};
