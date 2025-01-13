<?php

use Illuminate\Support\Facades\Route;

Route::get('', ['App\Http\Controllers\LoginController', 'login'])->name('index');
Route::get('chart/penyisihan', ['App\Http\Controllers\ChartController', 'penyisihan'])->name('chart.penyisihan');

Route::post('point', ['App\Http\Controllers\PointController', 'point'])->name('point');

Route::middleware(['web', 'disableBack'])->group(function() {
    Route::middleware(['disableRedirect'])->group(function() {
        Route::get('login', ['App\Http\Controllers\LoginController', 'login'])->name('login');
        Route::post('login', ['App\Http\Controllers\LoginController', 'postLogin'])->name('post-login');
    });
    
    Route::get('logout', ['App\Http\Controllers\LoginController', 'logout'])->name('logout');
});

Route::middleware(['auth:web', 'disableBack'])->group(function() {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('user', ['App\Http\Controllers\LoginController', 'user'])->name('user');
        Route::post('update-provinsi', ['App\Http\Controllers\LoginController', 'updateProvinsi'])->name('update-provinsi');

        Route::get('dashboard', ['App\Http\Controllers\DashboardController', 'dashboard'])->name('dashboard');
        Route::resource('provinsi', 'App\Http\Controllers\ProvinsiController');
        Route::resource('sekolah', 'App\Http\Controllers\SekolahController');
        Route::resource('peserta', 'App\Http\Controllers\PesertaController');
        Route::resource('pendamping', 'App\Http\Controllers\PendampingController');
        Route::resource('tema', 'App\Http\Controllers\TemaController');
        Route::resource('pertanyaan-sesi-1', 'App\Http\Controllers\PertanyaanSesi1Controller');
        Route::resource('pertanyaan-sesi-2', 'App\Http\Controllers\PertanyaanSesi2Controller');
        Route::resource('pertanyaan-sesi-3', 'App\Http\Controllers\PertanyaanSesi3Controller');
    });
});
