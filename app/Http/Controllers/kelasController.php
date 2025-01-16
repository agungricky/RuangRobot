<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\pengguna;
use App\Models\programbelajar;
use Illuminate\Http\Request;

class kelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = kelas::all();
        $kategori = Kategori::all();  

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.kelas.kelas', compact('data', 'kategori'));
    }

    public function program_belajar()
    {
        $program_belajar = programbelajar::select('id', 'nama_program')->get();
        return response()->json(['data' => $program_belajar]);
    }

    public function pengajar()
    {
        $program_belajar = pengguna::where('akun.role', 'pengajar')
        ->join('akun', 'akun.id', '=', 'profile.id')
        ->select('profile.id', 'profile.nama', 'akun.role')->get();
        return response()->json(['data' => $program_belajar]);
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
