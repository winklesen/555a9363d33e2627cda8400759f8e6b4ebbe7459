<?php

use Illuminate\Support\Facades\Route;

Route::get('', ['App\Http\Controllers\LoginController', 'login'])->name('index');

Route::middleware(['web', 'disableBack'])->group(function() {
    Route::middleware(['disableRedirect'])->group(function() {
        Route::get('login', ['App\Http\Controllers\LoginController', 'login'])->name('login');
        Route::post('login', ['App\Http\Controllers\LoginController', 'postLogin'])->name('post.login');
    });
    
    Route::get('logout', ['App\Http\Controllers\LoginController', 'logout'])->name('logout');
});

Route::prefix('penyisihan')->name('penyisihan.')->group(function() {
    Route::middleware(['auth:web', 'disableBack'])->group(function() {
        Route::get('dashboard', ['App\Http\Controllers\DashboardController', 'dashboard'])->name('dashboard');
        Route::resource('provinsi', 'App\Http\Controllers\ProvinsiController');
        
        Route::get('provinsi/{provinsiId}/sekolah', ['App\Http\Controllers\SekolahController'::class, 'index'])->name('provinsi.sekolah.index');
        Route::get('provinsi/{provinsiId}/sekolah/create', ['App\Http\Controllers\SekolahController'::class, 'create'])->name('provinsi.sekolah.create');
        Route::post('provinsi/{provinsiId}/sekolah', ['App\Http\Controllers\SekolahController'::class, 'store'])->name('provinsi.sekolah.store');
        Route::get('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\SekolahController'::class, 'show'])->name('provinsi.sekolah.show');
        Route::get('provinsi/{provinsiId}/sekolah/{id}/edit', ['App\Http\Controllers\SekolahController'::class, 'edit'])->name('provinsi.sekolah.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\SekolahController'::class, 'update'])->name('provinsi.sekolah.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\SekolahController'::class, 'destroy'])->name('provinsi.sekolah.destroy');

        Route::prefix('sekolah')->name('sekolah.')->group(function() {
            Route::resource('peserta', 'App\Http\Controllers\PesertaController');
            Route::resource('pendamping', 'App\Http\Controllers\PendampingController');
        });
    });
});
