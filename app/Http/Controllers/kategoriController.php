<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Tipekelas;
use Illuminate\Http\Request;

class kategoriController extends Controller
{

    // ============================================= //
    // ************* TIPE KELAS ************** //
    // ============================================= //

    /**
     * Display a listing of the resource.
     */
    public function index_jeniskelas(Request $request)
    {
        $data = Kategori::all();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }
        return view('pages.kategory.kategori_kelas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_kategorikelas(Request $request)
    {
        $messages = [
            'required' => 'Wajib di isi',
            'unique' => 'Data sudah ada, mohon periksa kembali.',
            'max' => 'tidak boleh lebih dari 20 karakter'
        ];

        $request->validate([
            'kategori' => 'required|unique:kategori_kelas,kategori_kelas|max:20',
        ], $messages);

        Kategori::create([
            'kategori_kelas' => $request->kategori,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_kategorikelas(string $id)
    {
        $data = Kategori::where('id', $id)->first();
        return view('pages.kategory.edit_kategori_kelas', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update_kategorikelas(Request $request, string $id)
    {
        $messages = [
            'required' => 'Wajib di isi',
            'unique' => 'Data sudah ada, mohon periksa kembali.',
            'max' => 'tidak boleh lebih dari 20 karakter'
        ];

        $request->validate([
            'kategori' => 'required|unique:jenis_kelas,jenis_kelas,' . $id . ',id|max:20',
        ], $messages);

        Kategori::where('id', $id)->update([
            'jenis_kelas' => $request->kategori
        ]);

        return redirect('kategori_kelas')->with('success', 'Data Berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_kategoriKelas(string $id)
    {
        Kategori::find($id)->delete();
        return redirect('kategori_kelas')->with('success', 'Data Berhasil di Hapus');
    }


    // ============================================= //
    // ************* TIPE KELAS ************** //
    // ============================================= //

    public function index_tipekelas(Request $request)
    {
        $data = Tipekelas::all();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
            ]);
        }

        return view('pages.kategory.tipe_kelas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_tipekelas(Request $request)
    {
        $messages = [
            'required' => 'Wajib di isi',
            'unique' => 'Data sudah ada, mohon periksa kembali.',
            'max' => 'tidak boleh lebih dari 20 karakter'
        ];

        $request->validate([
            'kategori' => 'required|unique:tipe_kelas,nama_kategori|max:20',
        ], $messages);

        Tipekelas::create([
            'nama_kategori' => $request->kategori,
        ]);

        return redirect()->back()->with('success', 'Data Berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_tipekelas(string $id)
    {
        $data = Tipekelas::where('id', $id)->first();
        return view('pages.kategory.edit_tipe_kelas', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_tipekelas(Request $request, string $id)
    {
        $messages = [
            'required' => 'Wajib di isi',
            'unique' => 'Data sudah ada, mohon periksa kembali.',
            'max' => 'tidak boleh lebih dari 20 karakter'
        ];

        $request->validate([
            'kategori' => 'required|unique:tipe_kelas,nama_kategori,' . $id . ',id|max:20',
        ], $messages);

        Tipekelas::where('id', $id)->update([
            'nama_kategori' => $request->kategori
        ]);

        return redirect('tipe_kelas')->with('success', 'Data Berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_tipeKelas(string $id)
    {
        Tipekelas::find($id)->delete();
        return redirect('tipe_kelas')->with('success', 'Data Berhasil di Hapus');
    }
}
