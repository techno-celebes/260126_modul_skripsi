<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PermintaanAkademik;
use App\Models\PermintaanAkademikProgress;

class TugasAkhirController extends Controller
{
    public function index()
    {
        $permintaan = PermintaanAkademik::where('user_id', auth()->id())
            ->with('progress')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return Inertia::render('tugasakhir', [
            'dataPermintaan' => $permintaan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'type' => 'required|string',
            'periode' => 'nullable|string',
            'prodi' => 'nullable|string',
            'judul' => 'required|string'
        ]);

        $permintaan = PermintaanAkademik::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'type' => $validated['type'],
            'periode' => $validated['periode'] ?? null,
            'prodi' => $validated['prodi'] ?? null,
            'judul' => $validated['judul'],
            'tanggal_pengajuan' => now(),
            'status' => 'Menunggu',
            'status_proposal' => 'Menunggu',
            'is_selesai' => false
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan->id,
            'jenis_progress' => 'proposal',
            'judul' => 'Pengajuan Proposal',
            'deskripsi' => 'Mahasiswa mengajukan proposal ' . $validated['type'],
            'tanggal' => now(),
            'is_selesai' => false
        ]);

        // Auto create aktivitas
        \App\Models\AktivitasMahasiswa::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'jenis' => $validated['type'],
            'keterangan' => 'Mengajukan ' . $validated['type'] . ': ' . $validated['judul'],
            'status' => 'Pending'
        ]);

        return redirect()->route('tugasakhir.index');
    }

    public function show($id)
    {
        $permintaan = PermintaanAkademik::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('progress')
            ->firstOrFail();
            
        return Inertia::render('dta', [
            'permintaan' => $permintaan,
            'progress' => $permintaan->progress
        ]);
    }

    public function storeProgress(Request $request, $id)
    {
        $permintaan = PermintaanAkademik::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'jenis_progress' => 'required|string',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:10240'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('permintaan_akademik', 'public');
        }

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan->id,
            'jenis_progress' => $validated['jenis_progress'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal' => now(),
            'file_path' => $filePath,
            'status_validasi' => 'Menunggu',
            'is_selesai' => false
        ]);

        // Auto create aktivitas log
        \App\Models\AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => \App\Models\AktivitasMahasiswa::where('user_id', auth()->id())
                ->where('jenis', $permintaan->type)
                ->latest()
                ->first()->id ?? 0,
            'judul' => $validated['judul'] . ' - ' . $permintaan->type
        ]);

        return back();
    }
}
