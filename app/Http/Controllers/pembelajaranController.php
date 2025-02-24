<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\invoice;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class pembelajaranController extends Controller
{
    public function kuy($id)
    {
        $data = pengguna::where('profile.id', $id)
            ->join('akun', 'akun.id', 'profile.id')
            ->first();

        $pembelajaran = kelas::where('kelas.id', 3)->first();

        // dd($data);

        $response = Http::withHeaders([
            'Authorization' => '14c3GQbn1ZJNKGLCHwz1'  // Ganti dengan token yang valid
        ])->post('https://api.fonnte.com/send', [
            'target' => $data->no_telp,
            'message' => "
*💡 #Invoice Tagihan Pembayaran 📚*

Halo 👋 $data->nama,
Sehubungan dengan pembelajaran dalam Kelas $pembelajaran->nama_kelas, kami ingin menginformasikan mengenai pembayaran yang harus dilakukan. Berikut kami sampaikan rincian tagihannya:

Pembelajaran : *$pembelajaran->nama_kelas*
Tagihan : Rp. $pembelajaran->harga
Tanggal Jatuh Tempo: $pembelajaran->jatuh_tempo
Nomor Tagihan: INV-202312121212
Total Terbayar: Rp. 0

Untuk melakukan pembayaran, berikut adalah informasi rekening bank untuk pembayaran 💳:
Bank: BCA (Bank Central Asia)
Nomor Rekening: 9203123456
Atas Nama: Julian Sahertian
                            
Jika ada pertanyaan atau Anda membutuhkan bantuan, jangan ragu untuk menghubungi kami di:
📞 https://wa.me/+6281276435511

Untuk pemantauan pembelajaran dapat dilihat di:
🌐 ruangrobot.id
▶ username : $data->username
▶ password : ruangrobot
                            
Kami siap membantu Anda! 😊
Terima kasih banyak atas perhatian dan kerjasamanya! 🙏💙
                            
Salam hangat,
*Ruang Robot*,
Perum Mojoroto Indah, Jl. Raya Mojoroto No. 123, Kota Surabaya, Jawa Timur, 60234",
            'countryCode' => '62',
            'filename' => 'Tagihanku',
            'schedule' => 0,
            'typing' => false,
            'delay' => '0',
            'followup' => 0,
        ]);

        if ($response->successful()) {
            // Response berhasil
            return $response->body();
        } else {
            // Response gagal
            return $response->status();
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data = pembelajaran::join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('pembelajaran.*', 'kelas.durasi_belajar')
            ->where('kelas_id', $id)
            ->orderBy('pertemuan', 'asc')
            ->get();
        return response()->json(['data' => $data]);
    }

    public function siswa()
    {
        $data = pengguna::join('akun', 'akun.id', 'profile.id')
            ->join('sekolah', 'sekolah.id', 'profile.sekolah_id')
            ->select('profile.*', 'akun.role', 'sekolah.nama_sekolah')
            ->where('akun.role', 'Siswa')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function datasiswa($id)
    {
        $data = muridKelas::where('kelas_id', $id)->first();
        return response()->json(['data' => $data]);
    }

    // public function kelas($id)
    // {
    //     $data = kelas::all();
    //     return response()->json(['data' => $data]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->jumlah_pertemuan;
        $id_kelas = $request->id_kelas;
        $kelas = pembelajaran::join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->where('kelas.id', $id_kelas)
            ->count();

        $tambah_pertemuan = $kelas + $data;

        for ($i = $kelas; $i < $tambah_pertemuan; $i++) {
            pembelajaran::create([
                'pertemuan' => $i + 1,
                'pengajar' => '',
                'tanggal' => null,
                'materi' => '',
                'catatan_pengajar' => '',
                'absensi' => json_encode(new \stdClass()),
                'status_tersimpan' => 'sementara',
                'kelas_id' => $id_kelas,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function detailPertemuan(string $id)
    {
        $data = pembelajaran::where('id', $id)->first();
        return response()->json(['data' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'pertemuan' => 'required|integer|min:1', // Sesuaikan validasi sesuai kebutuhan
        ]);

        // Update data
        $pembelajaran = pembelajaran::findOrFail($id);
        $pembelajaran->update([
            'pertemuan' => $request->pertemuan,
        ]);

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pembelajaran::where('id', $id)->delete();
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    // ======================================== //
    // ============= MURID KELAS ============== //
    // ======================================== //


    /**
     * Update the specified resource in storage.
     */
    public function addSiswa(Request $request, $id)
    {
        $validatedData = $request->validate([
            'siswa' => 'required|array', // Pastikan `siswa` adalah array
        ]);

        $kelas = MuridKelas::where('kelas_id', $id)->first();

        if (!$kelas) {
            return response()->json(['message' => 'Kelas tidak ditemukan!'], 404);
        }

        // Decode data siswa yang sudah ada
        $existingSiswa = json_decode($kelas->murid, true) ?? [];

        // Konversi harga dan tagihan menjadi integer
        $newSiswa = array_map(function ($siswa) {
            $siswa['id'] = isset($siswa['id']) ? (int) $siswa['id'] : 0;
            $siswa['tagihan'] = isset($siswa['tagihan']) ? (int) $siswa['tagihan'] : 0;
            $siswa['pembayaran'] = isset($siswa['pembayaran']) ? (int) $siswa['pembayaran'] : 0;
            return $siswa;
        }, $validatedData['siswa']);

        // Gabungkan data siswa baru dengan data siswa yang sudah ada
        $mergedSiswa = array_merge($existingSiswa, $newSiswa);

        // Simpan data yang diperbarui
        $kelas->murid = json_encode($mergedSiswa);
        $kelas->save();

        // ======================================= //
        //  ============= Buat Invoice =========== //
        // ======================================= //
        $siswaList = $request->input('siswa');
        $responses = [];

        foreach ($siswaList as $siswa) {
            invoice::create([
                'profile_id' => $siswa['id'], // ID siswa
                'kelas_id' => $id, // ID kelas dari URL
            ]);

            $data = pengguna::where('profile.id', $siswa['id'])
                ->join('akun', 'akun.id', 'profile.id')
                ->first();

            $pembelajaran = kelas::where('kelas.id', $id)->first();
            
            $muridkelas = muridKelas::where('kelas_id', $id)->first();
            $murid = json_decode($muridkelas->murid, true);
            $datasiswa = null;
            foreach ($murid as $key => $value) {
                if ($value['id'] == $siswa['id']) {
                    $datasiswa = $value;
                    break;
                }
            }

            Carbon::setLocale('id'); // Pastikan bahasa Indonesia digunakan
            $tanggalJatuhTempo = Carbon::parse($pembelajaran->jatuh_tempo)->translatedFormat('l, d-m-Y');

            $response = Http::withHeaders([
                'Authorization' => '14c3GQbn1ZJNKGLCHwz1'  // Ganti dengan token yang valid
            ])->post('https://api.fonnte.com/send', [
                'target' => $data->no_telp,
                'message' => "
*💡 #Invoice Tagihan Pembayaran 📚*
    
Halo 👋 $data->nama,
Sehubungan dengan pembelajaran di Ruang Robot, kami ingin menginformasikan mengenai pembayaran yang harus dilakukan. Berikut kami sampaikan rincian tagihannya:
    
Pembelajaran : *$pembelajaran->nama_kelas*
Tagihan : Rp. " . number_format($datasiswa['tagihan'], 0, ',', '.') . "
Tanggal Jatuh Tempo: $tanggalJatuhTempo
Nomor Tagihan: " . $datasiswa['no_invoice'] . "
Total Terbayar: Rp. " . number_format($datasiswa['pembayaran'], 0, ',', '.') . "
    
Untuk melakukan pembayaran, berikut adalah informasi rekening bank untuk pembayaran 💳:
Bank: BCA (Bank Central Asia)
Nomor Rekening: 9203123456
Atas Nama: Julian Sahertian
                                
Jika ada pertanyaan atau Anda membutuhkan bantuan, jangan ragu untuk menghubungi kami di:
📞 https://wa.me/+6285655770506
    
Untuk pemantauan pembelajaran dapat dilihat di:
🌐 ruangrobot.id
▶ username : $data->username
▶ password : ruangrobot
                                
Kami siap membantu Anda! 😊
Terima kasih banyak atas perhatian dan kerjasamanya! 🙏💙
                                
Salam hangat,
*Ruang Robot*,
Perum Mojoroto Indah, Jl. Raya Mojoroto No. 123, Kota Surabaya, Jawa Timur, 60234",
                'countryCode' => '62',
                'filename' => 'Tagihanku',
                'schedule' => 0,
                'typing' => false,
                'delay' => '0',
                'followup' => 0,
            ]);

            // Simpan response untuk debug jika diperlukan
            $responses[] = $response->body();
        }

        // Kembalikan response untuk semua siswa
        return response()->json([
            'message' => 'Semua siswa berhasil ditambahkan dan invoice dikirim!',
            'responses' => $responses
        ]);
    }


    public function hapus(Request $request)
    {
        $id = $request->id; // ID murid yang ingin dihapus
        $id_kelas = $request->kelas_id; // ID kelas

        // Ambil data murid dari kolom murid di tabel murid_kelas
        $muridData = DB::table('murid_kelas')
            ->where('kelas_id', $id_kelas)
            ->value('murid');

        // Ubah JSON menjadi array
        $muridArray = json_decode($muridData, true);

        if (is_array($muridArray)) {
            // Hapus murid berdasarkan ID
            $muridArray = array_filter($muridArray, function ($siswa) use ($id) {
                return $siswa['id'] != $id;
            });

            // Simpan kembali ke database dalam bentuk JSON
            DB::table('murid_kelas')
                ->where('kelas_id', $id_kelas)
                ->update(['murid' => json_encode(array_values($muridArray))]);
        }

        invoice::where('profile_id', $id)
       ->where('kelas_id', $id_kelas) // AND condition
       ->delete();

    }
}
