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
       Schema::create('attachments', function (Blueprint $table) {
    $table->id();
    $table->morphs('attachable'); // Polymorphic relation
    $table->string('file_path');
    $table->string('file_name');
    $table->string('file_type');
    $table->unsignedBigInteger('file_size');
    $table->text('description')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
