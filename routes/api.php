<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('send/change_question', ['App\Http\Controllers\MobileController', 'change_question'])->name('change_question');
Route::get('send/update_point', ['App\Http\Controllers\MobileController', 'update_point'])->name('change_question');

Route::get('jawabans', ['App\Http\Controllers\MobileController', 'get_jawabans'])->name('get_jawabans');
Route::get('messages', ['App\Http\Controllers\MobileController', 'get_messages'])->name('get_messages');
Route::get('pendampings', ['App\Http\Controllers\MobileController', 'get_pendampings'])->name('get_pendampings');
Route::get('pertanyaans', ['App\Http\Controllers\MobileController', 'get_pertanyaans'])->name('get_pertanyaans');
Route::get('pesertas', ['App\Http\Controllers\MobileController', 'get_pesertas'])->name('get_pesertas');
Route::get('points', ['App\Http\Controllers\MobileController', 'get_points'])->name('get_points');
Route::get('provinsis', ['App\Http\Controllers\MobileController', 'get_provinsis'])->name('get_provinsis');
Route::get('sekolahs', ['App\Http\Controllers\MobileController', 'get_sekolahs'])->name('get_sekolahs');
Route::get('temas', ['App\Http\Controllers\MobileController', 'get_temas'])->name('get_temas');
Route::get('users', ['App\Http\Controllers\MobileController', 'get_users'])->name('get_users');