<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminData\KecamatanController;
use App\Http\Controllers\AdminData\DesaController;
use App\Http\Controllers\AdminData\UserController;
use App\Http\Controllers\AdminData\KontenController;
use App\Http\Controllers\AdminData\DashboardController as AdminDataDashboard;
use App\Http\Controllers\AdminPusat\SampahController;
use App\Http\Controllers\AdminPusat\JadwalPenimbanganController;
use App\Http\Controllers\AdminPusat\DashboardController as AdminPusatDashboard;
use App\Http\Controllers\AdminPusat\KategoriSampahController;
use App\Http\Controllers\Ketua\DashboardController as KetuaDashboard;
use App\Http\Controllers\Ketua\SetoranController;
use App\Http\Controllers\Ketua\PenarikanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user->role) {
        Auth::logout();
        return redirect('/login')->withErrors('Akun Anda tidak memiliki peran. Hubungi administrator.');
    }

    $role = $user->role->nama_role;

    if ($role == 'admin_data') {
        return redirect()->route('admin-data.dashboard');
    } elseif ($role == 'admin_pusat') {
        return redirect()->route('admin-pusat.dashboard');
    } elseif ($role == 'ketua') {
        return redirect()->route('ketua.dashboard');
    } elseif ($role == 'warga') {
        return redirect()->route('warga.dashboard');
    }

    Auth::logout();
    return redirect('/login')->withErrors('Role tidak dikenal.');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin-data')->name('admin-data.')->group(function () {
        Route::get('dashboard', [AdminDataDashboard::class, 'index'])->name('dashboard');
        Route::get('/users/get-desa', [UserController::class, 'getDesa'])->name('users.get-desa');
        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('desa', DesaController::class);
        Route::resource('users', UserController::class);
        Route::resource('konten', KontenController::class);
    });

    Route::prefix('admin-pusat')->name('admin-pusat.')->group(function () {
        Route::get('dashboard', [AdminPusatDashboard::class, 'index'])->name('dashboard');
        Route::resource('sampah', SampahController::class);
        Route::resource('jadwal', JadwalPenimbanganController::class);
        Route::resource('kategori-sampah', KategoriSampahController::class);
    });

    Route::prefix('ketua')->name('ketua.')->middleware(['auth'])->group(function () {
        Route::get('dashboard', [KetuaDashboard::class, 'index'])->name('dashboard');
        Route::get('setoran/create', function () {
            return 'Form Setoran'; })->name('setoran.create');
        Route::get('penarikan', function () {
            return 'Validasi Penarikan'; })->name('penarikan.index');
    });
});

require __DIR__ . '/auth.php';
