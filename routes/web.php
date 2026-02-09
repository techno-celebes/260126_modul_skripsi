<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompreController;
use App\Http\Controllers\KKNController;
use App\Http\Controllers\TugasAkhirController;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aktivitas', function () {
    return Inertia::render('Aktivitas');
})->middleware(['auth', 'verified'])->name('aktivitas');

Route::get('/compre',[ CompreController::class,"index"])->middleware(['auth', 'verified'])->name('compre');

Route::get('/kkn',[ KKNController::class,"indexx"])->middleware(['auth', 'verified'])->name('kkn');
Route::post('/kkn', [KKNController::class, 'store'])->middleware(['auth', 'verified']);
Route::get('/kkn/{id}', [KKNController::class, 'show'])->middleware(['auth', 'verified'])->name('kkn.show');
Route::post('/kkn/{id}/aktivitas', [KKNController::class, 'storeAktivitas'])->middleware(['auth', 'verified'])->name('kkn.aktivitas.store');


Route::post('/tugasakhir', [TugasAkhirController::class, 'store']);


Route::get('/tugasakhir', function () {
    return Inertia::render('tugasakhir');
})->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
