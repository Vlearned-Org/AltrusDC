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
Schema::create('companies', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('location');
    $table->string('reporting_date');
    $table->string('color_code');
    $table->string('logo_path')->nullable();
    $table->text('mission')->nullable();
    $table->text('vision')->nullable();
    $table->text('sustainability_commitment')->nullable();
    $table->timestamps();
});    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
