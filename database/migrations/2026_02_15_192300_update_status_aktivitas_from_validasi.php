<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update status aktivitas mahasiswa berdasarkan penilaian yang sudah divalidasi
        
        // 1. Update dari KKN Aktivitas
        $kknAktivitasValidasi = DB::table('kkn_aktivitas')
            ->where('status_validasi', 'Divalidasi')
            ->whereNotNull('nilai')
            ->get();
        
        foreach ($kknAktivitasValidasi as $kknAktivitas) {
            $kkn = DB::table('kkn')->where('id', $kknAktivitas->kkn_id)->first();
            if ($kkn) {
                DB::table('kkn')->where('id', $kkn->id)->update(['status' => 'Divalidasi']);
                DB::table('aktivitas_mahasiswa')
                    ->where('user_id', $kkn->user_id)
                    ->where('jenis', 'KKN')
                    ->update(['status' => 'Divalidasi']);
            }
        }
        
        // 2. Update dari Permintaan Akademik Progress
        $progressValidasi = DB::table('permintaan_akademik_progress')
            ->where('status_validasi', 'Divalidasi')
            ->whereNotNull('nilai')
            ->get();
        
        foreach ($progressValidasi as $progress) {
            $permintaan = DB::table('permintaan_akademiks')->where('id', $progress->permintaan_akademik_id)->first();
            if ($permintaan) {
                DB::table('permintaan_akademiks')->where('id', $permintaan->id)->update(['status_proposal' => 'Divalidasi']);
                DB::table('aktivitas_mahasiswa')
                    ->where('user_id', $permintaan->user_id)
                    ->where('jenis', $permintaan->type)
                    ->where('judul', $permintaan->judul)
                    ->update(['status' => 'Divalidasi']);
            }
        }
        
        // 3. Update dari Aktivitas Mahasiswa Log
        $logValidasi = DB::table('aktivitas_mahasiswa_log')
            ->where('status_validasi', 'Divalidasi')
            ->whereNotNull('nilai')
            ->get();
        
        foreach ($logValidasi as $log) {
            DB::table('aktivitas_mahasiswa')
                ->where('id', $log->aktivitas_mahasiswa_id)
                ->update(['status' => 'Divalidasi']);
        }
    }

    public function down(): void
    {
        // Tidak perlu rollback karena ini adalah data migration
    }
};
