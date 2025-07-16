<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardPenggunaController;
use App\Http\Controllers\gajiController;
use App\Http\Controllers\gajiPengajarController;
use App\Http\Controllers\IndexPendaftaranController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\KategoriPekerjaanController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\kelaspengajarController;
use App\Http\Controllers\pembayaranController;
use App\Http\Controllers\pembelajaranController;
use App\Http\Controllers\pendaftaranController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\programbelajarController;
use App\Http\Controllers\RiwayatPembayaranController;
use App\Http\Controllers\sekolahController;
use App\Http\Controllers\siswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Models\kategori_pekerjaan;

Route::view('/', 'index')->name('index');
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'Authenticate'])->name('proses-Login');
Route::get('/register/{kategori}/{id}', [AuthController::class, 'register'])->name('register');
Route::post('/register', [pendaftaranController::class, 'store'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');

    Route::middleware('CheckRole:Admin,Pengajar,Siswa')->group(function () {});

    Route::middleware('CheckRole:Admin')->group(function () {
        // ========= Pembuatan Form Index Pendaftaran ========= //
        Route::resource('/pendaftaran', IndexPendaftaranController::class)->names('pendaftaran');

        // ========= Validasi Pendaftaran ========= //
        Route::resource('/validasi', pendaftaranController::class)->names('validasi');
        Route::get('/search-kelas', [pendaftaranController::class, 'search_kelas'])->name('search_kelas');
        Route::post('/validasi/acc', [pendaftaranController::class, 'acc_pendaftaran'])->name('validasi.acc');
        Route::get('/siswa/{id}/json', [pendaftaranController::class, 'search_siswa'])->name('search_siswa');
        Route::post('/validasi/masukkls/{idKelas}', [pendaftaranController::class, 'masuk_kelasAcc'])->name('validasi.Masuk_kelasAcc');

        // ========= Dashboard Admin ========= //
        Route::get('/dashboard', [dashboardPenggunaController::class, 'index_Admin'])->name('dashboard');

        // ========= Tipe Kelas ========= //
        Route::get('/tipe_kelas', [kategoriController::class, 'index_tipekelas'])->name('tipe_kelas');
        Route::get('/tipe_kelas/json', [kategoriController::class, 'index_tipekelas'])->name('tipe_kelas.json');
        Route::post('/tipe_kelas/store', [kategoriController::class, 'store_tipekelas'])->name('tipe_kelas.store');
        Route::get('/tipe_kelas/edit/{id}', [kategoriController::class, 'edit_tipekelas'])->name('tipe_kelas.edit');
        Route::patch('/tipe_kelas/update/{id}', [kategoriController::class, 'update_tipekelas'])->name('tipe_kelas.update');
        Route::delete('/tipe_kelas/delete/{id}', [kategoriController::class, 'destroy_tipeKelas'])->name('tipe_kelas.delete');

        // ========= Kategori Kelas ========= //
        Route::get('/kategori_kelas', [kategoriController::class, 'index_jeniskelas'])->name('kategori_kelas');
        Route::get('/kategori_kelas/json', [kategoriController::class, 'index_jeniskelas'])->name('kategori_kelas.json');
        Route::post('/kategori_kelas/store', [kategoriController::class, 'store_kategorikelas'])->name('kategori_kelas.store');
        Route::get('/kategori_kelas/edit/{id}', [kategoriController::class, 'edit_kategorikelas'])->name('kategori_kelas.edit');
        Route::patch('/kategori_kelas/update/{id}', [kategoriController::class, 'update_kategorikelas'])->name('kategori_kelas.update');
        Route::delete('/kategori_kelas/delete/{id}', [kategoriController::class, 'destroy_kategoriKelas'])->name('kategori_kelas.delete');

        // ========= Kategori Pekerjaan ========= //
        Route::resource('/kategori_pekerjaan', KategoriPekerjaanController::class)->names('kategori_pekerjaan');

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
        Route::get('/kelas/{id}', [kelasController::class, 'index'])->name('kelas');
        Route::get('/form_programbelajar/json', [kelasController::class, 'program_belajar'])->name('form_programbelajar.json');
        Route::get('/pengajar/json', [kelasController::class, 'pengajar'])->name('pengajar.json');
        Route::post('/kelas/store', [kelasController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/edit/{id}', [kelasController::class, 'edit'])->name('kelas.edit');
        Route::patch('/kelas/update/{id}', [kelasController::class, 'update'])->name('kelas.update');
        Route::get('/kelas/detail/{id}', [kelasController::class, 'show'])->name('kelas.detail');
        Route::delete('/kelas/delete/{id}', [kelasController::class, 'destroy'])->name('kelas.delete');

        // ========= Detail Kelas ========= //
        Route::get('/jurnal_kelas/{id}', [kelasController::class, 'jurnalkelas'])->name('jurnal_kelas');
        Route::get('/sertifikat/download-zip/{id}', [kelasController::class, 'generateAndDownloadZip'])->name('sertifikat');
        Route::patch('/kelas/selesai/{id}', [kelasController::class, 'kelasselesai'])->name('kelas.selesai');

        Route::get('/pembelajaran/{id}/json', [pembelajaranController::class, 'index'])->name('pembelajaran.json');
        Route::get('/detail_pertemuan/json/{id}', [pembelajaranController::class, 'detailPertemuan'])->name('detail_pertemuan.json');
        Route::post('/pembelajaran/store', [pembelajaranController::class, 'store'])->name('pembelajaran.store');
        Route::get('/siswa/all', [pembelajaranController::class, 'siswa_all'])->name('siswa_kelas.json');
        Route::post('/siswa/kelas/update/{id}', [pembelajaranController::class, 'addsiswa'])->name('add_siswa.update');
        Route::get('/infoKePengguna/{id}', [pembelajaranController::class, 'info_kepengguna'])->name('info.akun');
        Route::get('/datasiswa/kelas/json/{id}', [pembelajaranController::class, 'datasiswa'])->name('datasiswa_kelas.json');
        Route::patch('/pertemuan/update/{id}', [pembelajaranController::class, 'update'])->name('pembelajaran.update');
        Route::delete('/pertemuan/delete/{id}', [pembelajaranController::class, 'destroy'])->name('pertemuan.delete');
        Route::post('/murid/hapus', [pembelajaranController::class, 'hapus'])->name('murid.hapus');

        // ========= Generate Sertiv Custom ========= //
        Route::get('/generate-sertiv', [kelasController::class, 'generate_show'])->name('generate.show');
        Route::post('/sertiv/pembelajaran', [siswaController::class, 'generate_sertiv'])->name('sertiv.siswa');

        // ========= Pengguna ========= //
        Route::get('/pengguna/{id}', [penggunaController::class, 'pengguna'])->name('pengguna');
        Route::patch('/pengguna/reset/{id}', [penggunaController::class, 'reset_password'])->name('pengguna.reset');
        Route::get('/data_pengguna/{id}/json', [penggunaController::class, 'pengguna'])->name('pengguna.json');
        Route::get('/permintaan_mendaftar/{id}/json', [penggunaController::class, 'permintaan_mendaftar'])->name('permintaan_join.json');
        Route::get('/kelas/diikuti/{id}', [penggunaController::class, 'kelas_diikuti'])->name('kelas.diikuti');
        Route::post('/pengguna/store', [penggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/sekolah_form/json', [penggunaController::class, 'sekolah'])->name('sekolah_form.json');
        Route::get('/pengguna/edit/{id}/{role}', [penggunaController::class, 'edit'])->name('pengguna.edit');
        Route::patch('/pengguna/update/{id}/{role}', [penggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/delete/{id}/{role}', [penggunaController::class, 'destroy'])->name('pengguna.delete');
        Route::get('/data_pengajar', [penggunaController::class, 'datapengajar'])->name('pengajar');


        // ========= Gaji ========= //
        Route::get('/gaji', [gajiController::class, 'index'])->name('gaji');
        Route::get('/data_pengajar/json', [gajiController::class, 'index'])->name('gaji.json');
        Route::get('detail/gaji/{id}', [gajiController::class, 'show'])->name('gaji_detail');
        Route::patch('/gaji_utama/verifikasi/{id}', [gajiController::class, 'gaji_utama'])->name('gaji.verifikasi');
        Route::patch('/gaji_transport/verifikasi/{id}', [gajiController::class, 'gaji_transport'])->name('transport.verifikasi');
        Route::patch('/gaji_custom/verifikasi/{id}', [gajiController::class, 'gaji_custom'])->name('custom.verifikasi');
        Route::patch('/gaji_all/verifikasi/{id}', [gajiController::class, 'verif_all'])->name('verifikasi.all');
        Route::patch('/gaji/terbayar/{id}', [gajiController::class, 'gaji_terbayar'])->name('gaji.terbayar');

        // ========= Histori Gaji ========= //
        Route::get('/histori/gaji', [gajiController::class, 'historigaji'])->name('histori_gaji');
        Route::get('/detail/histori/{pengajar_id}/{tanggal_id}', [gajiController::class, 'detailhistori'])->name('detail_histori');

        // ========= Pembayaran ========= //
        Route::get('/pembayaran', [pembayaranController::class, 'index'])->name('pembayaran');
        Route::get('/pembayaran/json', [pembayaranController::class, 'index'])->name('pembayaran.json');
        Route::get('/pembayaran/detail/{id}', [pembayaranController::class, 'show'])->name('pembayaran.detail');
        Route::get('/pembayaran/murid/json/{id}', [pembayaranController::class, 'show'])->name('pembayaran_murid.json');
        Route::patch('/pembayaran/murid/{kelas_id}/{siswa_id}', [pembayaranController::class, 'update'])->name('pembayaran.murid');
        Route::post('/penagihan', [pembayaranController::class, 'penagihan'])->name('penagihan');
        Route::get('/penagiha/personal/{id}/{kelas_id}', [pembayaranController::class, 'penagihan_personal'])->name('penagihan_personal');

        // ========= Riwayat Pembayaran ========= //
        Route::resource('/riwayat_pembayaran/{siswa_id}/{kelas_id}', RiwayatPembayaranController::class)->names('riwayat_pembayaran');
    });

    Route::middleware('CheckRole:Pengajar')->group(function () {});

    Route::middleware('CheckRole:Siswa')->group(function () {});
});














// ====================================================================================== //
// ================================ PENGAJAR ============================================ //
// ====================================================================================== //

// ========= Dashboard Pengajar ========= //
Route::get('/dashboard/pengajar', [dashboardPenggunaController::class, 'index_Pengajar'])->name('dashboard_pengajar');

// ========= Kelas Pengajar ========= //
Route::get('/kelas_pengajar/{id}/aktif', [kelaspengajarController::class, 'kelas_aktif'])->name('kelas_aktif.pengajar');
Route::get('/kelas_pengajar/selesai', [kelaspengajarController::class, 'kelas_selesai'])->name('kelas_selesai.pengajar');
Route::get('/detail_kelas/{id}', [kelaspengajarController::class, 'show'])->name('pengajar.detail_kelas');
Route::get('/detail_kelas/selesai/{id}', [kelaspengajarController::class, 'show_selesai'])->name('pengajar.detail_kelas.selesai');
Route::get('/detail/Absen/{id}/json', [kelaspengajarController::class, 'detail_absensi'])->name('detailabsensi.json');
Route::post('/pengajar/bantu/absen/{id}', [kelaspengajarController::class, 'pengajar_bantu'])->name('pengajarbantu.absen');
Route::get('/absen/siswa/{id}', [kelaspengajarController::class, 'siswa_show'])->name('absen.siswa');
Route::post('/absen/siswa/store/{id}', [kelaspengajarController::class, 'store'])->name('absen.store');
Route::patch('/siswa/selesai/{id_kelas}/{id_siswa}', [kelaspengajarController::class, 'siswa_selesai'])->name('siswa.selesai');
Route::post('/kelas/selesai/{id}', [kelaspengajarController::class, 'finish_kelas'])->name('kelas.selesai');

// ========= Gaji ========= //
Route::get('/gaji/{id}', [gajiPengajarController::class, 'index'])->name('gaji.pengajar');
Route::get('/riwayat/gaji/{id}', [gajiPengajarController::class, 'riwayat_gaji'])->name('riwayatgaji.pengajar');
Route::get('/detail/{id}/histori/{idtanggal}', [gajiPengajarController::class, 'detail_histori'])->name('detail.riwayat.histori');
Route::get('/Absen/custom', [gajiPengajarController::class, 'gaji_custom'])->name('gaji.custom');
Route::post('/Absen/custom', [gajiPengajarController::class, 'store'])->name('gajicustom.store');

// ========= Edit Profile ========= //
Route::get('/edit_profile/{id}', [dashboardPenggunaController::class, 'edit'])->name('edit_profile');
Route::patch('/update_profile/{id}', [dashboardPenggunaController::class, 'update'])->name('update_profile');


// ====================================================================================== //
// ================================== SISWA ============================================= //
// ====================================================================================== //

// ========= Dashboard Siswa ========= //
Route::get('/dashboard/siswa', [dashboardPenggunaController::class, 'index_Siswa'])->name('dashboard_siswa');
Route::get('/kelas/saya/{id}', [siswaController::class, 'index'])->name('siswa.kelas.json');
Route::get('/detail/kelas/{id}/siswa', [siswaController::class, 'show'])->name('siswa_kelas.detail.json');
Route::get('/pembayaran/{id}', [siswaController::class, 'pembayaran'])->name('pembayaran.siswa');
Route::post('/detail/pembayaran', [siswaController::class, 'detail_pembayaran'])->name('detail_pembayaran.siswa');
Route::post('/sertiv/pembelajaran', [siswaController::class, 'generate_sertiv'])->name('sertiv.siswa');
