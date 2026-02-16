<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PermintaanAkademikProgress;
use App\Models\AktivitasMahasiswaLog;
use App\Models\KKNAktivitas;

class NilaiController extends Controller
{
    public function index()
    {
        // Nilai dari Permintaan Akademik
        $nilaiPermintaan = PermintaanAkademikProgress::whereHas('permintaan', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('permintaan')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'p_' . $item->id,
                    'jenis' => $item->permintaan->type ?? 'Akademik',
                    'judul' => $item->judul,
                    'tanggal' => $item->tanggal,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'catatan_nilai' => $item->catatan_nilai,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'created_at' => $item->created_at
                ];
            });

        // Nilai dari Aktivitas Mahasiswa
        $nilaiAktivitas = AktivitasMahasiswaLog::whereHas('aktivitas', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('aktivitas')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'a_' . $item->id,
                    'jenis' => $item->aktivitas->jenis ?? 'Aktivitas',
                    'judul' => $item->judul,
                    'tanggal' => $item->tanggal ?? $item->created_at,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'catatan_nilai' => $item->catatan_nilai,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'created_at' => $item->created_at
                ];
            });

        // Nilai dari KKN
        $nilaiKKN = KKNAktivitas::whereHas('kkn', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('kkn')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'k_' . $item->id,
                    'jenis' => 'KKN - ' . ucfirst($item->tipe),
                    'judul' => $item->judul,
                    'tanggal' => $item->tanggal ?? $item->created_at,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'catatan_nilai' => $item->catatan_nilai,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'created_at' => $item->created_at
                ];
            });

        $nilaiList = $nilaiPermintaan->concat($nilaiAktivitas)->concat($nilaiKKN)->sortByDesc('created_at')->values();

        return Inertia::render('Nilai', [
            'nilaiList' => $nilaiList
        ]);
    }
}
