<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\programbelajar;
use App\Models\Tipekelas;
use Illuminate\Http\Request;

class programbelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = programbelajar::join('tipe_kelas','tipe_kelas.id', 'program_belajar.jenis_kelas_id')
        ->select('program_belajar.*','tipe_kelas.*')->get();

        $options_form = Tipekelas::all();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.program_belajar.program_belajar', compact('data', 'options_form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'nama_program' => 'required',
        //     'harga' => 'required',
        //     'deskripsi' => 'required',
        //     'level' => 'required',
        //     'jenis_kelas_id' => 'required',
        //     'mekanik' => 'required',
        //     'elektronik' => 'required',
        //     'pemrograman' => 'required',
        // ]);
        programbelajar::create([
            'nama_program' => $request->nama_program,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'level' => $request->level,
            'Jenis_kelas_id' => $request->jenis_kelas,
            'mekanik' => $request->mekanik,
            'elektronik' => $request->elektronik,
            'pemrograman' => $request->pemrograman,
        ]);
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
