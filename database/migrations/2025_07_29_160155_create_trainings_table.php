<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('pic_name')->nullable();
            $table->string('training_category');
            $table->string('fiscal_year', 10);
            $table->decimal('training_hours', 8, 2)->nullable();
            $table->integer('management')->default(0);
            $table->integer('executive')->default(0);
            $table->integer('non_executive')->default(0);
            $table->integer('general_worker')->default(0);
            $table->integer('total_participants')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};