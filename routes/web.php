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

Route::get('/dashboard', [DashboardController::class, 'index']);

// Dynamic Dropdown Route (diarahkan ke PopulasiTernakController)
Route::get('/get-desa/{kecamatan_id}', [PopulasiTernakController::class, 'getDesa'])->name('get.desa');
Route::get('/populasi/export-excel', [PopulasiTernakController::class, 'exportExcel'])->name('populasi.export');
Route::resource('populasi', PopulasiTernakController::class);
Route::resource('layanan', LayananController::class);
Route::resource('desa', DesaController::class);
Route::resource('kecamatan', KecamatanController::class);
