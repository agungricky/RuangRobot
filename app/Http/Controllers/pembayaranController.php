<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\kelas;
use App\Models\keuangan;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use App\Models\riwayatPembayaran;
use App\Models\siswa;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\If_;

class pembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = kelas::with('kategori')->orderByDesc('created_at')->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.pembayaran.pembayaran');
    }

    public function penagihan_personal($id, $kelas_id)
    {
        $dataSiswa = pengguna::with('akun')->findOrFail($id);
        $muridKelas = muridKelas::with('kelas')->where('kelas_id', $kelas_id)->first();
        $murid = json_decode($muridKelas->murid, true);

        $siswa = [];
        foreach ($murid as $item) {
            if ($item['id'] == $id) {
                $siswa[] = $item;
            }
        }

        // $total_kekurangan = $siswa[0]->tagihan - $siswa[0]->pembayaran;
        $total_kekurangan = $siswa[0]['tagihan'] - $siswa[0]['pembayaran'];


        Http::withHeaders([
            'Authorization' => '6aESQEF3pHwm9HbAiZYA'
        ])->post('https://api.fonnte.com/send', [
            'target' => $dataSiswa->no_telp,
            'message' => "
📢 Pemberitahuan Kekurangan Pembayaran Kelas

Yth. *{$siswa[0]['nama']}*,  
Menginformasikan kekurangan pembayaran:

💳 *Rincian Pembayaran:*  
✅ *Nama:* {$siswa[0]['nama']}  
🏤 *Kelas di ikuti:* 
{$muridKelas->kelas->nama_kelas}  

- *Jumlah Dibayarkan:* Rp. " . number_format($siswa[0]['pembayaran'], 0, ',', '.') . "  
- *Total Tagihan:* Rp. " . number_format($siswa[0]['tagihan'], 0, ',', '.') . "  
- *Kekurangan:* Rp. " . number_format($total_kekurangan, 0, ',', '.') . "  

Mohon segera melunasi pembayaran.

📌 Jika ada pertanyaan atau memerlukan bantuan, silakan hubungi kami di : +6281272455577

Pembayaran bisa transfer ke rekening berikut :

Mandiri
a/n Julian Sahertian
1710003410076  

Terima kasih atas perhatian dan kerjasamanya. 🙏😊"
    ]);


        return response()
            ->json([
                'data' => $siswa
            ]);
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
        $data = kelas::with('program_belajar', 'kategori', 'pengajar')->findOrFail($id);

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
        $request->validate([
            'nominal' => 'required|numeric',
            'jenis_pembayaran' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'metode_pembayaran' => 'required|string|in:Transfer,Cash',
            'kelas_id' => 'required|numeric',
            'siswa_id' => 'required|numeric',
        ]);

        $kelas = muridKelas::where('kelas_id', $kelas_id)->first();

        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }

        $murid_decode = json_decode($kelas->murid, true);

        foreach ($murid_decode as &$murid) {
            if ($murid['id'] == $siswa_id) {
                $murid['pembayaran'] += $request->nominal;
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
        } else {
            // $jatuh_tempo = "Jatuh Tempo : " . $datasiswa['jatuh_tempo'];
            $jatuh_tempo = "";
        }

        $response = Http::withHeaders([
            'Authorization' => '6aESQEF3pHwm9HbAiZYA'
        ])->post('https://api.fonnte.com/send', [
            'target' => $data->no_telp,
            'message' => "
📢 #INFORMASI PEMBAYARAN DITERIMA

Halo 👋 $data->nama,
Terimakasih sudah melakukan pembayaran :

- Pembelajaran : *$kelas->nama_kelas*
- Pembayaran Diterima : Rp. " . number_format($datasiswa['pembayaran'], 0, ',', '.') . "
- Tagihan Kelas : Rp. " . number_format($datasiswa['tagihan'], 0, ',', '.') . "
- Total Kekurangan: Rp. " . number_format($kekurangan, 0, ',', '.') . "
$jatuh_tempo

Pesan ini adalah bukti pembayaran yang sah dari ruang robot apabila ada kendala bisa menghubungi 
Admin +6281272455577"
        ]);

        // Simpan response untuk debug jika diperlukan
        $responses[] = $response->body();

        riwayatPembayaran::create([
            'kelas_id' => $kelas_id,
            'nama' => $siswa_id,
            'nominal' => $request->nominal,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'tanggal' => $request->tanggal,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        $saldoakhir = keuangan::orderBy('id', 'desc')->first();
        keuangan::create([
            'indexkeuangan_id' => null,
            'tipe' => 'Pemasukan',
            'keterangan' => 'Pembayaran' . $data->nama . ' Kelas ' . $kelas->nama_kelas,
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'saldo_akhir' => $saldoakhir->saldo_akhir + $request->nominal,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return response()->json(['success' => 'Pembayaran berhasil diperbarui', 'data' => $request->all()]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function penagihan(Request $request)
    {
        $data = $request->pembayaran;

        $cariSiswa = [];
        foreach ($data as $key => $value) {
            $siswa = pengguna::where('id', $value['id'])->first();

            if ($siswa) {
                $cariSiswa[] = array_merge($siswa->toArray(), $value);
            }
        }

        foreach ($cariSiswa as $value) {
            Http::withHeaders([
                'Authorization' => '6aESQEF3pHwm9HbAiZYA'
            ])->post('https://api.fonnte.com/send', [
                'target' => $value['no_telp'],
                'message' => "
📢 Pemberitahuan Kekurangan Pembayaran Kelas

Yth. *{$value['nama']}*,  
Menginformasikan kekurangan pembayaran:

💳 *Rincian Pembayaran:*  
- *Nama:* {$value['nama']}  
- *Kelas di ikuti:* 
{$value['namaKelas']}  

- *Jumlah Dibayarkan:* Rp. " . number_format($value['pembayaran'], 0, ',', '.') . "  
- *Total Tagihan:* Rp. " . number_format($value['tagihan'], 0, ',', '.') . "  
- *Sisa Pembayaran:* Rp. " . number_format($value['sisa_pembayaran'], 0, ',', '.') . "  

Mohon segera melunasi pembayaran.

📌 Jika ada pertanyaan atau memerlukan bantuan, silakan hubungi kami di : +6281272455577

Pembayaran bisa transfer ke rekening berikut

Mandiri
a/n Julian Sahertian
1710003410076  

Terima kasih atas perhatian dan kerjasamanya. 🙏😊"
            ]);
        }

        return response()->json([
            'data' => $cariSiswa
        ]);
    }
}
