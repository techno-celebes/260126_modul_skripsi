<?php

namespace App\Observers;

use App\Models\KKNAktivitas;
use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaLog;

class KKNAktivitasObserver
{
    public function created(KKNAktivitas $kknAktivitas)
    {
        // Auto sync ke aktivitas mahasiswa log
        $kkn = $kknAktivitas->kkn;
        if ($kkn) {
            $aktivitas = AktivitasMahasiswa::where('user_id', $kkn->user_id)
                ->where('jenis', 'KKN')
                ->latest()
                ->first();
            
            if ($aktivitas) {
                AktivitasMahasiswaLog::create([
                    'aktivitas_mahasiswa_id' => $aktivitas->id,
                    'judul' => $kknAktivitas->judul,
                    'deskripsi' => $kknAktivitas->deskripsi,
                    'tanggal' => $kknAktivitas->tanggal,
                    'file_path' => $kknAktivitas->file_path,
                    'nilai' => $kknAktivitas->nilai,
                    'status_validasi' => $kknAktivitas->status_validasi,
                    'divalidasi_oleh' => $kknAktivitas->divalidasi_oleh,
                    'catatan_nilai' => $kknAktivitas->catatan_nilai
                ]);
            }
        }
    }

    public function updated(KKNAktivitas $kknAktivitas)
    {
        // Sync update ke aktivitas mahasiswa log
        $kkn = $kknAktivitas->kkn;
        if ($kkn) {
            $aktivitas = AktivitasMahasiswa::where('user_id', $kkn->user_id)
                ->where('jenis', 'KKN')
                ->latest()
                ->first();
            
            if ($aktivitas) {
                AktivitasMahasiswaLog::where('aktivitas_mahasiswa_id', $aktivitas->id)
                    ->where('judul', $kknAktivitas->judul)
                    ->update([
                        'deskripsi' => $kknAktivitas->deskripsi,
                        'tanggal' => $kknAktivitas->tanggal,
                        'file_path' => $kknAktivitas->file_path,
                        'nilai' => $kknAktivitas->nilai,
                        'status_validasi' => $kknAktivitas->status_validasi,
                        'divalidasi_oleh' => $kknAktivitas->divalidasi_oleh,
                        'catatan_nilai' => $kknAktivitas->catatan_nilai
                    ]);

                // Update status aktivitas jika ada penilaian yang divalidasi
                if ($kknAktivitas->status_validasi === 'Divalidasi' && $kknAktivitas->nilai) {
                    $aktivitas->update(['status' => 'Divalidasi']);
                    $kkn->update(['status' => 'Divalidasi']);
                }
            }
        }
    }
}
