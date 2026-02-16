<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompreController;
use App\Http\Controllers\KKNController;
use App\Http\Controllers\TugasAkhirController;
use App\Http\Controllers\AktivitasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        $stats = [
            'totalMahasiswa' => \App\Models\User::where('role', 'mahasiswa')->count(),
            'permintaanPending' => \App\Models\PermintaanAkademik::where('status_proposal', 'Menunggu')->count(),
            'permintaanDisetujui' => \App\Models\PermintaanAkademik::where('status_proposal', 'Disetujui')->count(),
            'totalKKN' => \App\Models\KKN::count(),
        ];
        
        $recentPermintaan = \App\Models\PermintaanAkademik::latest()->take(10)->get();
        
        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentPermintaan' => $recentPermintaan,
            'recentActivities' => []
        ]);
    }
    
    // Mahasiswa
    $stats = [
        'aktivitas' => \App\Models\AktivitasMahasiswa::where('user_id', $user->id)->count(),
        'permintaan' => \App\Models\PermintaanAkademik::where('user_id', $user->id)->count(),
        'kkn' => \App\Models\KKN::where('user_id', $user->id)->count(),
    ];
    
    // Ambil aktivitas terbaru hanya dari PermintaanAkademik
    $recentActivities = \App\Models\PermintaanAkademik::where('user_id', $user->id)
        ->latest()
        ->take(5)
        ->get()
        ->map(function($item) {
            return [
                'id' => 'p_' . $item->id,
                'jenis' => $item->type,
                'keterangan' => 'Mengajukan ' . $item->type . ': ' . $item->judul,
                'status' => $item->status_proposal,
                'created_at' => $item->created_at
            ];
        });
    
    return Inertia::render('Dashboard', [
        'stats' => $stats,
        'recentActivities' => $recentActivities,
        'recentPermintaan' => []
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aktivitas', [AktivitasController::class, 'index'])->middleware(['auth', 'verified'])->name('aktivitas');
Route::post('/aktivitas', [AktivitasController::class, 'store'])->middleware(['auth', 'verified'])->name('aktivitas.store');
Route::get('/aktivitas/{id}', [AktivitasController::class, 'show'])->middleware(['auth', 'verified'])->name('aktivitasd');
Route::post('/aktivitas/{id}/log', [AktivitasController::class, 'storeLog'])->middleware(['auth', 'verified'])->name('aktivitas.log.store');

Route::get('/nilai', [\App\Http\Controllers\NilaiController::class, 'index'])->middleware(['auth', 'verified'])->name('nilai');

Route::get('/compre',[ CompreController::class,"index"])->middleware(['auth', 'verified'])->name('compre');


Route::get('/kkn',[ KKNController::class,"index"])->middleware(['auth', 'verified'])->name('kkn');
Route::post('/kkn', [KKNController::class, 'store'])->middleware(['auth', 'verified'])->name('kkn.store');
Route::get('/kkn/{id}', [KKNController::class, 'show'])->middleware(['auth', 'verified'])->name('kkn.show');
Route::post('/kkn/{id}/aktivitas', [KKNController::class, 'storeAktivitas'])->middleware(['auth', 'verified'])->name('kkn.aktivitas.store');


Route::get('/tugasakhir', [TugasAkhirController::class, 'index'])->middleware(['auth', 'verified'])->name('tugasakhir.index');
Route::post('/tugasakhir', [TugasAkhirController::class, 'store'])->middleware(['auth', 'verified'])->name('tugasakhir.store');
Route::get('/tugasakhir/{id}', [TugasAkhirController::class, 'show'])->middleware(['auth', 'verified'])->name('tugasakhir.show');
Route::post('/tugasakhir/{id}/progress', [TugasAkhirController::class, 'storeProgress'])->middleware(['auth', 'verified'])->name('tugasakhir.progress.store');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/mahasiswa', [\App\Http\Controllers\Admin\MahasiswaController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswa/{id}', [\App\Http\Controllers\Admin\MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/validasi', [\App\Http\Controllers\Admin\ValidasiController::class, 'index'])->name('validasi');
    Route::post('/validasi/{id}/approve', [\App\Http\Controllers\Admin\ValidasiController::class, 'approve'])->name('validasi.approve');
    Route::post('/validasi/{id}/reject', [\App\Http\Controllers\Admin\ValidasiController::class, 'reject'])->name('validasi.reject');
    Route::get('/penilaian', [\App\Http\Controllers\Admin\PenilaianController::class, 'index'])->name('penilaian');
    Route::post('/penilaian/{id}/validasi', [\App\Http\Controllers\Admin\PenilaianController::class, 'validasi'])->name('penilaian.validasi');
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
