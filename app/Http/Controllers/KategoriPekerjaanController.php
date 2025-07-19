<?php

namespace App\Http\Controllers;

use App\Models\kategori_pekerjaan;
use Illuminate\Http\Request;

class KategoriPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = kategori_pekerjaan::all();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }
        return view('pages.kategory.kategori_pekerjaan');
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
        $validated = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'keterangan'     => 'nullable|string|max:1000',
            'gaji'           => 'required|numeric|min:0',
        ]);

        kategori_pekerjaan::create($validated);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(kategori_pekerjaan $kategori_pekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kategori_pekerjaan $kategori_pekerjaan)
    {
        return view('pages.kategory.edit_kategori_pekerjaan', compact('kategori_pekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kategori_pekerjaan $kategori_pekerjaan)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'keterangan'     => 'nullable|string|max:1000',
            'gaji'           => 'required|numeric|min:0',
        ]);

        kategori_pekerjaan::where('id', $kategori_pekerjaan->id)->update($validated);
        return redirect()->route('kategori_pekerjaan.index')->with('success', 'Berhasil Update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kategori_pekerjaan $kategori_pekerjaan)
    {
        kategori_pekerjaan::where('id', $kategori_pekerjaan->id)->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }
}
