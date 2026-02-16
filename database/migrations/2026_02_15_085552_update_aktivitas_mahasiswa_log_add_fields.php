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
        Schema::table('aktivitas_mahasiswa_log', function (Blueprint $table) {
            $table->string('jenis_log')->default('progress')->after('aktivitas_mahasiswa_id');
            $table->string('status_validasi')->nullable()->after('file_path');
            $table->string('divalidasi_oleh')->nullable()->after('status_validasi');
            $table->date('tanggal_validasi')->nullable()->after('divalidasi_oleh');
            $table->boolean('is_selesai')->default(false)->after('tanggal_validasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aktivitas_mahasiswa_log', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_log',
                'status_validasi',
                'divalidasi_oleh',
                'tanggal_validasi',
                'is_selesai'
            ]);
        });
    }
};
