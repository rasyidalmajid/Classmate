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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'classes'
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('title'); // Judul Tugas
            $table->text('description')->nullable(); // Detail instruksi pengerjaan
            $table->dateTime('deadline'); // Tanggal dan jam batas pengumpulan
            $table->enum('status', ['assigned', 'completed'])->default('assigned'); // Status tracking tugas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
