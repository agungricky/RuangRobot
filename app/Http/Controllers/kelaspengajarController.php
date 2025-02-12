<?php

namespace App\Http\Controllers;

use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\programbelajar;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class kelaspengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function kelas_aktif(Request $request)
    {
        $kelas_aktif = kelas::where('kelas.status_kelas', 'aktif')
            ->join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
            ->join('tipe_kelas', 'tipe_kelas.id', 'program_belajar.tipe_kelas_id')
            ->select('kelas.id', 'kelas.nama_kelas', 'program_belajar.nama_program', 'tipe_kelas.tipe_kelas')
            ->get();

        if (request()->ajax()) {
            return response()->json([
                'data' => $kelas_aktif,
            ]);
        }

        return view('pages.kelas.pengajar.kelas_pengajar_aktif');
    }

    public function kelas_selesai(Request $request)
    {
        $kelas_selesai = kelas::where('kelas.status_kelas', 'selesai')
            ->join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
            ->join('tipe_kelas', 'tipe_kelas.id', 'program_belajar.tipe_kelas_id')
            ->select('kelas.id', 'kelas.nama_kelas', 'program_belajar.nama_program', 'tipe_kelas.tipe_kelas')
            ->get();

        if (request()->ajax()) {
            return response()->json([
                'data' => $kelas_selesai,
            ]);
        }

        return view('pages.kelas.pengajar.kelas_pengajar_selesai');
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
        $kelas = Kelas::where('kelas.id', $id)
            ->join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
            ->join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
            ->select('kelas.id', 'kelas.nama_kelas', 'kelas.gaji_pengajar', 'kelas.gaji_transport', 'kelas.penanggung_jawab', 'program_belajar.nama_program', 'program_belajar.level', 'program_belajar.mekanik', 'program_belajar.elektronik', 'program_belajar.pemrograman', 'kategori_kelas.kategori_kelas')
            ->first();

        $jumlah_pertemuan = pembelajaran::where('kelas_id', $id)->count();

        $pembelajaran = pembelajaran::where('pembelajaran.kelas_id', $id)
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('pembelajaran.*', 'kelas.durasi_belajar')
            ->orderBy('pertemuan', 'asc')
            ->get();

        $daftar_siswa = muridKelas::where('murid_kelas.kelas_id', $id)->first();
        $daftar_siswa = json_decode($daftar_siswa->murid);

        $kehadiran = [];
        $totalPertemuan = $pembelajaran->count();

        foreach ($pembelajaran as $pertemuan) {
            $absensi = json_decode($pertemuan->absensi, true);

            foreach ($absensi as $siswa) {
                $id = $siswa['id'];
                $nama = $siswa['nama'];
                $presensi = $siswa['presensi'];

                if (!isset($kehadiran[$id])) {
                    $kehadiran[$id] = [
                        'nama' => $nama,
                        'hadir' => 0,
                        'total' => $totalPertemuan,
                        'persentase' => 0
                    ];
                }

                if ($presensi === 'H') {
                    $kehadiran[$id]['hadir']++;
                }
            }
        }

        // Hitung persentase kehadiran
        foreach ($kehadiran as &$siswa) {
            $siswa['persentase'] = ($siswa['hadir'] / $siswa['total']) * 100;
        }

        foreach ($daftar_siswa as &$siswa) {
            $id = $siswa->id;
            $siswa->persentase = isset($kehadiran[$id]) ? $kehadiran[$id]['persentase'] : 0;
        }        
        // dd($kelas);
        return view('pages.kelas.pengajar.detail_kelas_pengajar', compact('kelas', 'jumlah_pertemuan', 'pembelajaran', 'daftar_siswa'));
    }

    public function detail_absensi(Request $request, $id){
        $absen = pembelajaran::where('id', $id)->first();
        $siswa = json_decode($absen->absensi);

        return response()->json([
            'data' => $siswa,
            'absen' => $absen
        ]);
    }

    public function pengajar_bantu(Request $request, $id){
        try {
            gajiUtama::create([
                'pengajar' => $request->pengajar,
                'nominal' => $request->gaji_pengajar,
                'status' => $request->status_pembayaran,
                'status_pengajar' => $request->status_pengajar,
                'pembelajaran_id' => $id,
            ]);
    
            if($request->gaji_transport != 0){
                gajiTransport::create([
                    'pengajar' => $request->pengajar,
                    'nominal' => $request->gaji_transport,
                    'status' => $request->status_pembayaran,
                    'status_pengajar' => $request->status_pengajar,
                    'pembelajaran_id' => $id,
                ]);
            }

            return response()->json(['message' => 'Gaji Mengajar dan Gaji Transport Berhasil di Tambahkan di akunmu'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
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
