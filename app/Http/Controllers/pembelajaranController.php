<?php

namespace App\Http\Controllers;

use App\Models\pembelajaran;
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
                'pertemuan' => $i+1,
                'pengajar' => '',
                'tanggal' => null,
                'materi' => '',
                'catatan_pengajar' => '',
                'absensi' => '{}',
                'status_tersimpan' => 'sementara',
                'kelas_id' => $id_kelas,
                'murid_kelas_id' => '',
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
