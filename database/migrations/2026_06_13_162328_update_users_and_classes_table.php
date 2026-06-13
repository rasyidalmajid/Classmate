<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah role global di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // admin, user
        });

        // Tambah kode unik dan relasi pembuat kelas (instructor_id)
        Schema::table('classes', function (Blueprint $table) {
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('code', 6)->unique()->nullable();
            // Hapus kolom instructor_name lama jika ada
            if (Schema::hasColumn('classes', 'instructor_name')) {
                $table->dropColumn('instructor_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->dropColumn(['instructor_id', 'code']);
            $table->string('instructor_name')->nullable();
        });
    }
};
