<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\dashboardUser;
use App\Http\Controllers\dashboardUserController;
use App\Http\Controllers\gajiController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\kelaspengajarController;
use App\Http\Controllers\pembayaranController;
use App\Http\Controllers\pembelajaranController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\programbelajarController;
use App\Http\Controllers\sekolahController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'Authenticate'])->name('proses-Login');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');

Route::view('/x', 'main.layout');
// Route::view('/x', 'pages.konten');

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
Route::delete('/kelas/delete/{id}', [kelasController::class, 'destroy'])->name('kelas.delete');
Route::patch('/kelas/selesai/{id}', [kelasController::class, 'kelasselesai'])->name('kelas.selesai');



// ========= PDF Kelas ========= //
Route::get('/jurnal_kelas/{id}', [kelasController::class, 'jurnalkelas'])->name('jurnal_kelas');
Route::get('/sertifikat/{id}', [kelasController::class, 'sertifikat'])->name('sertifikat');


// ========= Pembelajaran ========= //
Route::post('/pembelajaran/store', [pembelajaranController::class, 'store'])->name('pembelajaran.store');
Route::get('/pembelajaran/{id}/json', [pembelajaranController::class, 'index'])->name('pembelajaran.json');
Route::get('/siswa/sekolah/json', [pembelajaranController::class, 'siswa'])->name('siswa_kelas.json');
Route::post('/siswa/kelas/update/{id}', [pembelajaranController::class, 'addsiswa'])->name('add_siswa.update');
Route::get('/datasiswa/kelas/json/{id}', [pembelajaranController::class, 'datasiswa'])->name('datasiswa_kelas.json');
Route::get('/detail_pertemuan/json/{id}', [pembelajaranController::class, 'detailPertemuan'])->name('detail_pertemuan.json');
Route::patch('/pertemuan/update/{id}', [pembelajaranController::class, 'update'])->name('pembelajaran.update');
Route::delete('/pertemuan/delete/{id}', [pembelajaranController::class, 'destroy'])->name('pertemuan.delete');
Route::post('/murid/hapus', [pembelajaranController::class, 'hapus'])->name('murid.hapus');


// ========= Pengguna ========= //
Route::get('/pengguna/{id}', [penggunaController::class, 'pengguna'])->name('admin');
Route::get('/data_admin/{id}/json', [penggunaController::class, 'pengguna'])->name('admin.json');

Route::post('/pengguna/store', [penggunaController::class, 'store'])->name('pengguna.store');
Route::get('/sekolah_form/json', [penggunaController::class, 'sekolah'])->name('sekolah_form.json');

// Route::get('/sekolah/json', [penggunaController::class, 'sekolah'])->name('sekolah.json');
Route::get('/pengguna/edit/{id}', [penggunaController::class, 'edit'])->name('pengguna.edit');
Route::patch('/pengguna/update/{id}', [penggunaController::class, 'update'])->name('pengguna.update');
Route::delete('/pengguna/delete/{id}', [penggunaController::class,'destroy'])->name('pengguna.delete');

Route::get('/data_pengajar', [penggunaController::class, 'datapengajar'])->name('pengajar');
// Route::get('/data_pengajar/json', [penggunaController::class, 'datapengajar'])->name('data_pengajar.json');

Route::get('/data_siswa', [penggunaController::class, 'datasiswa'])->name('siswa');
// Route::get('/data_siswa/json', [penggunaController::class, 'datasiswa'])->name('siswa.json');


// ========= Gaji ========= //
Route::get('/gaji', [gajiController::class, 'index'])->name('gaji');
Route::get('/data_pengajar/json', [gajiController::class, 'index'])->name('gaji.json');


// ========= Pembayaran ========= //
Route::get('/pembayaran', [pembayaranController::class, 'index'])->name('pembayaran');
Route::get('/pembayaran/json', [pembayaranController::class, 'index'])->name('pembayaran.json');


//route edit
// Route::get('/tipe_kelas/edit/{id}', [kategoriController::class, 'edit'])->name('edit');
Route::get('kuy/json/{id}', [pembelajaranController::class, 'kuy'])->name('kuy.json');

// ========= Dashboard Pengajar ========= //
Route::get('/dashboard_user', [dashboardUserController::class, 'index'])->name('dashboard_pengajar');
Route::get('/kelas_saya', [kelaspengajarController::class, 'index'])->name('kelas_saya');