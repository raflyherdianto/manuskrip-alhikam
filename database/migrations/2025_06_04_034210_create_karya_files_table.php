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
        Schema::create('karya_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karya_id')->constrained('karyas')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('format');
            $table->unsignedBigInteger('size'); // ukuran dalam byte
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karya_files');
    }
};
