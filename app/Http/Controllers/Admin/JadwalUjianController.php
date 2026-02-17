<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\JadwalUjian;
use App\Models\PermintaanAkademik;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $jadwal = JadwalUjian::with('permintaan.user')
            ->latest()
            ->get();

        $permintaan = PermintaanAkademik::where('status_proposal', 'Disetujui')
            ->orWhere('status_proposal', 'Divalidasi')
            ->with('user')
            ->get();

        return Inertia::render('Admin/JadwalUjian', [
            'jadwal' => $jadwal,
            'permintaan' => $permintaan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'permintaan_akademik_id' => 'required|exists:permintaan_akademiks,id',
            'jenis_ujian' => 'required|string',
            'tanggal_ujian' => 'required|date',
            'ruangan' => 'nullable|string',
            'penguji_1' => 'nullable|string',
            'penguji_2' => 'nullable|string',
            'penguji_3' => 'nullable|string',
            'catatan' => 'nullable|string'
        ]);

        JadwalUjian::create($validated);

        return back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis_ujian' => 'required|string',
            'tanggal_ujian' => 'required|date',
            'ruangan' => 'nullable|string',
            'penguji_1' => 'nullable|string',
            'penguji_2' => 'nullable|string',
            'penguji_3' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $jadwal = JadwalUjian::findOrFail($id);
        $jadwal->update($validated);

        return back();
    }

    public function destroy($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        $jadwal->delete();

        return back();
    }
}
