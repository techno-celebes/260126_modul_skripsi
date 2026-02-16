<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PermintaanAkademik;
use App\Models\PermintaanAkademikProgress;

class ValidasiController extends Controller
{
    public function index()
    {
        $permintaan = PermintaanAkademik::with('user')
            ->latest()
            ->get();

        return Inertia::render('Admin/Validasi', [
            'permintaan' => $permintaan
        ]);
    }

    public function approve($id)
    {
        $permintaan = PermintaanAkademik::findOrFail($id);
        
        $permintaan->update([
            'status' => 'Disetujui',
            'status_proposal' => 'Disetujui',
            'tanggal_persetujuan' => now(),
            'disetujui_oleh' => auth()->user()->name
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan->id,
            'jenis_progress' => 'progress',
            'judul' => 'Disetujui oleh Admin',
            'deskripsi' => 'Permintaan telah disetujui oleh ' . auth()->user()->name,
            'tanggal' => now(),
            'divalidasi_oleh' => auth()->user()->name,
            'tanggal_validasi' => now(),
            'is_selesai' => true
        ]);

        return back();
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'alasan' => 'required|string'
        ]);

        $permintaan = PermintaanAkademik::findOrFail($id);
        
        $permintaan->update([
            'status' => 'Ditolak',
            'status_proposal' => 'Ditolak',
            'keterangan' => $validated['alasan']
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan->id,
            'jenis_progress' => 'progress',
            'judul' => 'Ditolak oleh Admin',
            'deskripsi' => 'Alasan: ' . $validated['alasan'],
            'tanggal' => now(),
            'divalidasi_oleh' => auth()->user()->name,
            'tanggal_validasi' => now(),
            'is_selesai' => true
        ]);

        return back();
    }
}
