<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BimbinganController extends Controller
{
    public function index()
    {
        $bimbingan = Bimbingan::with(['permintaan.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Bimbingan', [
            'bimbingan' => $bimbingan
        ]);
    }

    public function validasi(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan_dosen' => 'required|string',
            'nilai' => 'nullable|numeric|min:0|max:100'
        ]);

        $bimbingan = Bimbingan::findOrFail($id);
        
        $bimbingan->update([
            'status_validasi' => $validated['status'],
            'catatan_dosen' => $validated['catatan_dosen'],
            'nilai' => $validated['nilai'] ?? null,
            'divalidasi_oleh' => auth()->user()->name,
            'tanggal_validasi' => now()
        ]);

        return back()->with('success', 'Bimbingan berhasil divalidasi');
    }
}
