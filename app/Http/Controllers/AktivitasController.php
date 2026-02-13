<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AktivitasMahasiswa;

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

        AktivitasMahasiswa::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'jenis' => $validated['jenis'],
            'keterangan' => $validated['keterangan'],
            'status' => 'Pending'
        ]);

        return redirect()->route('aktivitas');
    }

    public function show($id)
    {
        $aktivitas = AktivitasMahasiswa::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return Inertia::render('aktivitasd', [
            'aktivitas' => $aktivitas
        ]);
    }
}
