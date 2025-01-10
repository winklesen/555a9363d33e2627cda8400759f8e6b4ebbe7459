<?php

use Illuminate\Support\Facades\Route;

Route::get('', ['App\Http\Controllers\LoginController', 'login'])->name('index');
Route::get('chart/penyisihan', ['App\Http\Controllers\ChartController', 'penyisihan'])->name('chart.penyisihan');
 
Route::post('point', ['App\Http\Controllers\PointController', 'point'])->name('point');

Route::middleware(['web', 'disableBack'])->group(function() {
    Route::middleware(['disableRedirect'])->group(function() {
        Route::get('login', ['App\Http\Controllers\LoginController', 'login'])->name('login');
        Route::post('login', ['App\Http\Controllers\LoginController', 'postLogin'])->name('post.login');
    });
    
    Route::get('logout', ['App\Http\Controllers\LoginController', 'logout'])->name('logout');
});

Route::middleware(['auth:web', 'disableBack'])->group(function() {
    Route::prefix('ajax')->name('ajax.')->group(function() {
        Route::get('provinsi', ['App\Http\Controllers\LoginController', 'provinsi'])->name('provinsi');
        Route::post('update-provinsi', ['App\Http\Controllers\LoginController', 'updateProvinsi'])->name('update-provinsi');
    });
    
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('dashboard', ['App\Http\Controllers\DashboardController', 'dashboard'])->name('dashboard');
        Route::resource('provinsi', 'App\Http\Controllers\ProvinsiController');
        
        Route::get('provinsi/{provinsiId}/sekolah', ['App\Http\Controllers\SekolahController'::class, 'index'])->name('provinsi.sekolah.index');
        Route::get('provinsi/{provinsiId}/sekolah/create', ['App\Http\Controllers\SekolahController'::class, 'create'])->name('provinsi.sekolah.create');
        Route::post('provinsi/{provinsiId}/sekolah', ['App\Http\Controllers\SekolahController'::class, 'store'])->name('provinsi.sekolah.store');
        Route::get('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\SekolahController'::class, 'show'])->name('provinsi.sekolah.show');
        Route::get('provinsi/{provinsiId}/sekolah/{id}/edit', ['App\Http\Controllers\SekolahController'::class, 'edit'])->name('provinsi.sekolah.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\SekolahController'::class, 'update'])->name('provinsi.sekolah.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{id}', ['App\Http\Controllers\SekolahController'::class, 'destroy'])->name('provinsi.sekolah.destroy');
    
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta', ['App\Http\Controllers\PesertaController'::class, 'index'])->name('provinsi.sekolah.peserta.index');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/create', ['App\Http\Controllers\PesertaController'::class, 'create'])->name('provinsi.sekolah.peserta.create');
        Route::post('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta', ['App\Http\Controllers\PesertaController'::class, 'store'])->name('provinsi.sekolah.peserta.store');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}', ['App\Http\Controllers\PesertaController'::class, 'show'])->name('provinsi.sekolah.peserta.show');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}/edit', ['App\Http\Controllers\PesertaController'::class, 'edit'])->name('provinsi.sekolah.peserta.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}', ['App\Http\Controllers\PesertaController'::class, 'update'])->name('provinsi.sekolah.peserta.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{sekolahId}/peserta/{id}', ['App\Http\Controllers\PesertaController'::class, 'destroy'])->name('provinsi.sekolah.peserta.destroy');
    
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping', ['App\Http\Controllers\PendampingController'::class, 'index'])->name('provinsi.sekolah.pendamping.index');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/create', ['App\Http\Controllers\PendampingController'::class, 'create'])->name('provinsi.sekolah.pendamping.create');
        Route::post('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping', ['App\Http\Controllers\PendampingController'::class, 'store'])->name('provinsi.sekolah.pendamping.store');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}', ['App\Http\Controllers\PendampingController'::class, 'show'])->name('provinsi.sekolah.pendamping.show');
        Route::get('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}/edit', ['App\Http\Controllers\PendampingController'::class, 'edit'])->name('provinsi.sekolah.pendamping.edit');
        Route::put('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}', ['App\Http\Controllers\PendampingController'::class, 'update'])->name('provinsi.sekolah.pendamping.update');
        Route::delete('provinsi/{provinsiId}/sekolah/{sekolahId}/pendamping/{id}', ['App\Http\Controllers\PendampingController'::class, 'destroy'])->name('provinsi.sekolah.pendamping.destroy');
    
        Route::get('provinsi/{provinsiId}/sesi-1/tema', ['App\Http\Controllers\TemaController'::class, 'index'])->name('provinsi.sesi-1.tema.index');
        Route::get('provinsi/{provinsiId}/sesi-1/tema/create', ['App\Http\Controllers\TemaController'::class, 'create'])->name('provinsi.sesi-1.tema.create');
        Route::post('provinsi/{provinsiId}/sesi-1/tema', ['App\Http\Controllers\TemaController'::class, 'store'])->name('provinsi.sesi-1.tema.store');
        Route::get('provinsi/{provinsiId}/sesi-1/tema/{id}', ['App\Http\Controllers\TemaController'::class, 'show'])->name('provinsi.sesi-1.tema.show');
        Route::get('provinsi/{provinsiId}/sesi-1/tema/{id}/edit', ['App\Http\Controllers\TemaController'::class, 'edit'])->name('provinsi.sesi-1.tema.edit');
        Route::put('provinsi/{provinsiId}/sesi-1/tema/{id}', ['App\Http\Controllers\TemaController'::class, 'update'])->name('provinsi.sesi-1.tema.update');
        Route::delete('provinsi/{provinsiId}/sesi-1/tema/{id}', ['App\Http\Controllers\TemaController'::class, 'destroy'])->name('provinsi.sesi-1.tema.destroy');
    
        Route::get('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'index'])->name('provinsi.sesi-1.tema.pertanyaan.index');
        Route::get('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan/create', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'create'])->name('provinsi.sesi-1.tema.pertanyaan.create');
        Route::post('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'store'])->name('provinsi.sesi-1.tema.pertanyaan.store');
        Route::get('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'show'])->name('provinsi.sesi-1.tema.pertanyaan.show');
        Route::get('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan/{id}/edit', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'edit'])->name('provinsi.sesi-1.tema.pertanyaan.edit');
        Route::put('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'update'])->name('provinsi.sesi-1.tema.pertanyaan.update');
        Route::delete('provinsi/{provinsiId}/sesi-1/tema/{temaId}/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi1Controller'::class, 'destroy'])->name('provinsi.sesi-1.tema.pertanyaan.destroy');

        Route::get('provinsi/{provinsiId}/sesi-2/pertanyaan', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'index'])->name('provinsi.sesi-2.pertanyaan.index');
        Route::get('provinsi/{provinsiId}/sesi-2/pertanyaan/create', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'create'])->name('provinsi.sesi-2.pertanyaan.create');
        Route::post('provinsi/{provinsiId}/sesi-2/pertanyaan', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'store'])->name('provinsi.sesi-2.pertanyaan.store');
        Route::get('provinsi/{provinsiId}/sesi-2/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'show'])->name('provinsi.sesi-2.pertanyaan.show');
        Route::get('provinsi/{provinsiId}/sesi-2/pertanyaan/{id}/edit', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'edit'])->name('provinsi.sesi-2.pertanyaan.edit');
        Route::put('provinsi/{provinsiId}/sesi-2/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'update'])->name('provinsi.sesi-2.pertanyaan.update');
        Route::delete('provinsi/{provinsiId}/sesi-2/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi2Controller'::class, 'destroy'])->name('provinsi.sesi-2.pertanyaan.destroy');

        Route::get('provinsi/{provinsiId}/sesi-3/pertanyaan', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'index'])->name('provinsi.sesi-3.pertanyaan.index');
        Route::get('provinsi/{provinsiId}/sesi-3/pertanyaan/create', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'create'])->name('provinsi.sesi-3.pertanyaan.create');
        Route::post('provinsi/{provinsiId}/sesi-3/pertanyaan', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'store'])->name('provinsi.sesi-3.pertanyaan.store');
        Route::get('provinsi/{provinsiId}/sesi-3/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'show'])->name('provinsi.sesi-3.pertanyaan.show');
        Route::get('provinsi/{provinsiId}/sesi-3/pertanyaan/{id}/edit', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'edit'])->name('provinsi.sesi-3.pertanyaan.edit');
        Route::put('provinsi/{provinsiId}/sesi-3/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'update'])->name('provinsi.sesi-3.pertanyaan.update');
        Route::delete('provinsi/{provinsiId}/sesi-3/pertanyaan/{id}', ['App\Http\Controllers\PertanyaanSesi3Controller'::class, 'destroy'])->name('provinsi.sesi-3.pertanyaan.destroy');
    });
});
