<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use Illuminate\Http\Request;

class pembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data = pembelajaran::where('kelas_id', $id)->get();
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

        // Tambahkan data baru
        $newSiswa = array_merge($existingSiswa, $validatedData['siswa']);

        // Simpan data yang diperbarui
        $kelas->murid = json_encode($newSiswa);
        $kelas->save();

        return response()->json(['message' => 'Data siswa berhasil ditambahkan!'], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
