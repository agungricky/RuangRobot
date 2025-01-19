<?php

namespace App\Http\Controllers;

use App\Models\sekolah;
use Illuminate\Http\Request;

class sekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = sekolah::all();
        // dd($data);
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.sekolah.sekolah', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'nama_sekolah.required' => 'Nama Sekolah harus diisi.',
            'guru.required' => 'Guru harus diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Masukan yang diharapkan Format +628xxxxxxxxxx.',
        ];

        $request->validate([
            'nama_sekolah' => 'required',
            'guru' => 'required',
            'no_hp' => ['required', 'regex:/^\+62[0-9]{9,}$/'],
        ], $message);

        sekolah::create([
            'nama_sekolah' => $request->nama_sekolah,
            'guru' => $request->guru,
            'no_hp' => $request->no_hp,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = sekolah::where('id', $id)->first();
        // dd($data);
        return view('pages.sekolah.edit_sekolah', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = [
            'nama_sekolah.required' => 'Nama Sekolah harus diisi.',
            'nama_sekolah.unique' => 'Sekolah sudah ada.',
            'guru.required' => 'Guru harus diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Masukan yang diharapkan Format +628xxxxxxxxxx.',
        ];
        
        $request->validate([
            'nama_sekolah' => 'required|unique:sekolah,nama_sekolah,' . $id . ',id',
            'guru' => 'required',
            'no_hp' => ['required', 'regex:/^\+62[0-9]{9,}$/'],
        ], $message);
        
        // Update data sekolah
        sekolah::where('id', $id)->update([
            'nama_sekolah' => $request->nama_sekolah,
            'guru' => $request->guru,
            'no_hp' => $request->no_hp,
        ]);
        

        return redirect('sekolah')->with('success', 'Data Berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        sekolah::find($id)->delete();
        return redirect('sekolah')->with('success', 'Data Berhasil dihapus');
    }
}
