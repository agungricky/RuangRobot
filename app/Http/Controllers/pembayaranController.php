<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\If_;

class pembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = kelas::join('kategori_kelas', 'kategori_kelas.id', '=', 'kelas.kategori_kelas_id')
            ->select('kelas.id', 'kelas.nama_kelas', 'kelas.status_kelas', 'kelas.created_at', 'kategori_kelas.kategori_kelas')
            ->orderByDesc('created_at')
            ->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.pembayaran.pembayaran');
    }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $data = kelas::join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
            ->join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
            ->select('kelas.*', 'kategori_kelas.kategori_kelas', 'program_belajar.nama_program', 'program_belajar.level', 'program_belajar.mekanik', 'program_belajar.elektronik', 'program_belajar.pemrograman')
            ->where('kelas.id', $id)->first();

        // Menghitung Jumlah Siswa
        $jm = kelas::where('kelas.id', $id)
            ->join('murid_kelas', 'murid_kelas.kelas_id', 'kelas.id')
            ->first();

        if ($jm && $jm->murid) {
            $muridArray = json_decode($jm->murid, true);
            $jumlahSiswa = count($muridArray);
        } else {
            $jumlahSiswa = 0;
        }

        // Rencana Pendapatan Kelas
        $rencana_pendapatan = $jumlahSiswa * $data->harga;

        $totalPembayaran = 0;
        foreach ($muridArray as $key => $value) {
            $totalPembayaran += $value['pembayaran'];
        }

        // Menghitung Sisa Pembayaran
        $sisaPembayaran = [];
        foreach ($muridArray as $key => $value) {
            $sisaPembayaran[$key] = $value['tagihan'] - $value['pembayaran'];
            $muridArray[$key]['sisa_pembayaran'] = $sisaPembayaran[$key];
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $muridArray,
            ]);
        }

        return view('pages.pembayaran.detail_pembayaran', compact('data', 'jumlahSiswa', 'rencana_pendapatan', 'totalPembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kelas_id, $siswa_id)
    {
        $kelas = muridKelas::where('kelas_id', $kelas_id)->first();

        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }

        $murid_decode = json_decode($kelas->murid, true);

        foreach ($murid_decode as &$murid) {
            if ($murid['id'] == $siswa_id) {
                $murid['pembayaran'] += $request->tambah_pembayaran;
                break;
            }
        }

        $kelas->update([
            'murid' => json_encode($murid_decode),
        ]);

        // =============================================//
        // ========== Iformasi Kepada Orangtua =========//
        // =============================================//

        $data = pengguna::where('id', $siswa_id)->first();
        $kelas = kelas::where('id', $kelas_id)->first();
        $muridkelas = muridKelas::where('kelas_id', $kelas_id)->first();
        $murid = json_decode($muridkelas->murid, true);
        $datasiswa = null;
        foreach ($murid as $key => $value) {
            if ($value['id'] == $data['id']) {
                $datasiswa = $value;
                break;
            }
        }
        $kekurangan = $datasiswa['tagihan'] - $datasiswa['pembayaran'];

        if ($kekurangan == 0) {
            $tangal_lunas = now()->format('d-m-Y');
            $jatuh_tempo = "Status Pembayaran : *LUNAS* / $tangal_lunas";
        }else{
            $jatuh_tempo = "Jatuh Tempo : ". $datasiswa['jatuh_tempo'];
            $alert = "Untuk melakukan pembayaran, berikut adalah informasi rekening bank untuk pembayaran 💳:
Bank: BCA (Bank Central Asia)
Nomor Rekening: 9203123456
Atas Nama: Julian Sahertian";
        }

        $response = Http::withHeaders([
            'Authorization' => '14c3GQbn1ZJNKGLCHwz1'  // Ganti dengan token yang valid
        ])->post('https://api.fonnte.com/send', [
            'target' => $data->no_telp,
            'message' => "
*💡 #INFORMASI PEMBAYARAN DITERIMA 📚*

Halo 👋 $data->nama,
Sehubungan dengan pembelajaran dalam Kelas $kelas->nama_kelas, kami ingin menginformasikan mengenai pembayaran masuk. 
Berikut kami sampaikan rinciannya :

Pembelajaran : *$kelas->nama_kelas*
Pembayaran Diterima : Rp. " . number_format($datasiswa['pembayaran'], 0, ',', '.') . "
Tagihan Kelas : Rp. " . number_format($datasiswa['tagihan'], 0, ',', '.') . "
Total Kekurangan: Rp. " . number_format($kekurangan, 0, ',', '.') . "
$jatuh_tempo

". ($alert?? '') . "

Jika ada pertanyaan atau Anda membutuhkan bantuan, jangan ragu untuk menghubungi kami di:
📞 https://wa.me/+6285655770506

                            
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

        return response()->json(['success' => 'Pembayaran berhasil diperbarui']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
