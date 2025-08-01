<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_commuting', function (Blueprint $table) {
            $table->id();
            
            // Exact match to provided columns
            $table->string('employee_name');                          // Name of Employee
            $table->string('department');                             // Department
            $table->string('mode_of_transport');                      // Mode of Transport (renamed from transport_mode)
            $table->string('type_of_fuel')->nullable();               // Type of Fuel
            $table->decimal('distance_traveled', 10, 2);              // Distance Traveled from home to office to home (Km)
            $table->date('commence_date');                            // Commence
            $table->date('end_date');                                 // end
            $table->integer('exclude_public_holidays')->default(0);   // exclude M'sia Public holidays
            $table->integer('exclude_weekends')->default(0);          // Saturday & Sunday
            $table->integer('leave_days')->default(0);                // Leave (day)
            $table->integer('unpaid_other_leave')->default(0);        // unpaid/other leave
            $table->integer('mc_days')->default(0);                   // MC
            $table->integer('days_commuting')->nullable();            // Days commuting
            $table->decimal('km_petrol', 10, 2)->nullable();          // KM Petrol
            $table->decimal('km_diesel', 10, 2)->nullable();          // KM (Diesel)
            
        
            $table->integer('year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_commuting');
    }
};