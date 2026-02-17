<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PermintaanAkademikProgress;

class PenilaianController extends Controller
{
    public function index()
    {
        // Upload dari Permintaan Akademik
        $uploadsPermintaan = PermintaanAkademikProgress::with('permintaan.user')
            ->where('jenis_progress', 'asistensi')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'p_' . $item->id,
                    'type' => 'permintaan',
                    'permintaan' => $item->permintaan,
                    'mahasiswa' => $item->permintaan->user->name ?? $item->permintaan->nama,
                    'jenis' => $item->permintaan->type,
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi,
                    'tanggal' => $item->tanggal,
                    'file_path' => $item->file_path,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'catatan_nilai' => $item->catatan_nilai,
                    'original_id' => $item->id
                ];
            });

        // Upload dari Aktivitas Mahasiswa Log
        $uploadsAktivitas = \App\Models\AktivitasMahasiswaLog::with('aktivitas.user')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'a_' . $item->id,
                    'type' => 'aktivitas',
                    'permintaan' => (object)['user' => $item->aktivitas->user, 'nama' => $item->aktivitas->nama],
                    'mahasiswa' => $item->aktivitas->user->name ?? $item->aktivitas->nama,
                    'jenis' => $item->aktivitas->jenis ?? 'Aktivitas',
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi,
                    'tanggal' => $item->tanggal ?? $item->created_at,
                    'file_path' => $item->file_path,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'catatan_nilai' => $item->catatan_nilai,
                    'original_id' => $item->id
                ];
            });

        // Upload dari KKN Aktivitas
        $uploadsKKN = \App\Models\KKNAktivitas::with('kkn.user')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'k_' . $item->id,
                    'type' => 'kkn',
                    'permintaan' => (object)['user' => $item->kkn->user, 'nama' => $item->kkn->nama],
                    'mahasiswa' => $item->kkn->user->name ?? $item->kkn->nama,
                    'jenis' => 'KKN - ' . ucfirst($item->tipe),
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi,
                    'tanggal' => $item->tanggal ?? $item->created_at,
                    'file_path' => $item->file_path,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'catatan_nilai' => $item->catatan_nilai,
                    'original_id' => $item->id
                ];
            });

        // Upload dari Bimbingan
        $uploadsBimbingan = \App\Models\Bimbingan::with('permintaan.user')
            ->whereNotNull('file_path')
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'b_' . $item->id,
                    'type' => 'bimbingan',
                    'permintaan' => $item->permintaan,
                    'mahasiswa' => $item->permintaan->user->name ?? $item->permintaan->nama,
                    'jenis' => 'Bimbingan - ' . $item->permintaan->type,
                    'judul' => $item->judul,
                    'deskripsi' => $item->catatan,
                    'tanggal' => $item->tanggal,
                    'file_path' => $item->file_path,
                    'nilai' => null,
                    'status_validasi' => $item->status_validasi,
                    'divalidasi_oleh' => $item->divalidasi_oleh,
                    'catatan_nilai' => $item->catatan_dosen,
                    'original_id' => $item->id
                ];
            });

        $uploads = $uploadsPermintaan->concat($uploadsAktivitas)->concat($uploadsKKN)->concat($uploadsBimbingan)->sortByDesc('tanggal')->values();

        return Inertia::render('Admin/Penilaian', [
            'uploads' => $uploads
        ]);
    }

    public function validasi(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan' => 'nullable|string',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'type' => 'required|in:permintaan,aktivitas,kkn,bimbingan'
        ]);

        if ($validated['type'] === 'permintaan') {
            $progress = PermintaanAkademikProgress::findOrFail($id);
            
            $progress->update([
                'status_validasi' => $validated['status'],
                'divalidasi_oleh' => auth()->user()->name,
                'tanggal_validasi' => now(),
                'deskripsi' => $validated['catatan'] ?? $progress->deskripsi,
                'nilai' => $validated['nilai'] ?? null,
                'catatan_nilai' => $validated['catatan'] ?? null,
                'is_selesai' => $validated['status'] === 'Disetujui'
            ]);
        } elseif ($validated['type'] === 'aktivitas') {
            $log = \App\Models\AktivitasMahasiswaLog::findOrFail($id);
            
            $log->update([
                'status_validasi' => $validated['status'],
                'divalidasi_oleh' => auth()->user()->name,
                'tanggal_validasi' => now(),
                'nilai' => $validated['nilai'] ?? null,
                'catatan_nilai' => $validated['catatan'] ?? null,
                'is_selesai' => $validated['status'] === 'Disetujui'
            ]);
        } elseif ($validated['type'] === 'kkn') {
            $kknAktivitas = \App\Models\KKNAktivitas::findOrFail($id);
            
            $kknAktivitas->update([
                'status_validasi' => $validated['status'],
                'divalidasi_oleh' => auth()->user()->name,
                'tanggal_validasi' => now(),
                'nilai' => $validated['nilai'] ?? null,
                'catatan_nilai' => $validated['catatan'] ?? null,
                'is_selesai' => $validated['status'] === 'Disetujui'
            ]);
        } elseif ($validated['type'] === 'bimbingan') {
            $bimbingan = \App\Models\Bimbingan::findOrFail($id);
            
            $bimbingan->update([
                'status_validasi' => $validated['status'],
                'divalidasi_oleh' => auth()->user()->name,
                'tanggal_validasi' => now(),
                'catatan_dosen' => $validated['catatan'] ?? null
            ]);
        }

        return back();
    }
}
