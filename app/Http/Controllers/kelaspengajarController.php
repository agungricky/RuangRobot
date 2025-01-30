<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\pembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kelaspengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Auth::id());
        $kelas = kelas::with(['program_belajar', 'kategori_kelas'])
            ->where('status_kelas', 'aktif')
            ->get();

        $kelas2 = kelas::with(['program_belajar', 'kategori_kelas'])
            ->where('status_kelas', 'selesai')
            ->get();
        // dd($kelas); 

        return view('pages.kelas.kelas_pengajar', compact('kelas', 'kelas2'));
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
        $kelas = Kelas::with('pembelajaran')->findOrFail($id); // Ambil kelas + pembelajaran terkait
        // dd($kelas);
        return view('pages.kelas.detail_kelas_pengajar', compact('kelas'));
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
