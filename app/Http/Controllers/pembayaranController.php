<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\kelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;

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
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data_murid = kelas::where('id', $id)->first();
        kelas::where('id', $id)->update([
            'status_kelas' => 1
        ]);
        // $muridArray = json_decode($jm->murid, true);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
