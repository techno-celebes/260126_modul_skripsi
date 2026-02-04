<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\KKN;

class KKNController extends Controller
{
    public function indexx()
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

        KKN::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'alamat' => $validated['alamat'],
            'penanggung_jawab' => $validated['penanggung_jawab'],
            'durasi' => $validated['durasi'],
            'status' => 'Pending'
        ]);

        return redirect()->route('kkn');
    }
}
