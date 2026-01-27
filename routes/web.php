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
use App\Http\Controllers\Ketua\PenarikanController as KetuaPenarikan;
use App\Http\Controllers\Warga\DashboardController as WargaDashboard;
use App\Http\Controllers\Warga\PenarikanController as WargaPenarikan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Ketua\NotifikasiController;
use App\Http\Controllers\Warga\WargaSetoranController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/konten', function () {
    return redirect('/?view=konten');
})->name('public.konten.index');

Route::get('/konten/{id}', [HomeController::class, 'show'])->name('public.konten.show');

Route::post('/konten/{id}/like', [HomeController::class, 'like'])
    ->middleware(['throttle:60,1'])
    ->name('public.konten.like');

Route::get('/lupa-password', function () {
    return view('auth.forgot-password-custom');
})->name('password.manual_reset');


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
    Route::get('/notifications/latest', [NotificationController::class, 'getLatest'])->name('notifications.latest');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/delete', [NotificationController::class, 'deleteForUser'])->name('notifications.delete');

    Route::post('/konten/{id}/comment', [HomeController::class, 'comment'])
        ->middleware('throttle:10,1')
        ->name('public.konten.comment');

    Route::put('/komentar/{id}', [HomeController::class, 'updateComment'])->name('public.komentar.update');
    Route::delete('/komentar/{id}', [HomeController::class, 'deleteComment'])->name('public.komentar.delete');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'show'])->name('profile.edit');
    Route::post('/profile/check-username', [ProfileController::class, 'checkUsername'])->name('profile.check-username');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('current-user-photo.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');


    Route::prefix('admin-data')->name('admin-data.')
        ->middleware('role:admin_data')
        ->group(function () {
            Route::get('dashboard', [AdminDataDashboard::class, 'index'])->name('dashboard');
            Route::get('/users/get-desa', [UserController::class, 'getDesa'])->name('users.get-desa');

            Route::resource('kecamatan', KecamatanController::class);
            Route::resource('desa', DesaController::class);
            Route::resource('users', UserController::class);
            Route::resource('konten', KontenController::class)->except(['show']);
            Route::put('users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
        });


    Route::prefix('admin-pusat')->name('admin-pusat.')
        ->middleware('role:admin_pusat')
        ->group(function () {
            Route::get('dashboard', [AdminPusatDashboard::class, 'index'])->name('dashboard');
            Route::get('sampah/check-code', [SampahController::class, 'checkCode'])->name('sampah.check-code');

            Route::resource('sampah', SampahController::class);
            Route::resource('jadwal', JadwalPenimbanganController::class);

            Route::get('/api/desas/{kecamatanId}', [JadwalPenimbanganController::class, 'getDesasByKecamatan'])->name('api.desas');
            Route::get('/api/rws/{desaId}', [JadwalPenimbanganController::class, 'getRwsByDesa'])->name('api.rws');

            Route::resource('kategori-sampah', KategoriSampahController::class);
        });


    Route::prefix('ketua')->name('ketua.')
        ->middleware('role:ketua')
        ->group(function () {
            Route::get('dashboard', [KetuaDashboard::class, 'index'])->name('dashboard');

            Route::get('setoran', [SetoranController::class, 'index'])->name('setoran.index');
            Route::post('setoran', [SetoranController::class, 'store'])->name('setoran.store');
            Route::get('setoran/{id}', [SetoranController::class, 'show'])->name('setoran.show');
            Route::put('setoran/{id}', [SetoranController::class, 'update'])->name('setoran.update');
            Route::delete('setoran/{id}', [SetoranController::class, 'destroy'])->name('setoran.destroy');

            Route::get('penarikan', [KetuaPenarikan::class, 'index'])->name('penarikan.index');
            Route::patch('penarikan/{id}', [KetuaPenarikan::class, 'konfirmasi'])->name('penarikan.konfirmasi');

            Route::get('/api/count-pending', [NotifikasiController::class, 'countPending'])->name('api.count-pending');
        });

    Route::prefix('warga')->name('warga.')
        ->middleware('role:warga')
        ->group(function () {
            Route::get('dashboard', [WargaDashboard::class, 'index'])->name('dashboard');

            Route::post('tarik-saldo', [WargaPenarikan::class, 'store'])->name('tarik.store');

            Route::get('riwayat-penarikan', [WargaPenarikan::class, 'index'])->name('penarikan.index');
            Route::get('riwayat-setoran', [WargaSetoranController::class, 'index'])->name('setoran.index');

            Route::post('penarikan/{id}/mark-read', [WargaPenarikan::class, 'markAsRead'])->name('penarikan.markRead');
        });
});

require __DIR__ . '/auth.php';
