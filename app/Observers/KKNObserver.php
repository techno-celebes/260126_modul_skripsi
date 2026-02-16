<?php

namespace App\Observers;

use App\Models\KKN;
use App\Models\AktivitasMahasiswa;

class KKNObserver
{
    public function created(KKN $kkn)
    {
        // Auto sync ke aktivitas mahasiswa
        AktivitasMahasiswa::updateOrCreate(
            [
                'user_id' => $kkn->user_id,
                'jenis' => 'KKN',
                'keterangan' => 'KKN di ' . $kkn->alamat . ' selama ' . $kkn->durasi
            ],
            [
                'nama' => $kkn->nama,
                'nim' => $kkn->nim,
                'status' => $kkn->status
            ]
        );
    }

    public function updated(KKN $kkn)
    {
        // Sync status ke aktivitas mahasiswa
        AktivitasMahasiswa::where('user_id', $kkn->user_id)
            ->where('jenis', 'KKN')
            ->where('keterangan', 'LIKE', '%' . $kkn->alamat . '%')
            ->update(['status' => $kkn->status]);
    }
}
