<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\programbelajarController;
use App\Http\Controllers\sekolahController;
use Illuminate\Support\Facades\Route;

Route::view('/','index');
Route::get('/login',[AuthController::class, 'showlogin'])->name('login');

// ========= Admin ========= //
Route::get('/dashboard',[dashboardController::class, 'index'])->name('dashboard');

// ========= Sekolah ========= //
Route::get('/sekolah',[sekolahController::class, 'index'])->name('sekolah');
Route::get('/sekolah/json', [sekolahController::class, 'index'])->name('sekolah.json');

// ========= Sekolah ========= //
Route::get('/program_belajar',[programbelajarController::class, 'index'])->name('program_belajar');
Route::get('/program_belajar/json',[programbelajarController::class, 'index'])->name('program_belajar.json');


Route::view('/x','main.layout');
Route::view('/x','pages.konten');
