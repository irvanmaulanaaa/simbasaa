<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminData\KecamatanController;
use App\Http\Controllers\AdminData\DesaController;
use App\Http\Controllers\AdminData\UserController;
use App\Http\Controllers\AdminData\KontenController;
use App\Http\Controllers\AdminData\DashboardController;

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
    Route::prefix('admin-data')->name('admin-data.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users/get-desa', [UserController::class, 'getDesa'])->name('users.get-desa');
        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('desa', DesaController::class);
        Route::resource('users', UserController::class);
        Route::resource('konten', KontenController::class);
    }); 
});

require __DIR__.'/auth.php';
