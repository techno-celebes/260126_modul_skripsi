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
        Schema::table('aktivitas_mahasiswa', function (Blueprint $table) {
            $table->string('judul')->nullable()->after('keterangan');
            $table->string('dosen_pembimbing')->nullable()->after('judul');
            $table->string('dosen_pembimbing_id')->nullable()->after('dosen_pembimbing');
            $table->date('tanggal_pengajuan')->nullable()->after('dosen_pembimbing_id');
            $table->date('tanggal_persetujuan')->nullable()->after('tanggal_pengajuan');
            $table->string('status_proposal')->default('Menunggu')->after('tanggal_persetujuan');
            $table->string('disetujui_oleh')->nullable()->after('status_proposal');
            $table->boolean('is_selesai')->default(false)->after('disetujui_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aktivitas_mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'judul',
                'dosen_pembimbing',
                'dosen_pembimbing_id',
                'tanggal_pengajuan',
                'tanggal_persetujuan',
                'status_proposal',
                'disetujui_oleh',
                'is_selesai'
            ]);
        });
    }
};
