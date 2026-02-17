<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\KKN;
use App\Models\KKNAktivitas;

class KKNController extends Controller
{
    public function index()
    {
        $kkn = KKN::where('user_id', auth()->id())->get();
        return Inertia::render('kkn', [
            'daftarKKN' => $kkn
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'alamat' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'durasi' => 'required|string'
        ]);

        $kkn = KKN::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'alamat' => $validated['alamat'],
            'penanggung_jawab' => $validated['penanggung_jawab'],
            'durasi' => $validated['durasi'],
            'status' => 'Menunggu'
        ]);

        // Auto sync ke aktivitas mahasiswa
        \App\Models\AktivitasMahasiswa::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'jenis' => 'KKN',
            'keterangan' => 'KKN di ' . $validated['alamat'] . ' selama ' . $validated['durasi'],
            'status' => 'Menunggu'
        ]);

        return redirect()->route('kkn');
    }

    public function show($id)
    {
        $kkn = KKN::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $aktivitas = KKNAktivitas::where('kkn_id', $id)->get();
        
        return Inertia::render('kkn-detail', [
            'kknData' => $kkn,
            'aktivitasList' => $aktivitas
        ]);
    }

    public function storeAktivitas(Request $request, $id)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:harian,dokumen',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'file' => 'nullable|file|mimes:jpg,png,pdf|max:2048'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('kkn_aktivitas', 'public');
        }

        KKNAktivitas::create([
            'kkn_id' => $id,
            'tipe' => $validated['tipe'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal' => $validated['tanggal'] ?? null,
            'file_path' => $filePath
        ]);

        // Auto sync ke aktivitas mahasiswa log
        $aktivitas = \App\Models\AktivitasMahasiswa::where('user_id', auth()->id())
            ->where('jenis', 'KKN')
            ->latest()
            ->first();
            
        if ($aktivitas) {
            \App\Models\AktivitasMahasiswaLog::create([
                'aktivitas_mahasiswa_id' => $aktivitas->id,
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'tanggal' => $validated['tanggal'],
                'file_path' => $filePath
            ]);
        }

        return redirect()->route('kkn.show', $id);
    }
}
