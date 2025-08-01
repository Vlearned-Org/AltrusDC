<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_travels', function (Blueprint $table) {
            $table->id();
            $table->string('pic_name', 100)->nullable();
            $table->string('fiscal_year', 9);
            $table->string('employee_name', 100);
            $table->string('destination', 100);
            
            $table->enum('transport_mode', [
                'AIRCRAFT',
                'TRAIN',
                'CAR',
                'MOTORCYCLE',
                'BUS',
                'SHIP',
                'BOAT',
                'TAXI',
                'RIDE_HAILING',
                'BICYCLE',
                'WALKING',
                'OTHER'
            ])->default('CAR')->comment('Transportation method');
            
            $table->date('departure_date');
            $table->date('return_date');
            $table->text('purpose');
            $table->decimal('distance_km', 10, 2);
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('employee_name');
            $table->index('departure_date');
            $table->index('fiscal_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_travels');
    }
};