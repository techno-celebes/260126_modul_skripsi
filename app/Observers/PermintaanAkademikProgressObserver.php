<?php

namespace App\Observers;

use App\Models\PermintaanAkademikProgress;
use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaLog;

class PermintaanAkademikProgressObserver
{
    public function created(PermintaanAkademikProgress $progress)
    {
        // Auto sync ke aktivitas mahasiswa log
        $permintaan = $progress->permintaanAkademik;
        if ($permintaan) {
            $aktivitas = AktivitasMahasiswa::where('user_id', $permintaan->user_id)
                ->where('jenis', $permintaan->type)
                ->where('judul', $permintaan->judul)
                ->latest()
                ->first();
            
            if ($aktivitas) {
                AktivitasMahasiswaLog::create([
                    'aktivitas_mahasiswa_id' => $aktivitas->id,
                    'judul' => $progress->judul,
                    'deskripsi' => $progress->deskripsi,
                    'tanggal' => $progress->tanggal,
                    'file_path' => $progress->file_path,
                    'nilai' => $progress->nilai,
                    'status_validasi' => $progress->status_validasi,
                    'divalidasi_oleh' => $progress->divalidasi_oleh,
                    'catatan_nilai' => $progress->catatan_nilai
                ]);
            }
        }
    }

    public function updated(PermintaanAkademikProgress $progress)
    {
        // Sync update ke aktivitas mahasiswa log
        $permintaan = $progress->permintaanAkademik;
        if ($permintaan) {
            $aktivitas = AktivitasMahasiswa::where('user_id', $permintaan->user_id)
                ->where('jenis', $permintaan->type)
                ->where('judul', $permintaan->judul)
                ->latest()
                ->first();
            
            if ($aktivitas) {
                AktivitasMahasiswaLog::where('aktivitas_mahasiswa_id', $aktivitas->id)
                    ->where('judul', $progress->judul)
                    ->update([
                        'deskripsi' => $progress->deskripsi,
                        'tanggal' => $progress->tanggal,
                        'file_path' => $progress->file_path,
                        'nilai' => $progress->nilai,
                        'status_validasi' => $progress->status_validasi,
                        'divalidasi_oleh' => $progress->divalidasi_oleh,
                        'catatan_nilai' => $progress->catatan_nilai
                    ]);

                // Update status aktivitas jika ada penilaian yang divalidasi
                if ($progress->status_validasi === 'Divalidasi' && $progress->nilai) {
                    $aktivitas->update(['status' => 'Divalidasi']);
                    $permintaan->update(['status_proposal' => 'Divalidasi']);
                }
            }
        }
    }
}
