<?php

namespace App\Observers;

use App\Models\AktivitasMahasiswaLog;
use App\Models\AktivitasMahasiswa;

class AktivitasMahasiswaLogObserver
{
    public function updated(AktivitasMahasiswaLog $log)
    {
        // Update status aktivitas jika ada penilaian yang divalidasi
        if ($log->status_validasi === 'Divalidasi' && $log->nilai) {
            $aktivitas = $log->aktivitas;
            if ($aktivitas) {
                $aktivitas->update(['status' => 'Divalidasi']);
            }
        }
    }
}
