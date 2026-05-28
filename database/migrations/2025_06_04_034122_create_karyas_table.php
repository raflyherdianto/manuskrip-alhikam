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
        Schema::create('karyas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jenis_karya_id')->constrained('jenis_karyas')->cascadeOnDelete();
            // Metadata
            $table->string('title');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->text('description');
            $table->string('source');
            $table->date('date');
            $table->foreignId('pembimbing_id')->constrained('users')->cascadeOnDelete();
            $table->enum('rights', ['Semua', 'Terbatas']);
            $table->string('relation');
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->string('coverage');
            $table->enum('status', ['Menunggu', 'Terpublish', 'Ditolak', 'Arsip']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyas');
    }
};
