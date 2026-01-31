<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompreController;
use App\Http\Controllers\KKNController;
use App\Http\Controllers\PTAController;
use App\Http\Controllers\DTAController;
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

Route::get('/compre',[ CompreController::class,"index"])->middleware(['auth', 'verified'])->name('compre');

Route::get('/kkn',[ KKNController::class,"indexx"])->middleware(['auth', 'verified'])->name('kkn');

Route::get('/pengaturan-ta',[ PTAController::class,"indexxx"])->middleware(['auth', 'verified'])->name('pengaturan-ta');

Route::get('/daftar-ta',[ DTAController::class,"indexxxx"])->middleware(['auth', 'verified'])->name('daftar-ta');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
