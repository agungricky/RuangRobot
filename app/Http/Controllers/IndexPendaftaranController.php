<?php

namespace App\Http\Controllers;

use App\Models\indexPendaftaran;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'kategori_id' => 'required',
            'link_group' => 'nullable',
            'tanggal_p_awal' => 'nullable',
            'tanggal_p_akhir' => 'nullable',
            'status_pendaftaran' => 'required',
        ]);

        $kategori = Kategori::find($request->kategori_id);
        $kategori = $kategori->kategori_kelas;

        $code = strtoupper(Str::random(10));
        $validated['link_form'] = 'register' . '/' . $kategori . '/' . $code;
        $validated['code'] = $code;

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
    public function edit(String $pendaftaran)
    {
        $indexPendaftaran = indexPendaftaran::findOrfail($pendaftaran);
        return view('pages.administrasi.pendaftaran.pendaftaran_edit', compact('indexPendaftaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, indexPendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'title' => 'required',
            'kategori_id' => 'required',
            'link_group' => 'nullable',
            'tanggal_p_awal' => 'nullable',
            'tanggal_p_akhir' => 'nullable',
            'status_pendaftaran' => 'required',
        ]);

        $kategori = Kategori::findOrfail($validated['kategori_id']);
        $validated['link_form'] = 'register' . '/' . $kategori->kategori_kelas . '/' . $pendaftaran->code;

        indexPendaftaran::where('id', $pendaftaran->id)->update($validated);
        return redirect()->route('pendaftaran.index')->with('success', 'Data Berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        indexPendaftaran::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Index Pendaftaran Berhasil di Hapus');
    }
}
