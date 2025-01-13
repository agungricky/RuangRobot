<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\gajiController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\penggunaController;
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

// ========= Kelas ========= //
Route::get('/kelas',[kelasController::class,'index'])->name('kelas');
Route::get('/kelas/json',[kelasController::class,'index'])->name('kelas.json');


// ========= Pengguna ========= //
Route::get('/pengguna/{id}',[penggunaController::class, 'pengguna'])->name('admin');
Route::get('/data_admin/{id}/json',[penggunaController::class, 'pengguna'])->name('admin.json');

Route::get('/data_pengajar',[penggunaController::class,'datapengajar'])->name('pengajar');
Route::get('/data_pengajar/json',[penggunaController::class,'datapengajar'])->name('pengajar.json');

Route::get('/data_siswa',[penggunaController::class,'datasiswa'])->name('siswa');
Route::get('/data_siswa/json',[penggunaController::class,'datasiswa'])->name('siswa.json');


// ========= Gaji ========= //
Route::get('/gaji',[gajiController::class,'index'])->name('gaji');

Route::view('/x','main.layout');
Route::view('/x','pages.konten');
