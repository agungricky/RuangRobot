<?php

namespace App\Http\Controllers;

use App\Models\gajiUtama;
use App\Models\kelas;
use App\Models\pembelajaran;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class kelaspengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kelas_aktif = kelas::
            ->where('status_kelas', 'aktif')
            ->select('kelas.id')
            ->get();

        return response()->json([
            'data' => $kelas_aktif
        ]);

        $kelas2 = kelas::with(['program_belajar', 'kategori_kelas'])
            ->where('status_kelas', 'selesai')
            ->get();

        if (request()->ajax()) {
            return response()->json([
                'data' => $kelas_aktif,
                'kelas2' => $kelas2
            ]);
        }

        return view('pages.kelas.kelas_pengajar', compact('kelas2'));
    }


    public function jadwal()
    {
        $cekData = pembelajaran::with('kelas')->get();

dd($cekData); // Debugging

        return view('pages.kelas.jadwal_kelas', compact('jadwal'));
    }

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
    public function show(string $id)
    {
        // Ambil kelas + pembelajaran terkait
        $kelas = Kelas::with('pembelajaran')->findOrFail($id);

        //ambil daftar pembelajaran berdasarkan kelas_id
        $pembelajaran = pembelajaran::with('kelas')
            ->select('id', 'pertemuan', 'pengajar', 'tanggal', 'materi', 'catatan_pengajar', 'absensi', 'status_tersimpan', 'kelas_id')
            ->where('kelas_id', $id)
            ->orderBy('tanggal', 'asc')
            ->limit(25)
            ->get();

        //ambil data siswa di kelas tersebut
        $siswa = siswa::where('kelas_id', $id)->get();

        //proses status absensi untuk setiap pembelajaran
        foreach ($pembelajaran as $p) {
            $p->status_absen = $this->cekStatusAbsen($p->tanggal, $p->materi);
        }

        return view('pages.kelas.detail_kelas_pengajar', compact('kelas', 'siswa', 'pembelajaran'));
    }

    private function cekStatusAbsen($date, $materi)
    {
        $current = strtotime(date("d-m-Y")); //tanggal hari ini dalam format timestamp
        $date = strtotime($date); //ubah tanggal pertemuan menajdi timestamp
        $datediff = $date - $current; //selisih tanggal dalam detik
        $difference = floor($datediff / (60 * 60 * 24)); //ubah selisih menjadi hari

        if ($difference < 0 && empty($materi)) {
            return 'Tidak Absen'; //pertemuan sudah lewat, tetapi materi kosong
        } elseif ($difference > 0 && empty($materi)) {
            return 'Belum Waktunya'; // pertemuan belum terjadi, materi kosong
        } elseif ($difference < 0 && !empty($materi)) {
            return 'Sudah Absen'; // pertemuan sudah lewat, materi ada
        } elseif ($difference == 0 && !empty($materi)) {
            return 'Sudah Absen hi'; // pertemuan hari ini, materi ada
        } elseif ($difference == 0 && empty($materi)) {
            return 'Silahkan Absen Sekarang';
        }
    }

    public function gaji_saya(Request $request)
    {
        $data  = gajiUtama::with('history_gaji')->first();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }
        // dd($gaji);
        return view('pages.pembayaran.gaji', compact('data'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
