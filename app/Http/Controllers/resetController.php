<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\gajiCustom;
use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\historigaji;
use App\Models\Indexkeuangan;
use App\Models\indexPendaftaran;
use App\Models\invoice;
use App\Models\Kategori;
use App\Models\kategori_pekerjaan;
use App\Models\kelas;
use App\Models\keuangan;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pendaftaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use App\Models\reset;
use App\Models\riwayatPembayaran;
use App\Models\sekolah;
use App\Models\Tipekelas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class resetController extends Controller
{
    public function index()
    {
        return view('pages.Reset.reset');
    }

    public function store(Request $request)
    {
        $kode = Str::upper(Str::random(4));
        reset::create([
            'kode' => Hash::make($kode),
        ]);

        Http::withHeaders([
            'Authorization' => '14c3GQbn1ZJNKGLCHwz1'
        ])->post('https://api.fonnte.com/send', [
            'target' => '+6281276435511',
            'message' => "
📢 Informasi Kode Reset

Menginformasikan kode reset, kode ini bersifat rahasia dan hanya berlaku sekali :
♻️ Kode Reset : *$kode*    
"
        ]);

        return redirect()->route('reset')->with('success', 'Reset successful!');
    }

    public function verivikasi(Request $request)
    {
        $request->validate([
            'code1' => 'required|max:1',
            'code2' => 'required|max:1',
            'code3' => 'required|max:1',
            'code4' => 'required|max:1',
        ]);

        $kode = $request->code1 . $request->code2 . $request->code3 . $request->code4;
        $token_reset = reset::first();
        if ($token_reset === null) {
            return redirect()->route('reset')->with('error', 'Kode verifikasi salah!');
        } 
        
        if (Hash::check($kode, reset::first()->kode)) {
            try {
                reset::truncate();
                gajiUtama::truncate();
                gajiCustom::truncate();
                gajiTransport::truncate();
                kategori_pekerjaan::truncate();

                historigaji::query()->delete();
                DB::statement('ALTER TABLE history_gaji AUTO_INCREMENT = 1');

                riwayatPembayaran::truncate();
                invoice::truncate();
                pendaftaran::truncate();
                indexPendaftaran::truncate();
                pembelajaran::query()->delete();
                DB::statement('ALTER TABLE pembelajaran AUTO_INCREMENT = 1');

                muridKelas::truncate();
                kelas::query()->delete();
                DB::statement('ALTER TABLE kelas AUTO_INCREMENT = 1');

                programbelajar::query()->delete();
                DB::statement('ALTER TABLE program_belajar AUTO_INCREMENT = 1');

                Kategori::query()->delete();
                DB::statement('ALTER TABLE kategori_kelas AUTO_INCREMENT = 1');

                Tipekelas::query()->delete();
                DB::statement('ALTER TABLE tipe_kelas AUTO_INCREMENT = 1');

                keuangan::truncate();
                Indexkeuangan::truncate();

                pengguna::query()->delete();
                DB::statement('ALTER TABLE profile AUTO_INCREMENT = 1'); 

                akun::query()->delete();
                DB::statement('ALTER TABLE akun AUTO_INCREMENT = 1'); 

                sekolah::query()->delete();
                DB::statement('ALTER TABLE sekolah AUTO_INCREMENT = 1');

            return redirect()->route('login')->with('success', 'Kode verifikasi berhasil!');

            } catch (Exception $e) {
                dd($e->getMessage());
            }

            return redirect()->route('reset')->with('success', 'Kode verifikasi berhasil!');
        }
    }
}
