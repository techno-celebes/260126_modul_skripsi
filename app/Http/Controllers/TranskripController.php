<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AktivitasMahasiswaLog;
use App\Models\PermintaanAkademikProgress;
use App\Models\Bimbingan;

class TranskripController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Gabungkan data dari berbagai sumber
        $transkrip = collect();
        
        // 1. Dari aktivitas mahasiswa log (KKN, Magang, dll)
        $aktivitasLogs = AktivitasMahasiswaLog::where('user_id', $userId)
            ->whereNotNull('nilai')
            ->where('status_validasi', 'Disetujui')
            ->get()
            ->map(function($log) {
                return [
                    'id' => 'log_' . $log->id,
                    'jenis' => $log->jenis,
                    'keterangan' => $log->judul,
                    'tanggal' => $log->tanggal ?? $log->created_at,
                    'nilai' => $log->nilai,
                    'status' => $log->status_validasi
                ];
            });
        
        // 2. Dari progress tugas akhir (asistensi)
        $progressNilai = PermintaanAkademikProgress::whereHas('permintaan', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereNotNull('nilai')
            ->where('status_validasi', 'Disetujui')
            ->with('permintaan')
            ->get()
            ->map(function($progress) {
                return [
                    'id' => 'progress_' . $progress->id,
                    'jenis' => $progress->permintaan->type ?? 'Tugas Akhir',
                    'keterangan' => $progress->judul,
                    'tanggal' => $progress->tanggal,
                    'nilai' => $progress->nilai,
                    'status' => $progress->status_validasi
                ];
            });
        
        // 3. Dari bimbingan yang dinilai
        $bimbinganNilai = Bimbingan::whereHas('permintaan', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereNotNull('nilai')
            ->where('status_validasi', 'Disetujui')
            ->with('permintaan')
            ->get()
            ->map(function($bimbingan) {
                return [
                    'id' => 'bimbingan_' . $bimbingan->id,
                    'jenis' => 'Bimbingan',
                    'keterangan' => $bimbingan->judul,
                    'tanggal' => $bimbingan->tanggal,
                    'nilai' => $bimbingan->nilai,
                    'status' => $bimbingan->status_validasi
                ];
            });
        
        // Gabungkan semua dan urutkan
        $transkrip = $aktivitasLogs
            ->concat($progressNilai)
            ->concat($bimbinganNilai)
            ->sortByDesc('tanggal')
            ->values();

        return Inertia::render('Transkrip', [
            'transkrip' => $transkrip,
            'user' => auth()->user()
        ]);
    }
}
