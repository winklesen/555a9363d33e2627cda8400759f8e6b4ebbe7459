<?php

use Illuminate\Support\Facades\Route;

Route::get('', ['App\Http\Controllers\LoginController', 'login'])->name('index');

Route::post('point', ['App\Http\Controllers\PointController', 'point'])->name('point');

Route::middleware(['web', 'disableBack'])->group(function() {
    Route::middleware(['disableRedirect'])->group(function() {
        Route::get('login', ['App\Http\Controllers\LoginController', 'login'])->name('login');
        Route::post('login', ['App\Http\Controllers\LoginController', 'postLogin'])->name('post.login');
    });
    
    Route::get('logout', ['App\Http\Controllers\LoginController', 'logout'])->name('logout');
});

Route::prefix('penyisihan')->name('penyisihan.')->group(function() {
    Route::middleware(['auth:web', 'disableBack'])->group(function() {
        Route::get('dashboard', ['App\Http\Controllers\Penyisihan\DashboardController', 'dashboard'])->name('dashboard');
        Route::resource('provinsi', 'App\Http\Controllers\Penyisihan\ProvinsiController');
        
        Route::get('provinsi/{provinsiId}/sekolah', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'index'])->name('provinsi.sekolah.index');
        Route::get('provinsi/{provinsiId}/sekolah/create', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'create'])->name('provinsi.sekolah.create');
        Route::post('provinsi/{provinsiId}/sekolah', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'store'])->name('provinsi.sekolah.store');
        Route::get('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'show'])->name('provinsi.sekolah.show');
        Route::get('provinsi/{provinsiId}/sekolah/{id}/edit', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'edit'])->name('provinsi.sekolah.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'update'])->name('provinsi.sekolah.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'destroy'])->name('provinsi.sekolah.destroy');

        Route::get('provinsi/{provinsiId}/sekolah/{id}/set-group', ['App\Http\Controllers\Penyisihan\SekolahController'::class, 'setGroup'])->name('provinsi.sekolah.set-group');

        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'index'])->name('provinsi.sekolah.peserta.index');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/create', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'create'])->name('provinsi.sekolah.peserta.create');
        Route::post('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'store'])->name('provinsi.sekolah.peserta.store');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'show'])->name('provinsi.sekolah.peserta.show');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}/edit', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'edit'])->name('provinsi.sekolah.peserta.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'update'])->name('provinsi.sekolah.peserta.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}', ['App\Http\Controllers\Penyisihan\PesertaController'::class, 'destroy'])->name('provinsi.sekolah.peserta.destroy');

        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'index'])->name('provinsi.sekolah.pendamping.index');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/create', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'create'])->name('provinsi.sekolah.pendamping.create');
        Route::post('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'store'])->name('provinsi.sekolah.pendamping.store');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'show'])->name('provinsi.sekolah.pendamping.show');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}/edit', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'edit'])->name('provinsi.sekolah.pendamping.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'update'])->name('provinsi.sekolah.pendamping.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}', ['App\Http\Controllers\Penyisihan\PendampingController'::class, 'destroy'])->name('provinsi.sekolah.pendamping.destroy');
    });
});
