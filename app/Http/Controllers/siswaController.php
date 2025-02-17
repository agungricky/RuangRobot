<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\pengguna;
use Illuminate\Http\Request;

class siswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $data = pengguna::where('id', $id)->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $kelas_diikuti = json_decode($data->kelas_diikuti, true);
        $id_kelas_array = array_column($kelas_diikuti, 'id_kelas');

        $kelas = kelas::whereIn('kelas.id', $id_kelas_array)
        ->where('kelas.status_kelas', 'Aktif')
        ->join('program_belajar', 'kelas.program_belajar_id', 'program_belajar.id')
        ->get();

        $kelas_selesai = kelas::whereIn('kelas.id', $id_kelas_array)
        ->where('kelas.status_kelas', 'Selesai')
        ->join('program_belajar', 'kelas.program_belajar_id', 'program_belajar.id')
        ->get();

        if ($request->ajax()) {
            return response()->json([
                'kelas' => $kelas,
                'kelas_selesai' => $kelas_selesai,
            ]);
        }

        return view('pages.kelas.siswa.kelas', compact('id'));
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
