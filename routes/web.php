<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\JenisSampahController;
use App\Http\Controllers\Admin\SetoranController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Admin\PenarikanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::resource('warga', WargaController::class);
    Route::resource('jenis_sampah', JenisSampahController::class);
    Route::resource('setoran', SetoranController::class);

    // Rute untuk mengelola permintaan penarikan
    Route::get('permintaan-penarikan', [PenarikanController::class, 'index'])->name('penarikan.index');
    Route::patch('permintaan-penarikan/{transaksi}/approve', [PenarikanController::class, 'approve'])->name('penarikan.approve');
    Route::patch('permintaan-penarikan/{transaksi}/reject', [PenarikanController::class, 'reject'])->name('penarikan.reject');
});

// Route untuk warga
Route::prefix('warga')->middleware(['auth', 'verified', 'warga'])->name('warga.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tarik_saldo', [DashboardController::class, 'createTarik'])->name('tarik.create');
    Route::post('/tarik_saldo', [DashboardController::class, 'storeTarik'])->name('tarik.store');
});

require __DIR__.'/auth.php';
