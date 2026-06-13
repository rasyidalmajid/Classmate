<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            // Menambahkan field yang belum ada di database
            $table->integer('grade')->nullable()->after('file_path');
            $table->text('feedback')->nullable()->after('grade');
            $table->text('notes')->nullable()->after('link_url'); // Catatan dari mahasiswa
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['grade', 'feedback', 'notes']);
        });
    }
};
