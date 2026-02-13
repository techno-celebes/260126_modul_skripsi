<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaLog;

class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = AktivitasMahasiswa::where('user_id', auth()->id())->get();
        return Inertia::render('Aktivitas', [
            'daftarAktivitas' => $aktivitas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'jenis' => 'required|string',
            'keterangan' => 'required|string'
        ]);

        $aktivitas = AktivitasMahasiswa::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'jenis' => $validated['jenis'],
            'keterangan' => $validated['keterangan'],
            'status' => 'Pending'
        ]);

        // Auto create log
        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas->id,
            'judul' => 'Aktivitas dibuat'
        ]);

        return redirect()->route('aktivitas');
    }

    public function show($id)
    {
        $aktivitas = AktivitasMahasiswa::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $logs = AktivitasMahasiswaLog::where('aktivitas_mahasiswa_id', $id)->orderBy('created_at', 'desc')->get();
        
        return Inertia::render('aktivitasd', [
            'aktivitas' => $aktivitas,
            'logs' => $logs
        ]);
    }
}
