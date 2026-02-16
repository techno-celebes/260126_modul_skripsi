<?php

namespace App\Observers;

use App\Models\PermintaanAkademik;
use App\Models\AktivitasMahasiswa;

class PermintaanAkademikObserver
{
    public function created(PermintaanAkademik $permintaan)
    {
        // Auto sync ke aktivitas mahasiswa
        AktivitasMahasiswa::updateOrCreate(
            [
                'user_id' => $permintaan->user_id,
                'jenis' => $permintaan->type,
                'judul' => $permintaan->judul
            ],
            [
                'nama' => $permintaan->nama,
                'nim' => $permintaan->nim,
                'keterangan' => $permintaan->keterangan ?? 'Permintaan ' . $permintaan->type,
                'status' => $permintaan->status_proposal ?? 'Menunggu',
                'dosen_pembimbing' => $permintaan->dosen_pembimbing,
                'tanggal_pengajuan' => $permintaan->tanggal_pengajuan
            ]
        );
    }

    public function updated(PermintaanAkademik $permintaan)
    {
        // Sync status ke aktivitas mahasiswa
        AktivitasMahasiswa::where('user_id', $permintaan->user_id)
            ->where('jenis', $permintaan->type)
            ->where('judul', $permintaan->judul)
            ->update([
                'status' => $permintaan->status_proposal ?? 'Menunggu',
                'dosen_pembimbing' => $permintaan->dosen_pembimbing,
                'tanggal_persetujuan' => $permintaan->tanggal_persetujuan
            ]);
    }
}
