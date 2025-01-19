<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\gajiController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\pembayaranController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\programbelajarController;
use App\Http\Controllers\sekolahController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');

// ========= Admin ========= //
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

// ========= Kategori & Tipe Kelas ========= //
Route::get('/kategori_kelas', [kategoriController::class, 'index_jeniskelas'])->name('kategori_kelas');
Route::get('/kategori_kelas/json', [kategoriController::class, 'index_jeniskelas'])->name('kategori_kelas.json');
Route::post('/kategori_kelas/store', [kategoriController::class, 'store_kategorikelas'])->name('kategori_kelas.store');
Route::get('/kategori_kelas/edit/{id}', [kategoriController::class, 'edit_kategorikelas'])->name('kategori_kelas.edit');
Route::patch('/kategori_kelas/update/{id}', [kategoriController::class, 'update_kategorikelas'])->name('kategori_kelas.update');
Route::delete('/kategori_kelas/delete/{id}', [kategoriController::class, 'destroy_kategoriKelas'])->name('kategori_kelas.delete');

Route::get('/tipe_kelas', [kategoriController::class, 'index_tipekelas'])->name('tipe_kelas');
Route::get('/tipe_kelas/json', [kategoriController::class, 'index_tipekelas'])->name('tipe_kelas.json');
Route::post('/tipe_kelas/store', [kategoriController::class, 'store_tipekelas'])->name('tipe_kelas.store');
Route::get('/tipe_kelas/edit/{id}', [kategoriController::class, 'edit_tipekelas'])->name('tipe_kelas.edit');
Route::patch('/tipe_kelas/update/{id}', [kategoriController::class, 'update_tipekelas'])->name('tipe_kelas.update');
Route::delete('/tipe_kelas/delete/{id}', [kategoriController::class, 'destroy_tipeKelas'])->name('tipe_kelas.delete');


// ========= Sekolah ========= //
Route::get('/sekolah', [sekolahController::class, 'index'])->name('sekolah');
Route::get('/sekolah/json', [sekolahController::class, 'index'])->name('sekolah.json');
Route::post('/sekolah/store', [sekolahController::class, 'store'])->name('sekolah.store');
Route::get('/sekolah/edit/{id}', [sekolahController::class, 'edit'])->name('sekolah.edit');
Route::patch('/sekolah/update/{id}', [sekolahController::class, 'update'])->name('sekolah.update');
Route::delete('/sekolah/delete/{id}', [sekolahController::class, 'destroy'])->name('sekolah.delete');

// ========= Program Belajar ========= //
Route::get('/program_belajar', [programbelajarController::class, 'index'])->name('program_belajar');
Route::get('/program_belajar/json', [programbelajarController::class, 'index'])->name('program_belajar.json');
Route::post('/program_belajar/store', [programbelajarController::class, 'store'])->name('program_belajar.store');
Route::get('/program_belajar/edit/{id}', [programbelajarController::class, 'edit'])->name('program_belajar.edit');
Route::patch('/program_belajar/update/{id}', [programbelajarController::class, 'update'])->name('program_belajar.update');
Route::delete('/program_belajar/delete/{id}', [programbelajarController::class, 'destroy'])->name('program_belajar.delete');


// ========= Kelas ========= //
Route::get('/kelas', [kelasController::class, 'index'])->name('kelas');
Route::get('/kelas/json', [kelasController::class, 'index'])->name('kelas.json');
Route::get('/form_programbelajar/json', [kelasController::class, 'program_belajar'])->name('form_programbelajar.json');
Route::get('/pengajar/json', [kelasController::class, 'pengajar'])->name('pengajar.json');
Route::post('/kelas/store', [kelasController::class, 'store'])->name('kelas.store');
Route::get('/kelas/edit/{id}', [kelasController::class, 'edit'])->name('kelas.edit');
Route::patch('/kelas/update/{id}', [kelasController::class, 'update'])->name('kelas.update');
Route::get('/kelas/detail/{id}', [kelasController::class, 'show'])->name('kelas.detail');

// ========= Pengguna ========= //
Route::get('/pengguna/{id}', [penggunaController::class, 'pengguna'])->name('admin');
Route::get('/data_admin/{id}/json', [penggunaController::class, 'pengguna'])->name('admin.json');

Route::get('/data_pengajar', [penggunaController::class, 'datapengajar'])->name('pengajar');
Route::get('/data_pengajar/json', [penggunaController::class, 'datapengajar'])->name('pengajar.json');

Route::get('/data_siswa', [penggunaController::class, 'datasiswa'])->name('siswa');
Route::get('/data_siswa/json', [penggunaController::class, 'datasiswa'])->name('siswa.json');


// ========= Gaji ========= //
Route::get('/gaji', [gajiController::class, 'index'])->name('gaji');

// ========= Pembayaran ========= //
Route::get('/pembayaran', [pembayaranController::class, 'index'])->name('pembayaran');

Route::view('/x', 'main.layout');
Route::view('/x', 'pages.konten');

//route edit
// Route::get('/tipe_kelas/edit/{id}', [kategoriController::class, 'edit'])->name('edit');