<?php

namespace App\Http\Controllers;

use App\Models\indexPendaftaran;
use App\Models\Kategori;
use App\Models\kelas;
use Illuminate\Http\Request;

class IndexPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = indexPendaftaran::with('kategori')->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.administrasi.pendaftaran');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = kelas::all();
        $kategori  = Kategori::all();
        return view('pages.administrasi.pendaftaran.pendaftaran_create', compact('kelas', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'kelas_id' => 'required',
            'kategori_id' => 'required',
            'link_group' => 'nullable',
            'tanggal_p_awal' => 'nullable',
            'tanggal_p_akhir' => 'nullable',
            'status_pendaftaran' => 'required',
        ]);

        $kategori = Kategori::find($request->kategori_id);
        $kategori = $kategori->kategori_kelas;
        $validated['link_form'] = 'register' . '/' . $kategori . '/' . $validated['kategori_id'] . $validated['kelas_id'];
        $validated['code'] = $validated['kategori_id'] . $validated['kelas_id'];

        indexPendaftaran::create($validated);
        return redirect()->route('pendaftaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(indexPendaftaran $indexPendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(indexPendaftaran $indexPendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, indexPendaftaran $indexPendaftaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(indexPendaftaran $indexPendaftaran)
    {
        //
    }
}
