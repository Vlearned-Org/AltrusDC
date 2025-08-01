<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_management', function (Blueprint $table) {
            $table->id();
            
            // Waste Type Information
            $table->string('waste_type'); // Plastics/Metal/Organic etc.
            $table->string('unit'); // Measurement unit (kg, tons, etc.)
            
            // Landfill Disposal
            $table->decimal('landfill_hazardous', 15, 2)->default(0);
            $table->decimal('landfill_non_hazardous', 15, 2)->default(0);
            
            // Incineration
            $table->decimal('incineration_hazardous', 15, 2)->default(0);
            $table->decimal('incineration_non_hazardous', 15, 2)->default(0);
            
            // Recycling
            $table->decimal('recycled_hazardous', 15, 2)->default(0);
            $table->decimal('recycled_non_hazardous', 15, 2)->default(0);
            
            // Reuse
            $table->decimal('reused_hazardous', 15, 2)->default(0);
            $table->decimal('reused_non_hazardous', 15, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_management');
    }
};