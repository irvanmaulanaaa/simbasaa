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
use App\Http\Controllers\Warga\DashboardController as WargaDashboard;
use App\Http\Controllers\Warga\PenarikanController as WargaPenarikan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/konten', [HomeController::class, 'allContent'])->name('public.konten.index');
Route::get('/konten/{id}', [HomeController::class, 'show'])->name('public.konten.show');
Route::post('/konten/{id}/like', [HomeController::class, 'like'])->name('public.konten.like');
Route::get('/lupa-password', function () {
    return view('auth.forgot-password-custom');
})->name('password.manual_reset');

Route::middleware('auth')->group(function () {

    Route::get('/notifications/latest', [NotificationController::class, 'getLatest'])->name('notifications.latest');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/delete', [NotificationController::class, 'deleteForUser'])->name('notifications.delete');

    Route::post('/konten/{id}/comment', [HomeController::class, 'comment'])->name('public.konten.comment');
    Route::put('/komentar/{id}', [HomeController::class, 'updateComment'])->name('public.komentar.update');
    Route::delete('/komentar/{id}', [HomeController::class, 'deleteComment'])->name('public.komentar.delete');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'show'])->name('profile.edit');
    Route::post('/profile/check-username', [ProfileController::class, 'checkUsername'])->name('profile.check-username');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('current-user-photo.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    Route::prefix('admin-data')->name('admin-data.')->group(function () {
        Route::get('dashboard', [AdminDataDashboard::class, 'index'])->name('dashboard');
        Route::get('/users/get-desa', [UserController::class, 'getDesa'])->name('users.get-desa');

        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('desa', DesaController::class);
        Route::resource('users', UserController::class);
        Route::resource('konten', KontenController::class)->except(['show']);
        Route::put('users/{id}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset_password');
    });

    Route::prefix('admin-pusat')->name('admin-pusat.')->group(function () {
        Route::get('dashboard', [AdminPusatDashboard::class, 'index'])->name('dashboard');
        Route::get('sampah/check-code', [SampahController::class, 'checkCode'])
            ->name('sampah.check-code');

        Route::resource('sampah', SampahController::class);
        Route::resource('jadwal', JadwalPenimbanganController::class);

        Route::get('/api/desas/{kecamatanId}', [JadwalPenimbanganController::class, 'getDesasByKecamatan'])
            ->name('api.desas');
        Route::get('/api/rws/{desaId}', [JadwalPenimbanganController::class, 'getRwsByDesa'])
            ->name('api.rws');

        Route::resource('kategori-sampah', KategoriSampahController::class);

    });

    Route::prefix('ketua')->name('ketua.')->middleware(['auth'])->group(function () {
        Route::get('dashboard', [KetuaDashboard::class, 'index'])->name('dashboard');

        Route::get('setoran/create', [SetoranController::class, 'create'])->name('setoran.create');
        Route::post('setoran', [SetoranController::class, 'store'])->name('setoran.store');
        Route::get('setoran/{id_setor}', [SetoranController::class, 'show'])->name('setoran.show');

        Route::get('penarikan', [PenarikanController::class, 'index'])->name('penarikan.index');
        Route::patch('penarikan/{id}', [PenarikanController::class, 'konfirmasi'])->name('penarikan.konfirmasi');
    });

    Route::prefix('warga')->name('warga.')->middleware(['auth'])->group(function () {
        Route::get('dashboard', [WargaDashboard::class, 'index'])->name('dashboard');

        Route::get('tarik-saldo', [WargaPenarikan::class, 'create'])->name('tarik.create');
        Route::post('tarik-saldo', [WargaPenarikan::class, 'store'])->name('tarik.store');
    });
});

require __DIR__ . '/auth.php';
