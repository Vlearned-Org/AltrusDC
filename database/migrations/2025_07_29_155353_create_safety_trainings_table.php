<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('safety_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('pic_name');
            $table->string('training_name');
            $table->string('fiscal_year');
            $table->decimal('training_hours', 5, 2);
            $table->integer('participants_count');
            $table->dateTime('training_datetime');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('safety_trainings');
    }
};