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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Pemrograman Web (Laravel)
            $table->string('study_program')->nullable(); // Contoh: S1 Informatika
            $table->string('instructor_name'); // Contoh: Dr. Arif Kurniawan, M.T.
            $table->string('banner_gradient')->default('from-blue-600 to-blue-700'); // Menyimpan class utilitas Tailwind
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
