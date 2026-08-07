<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PopulasiTernakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Dynamic Dropdown Route
Route::get('/get-desa/{kecamatan_id}', [PopulasiTernakController::class, 'getDesa'])->name('get.desa');

// Route Export Excel (Gunakan PopulasiTernakController)
Route::get('/populasi/export', [PopulasiTernakController::class, 'export'])->name('populasi.export');

// Route Resource
Route::resource('populasi', PopulasiTernakController::class);
Route::resource('layanan', LayananController::class);
Route::resource('desa', DesaController::class);
Route::resource('kecamatan', KecamatanController::class);