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
        ->select('program_belajar.*','tipe_kelas.nama_kategori')->get();

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
        $message = [
            'nama_program.required' => 'Nama program wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'level.required' => 'Level wajib diisi.',
            'mekanik.required' => 'Mekanik wajib diisi.',
            'elektronik.required' => 'Elektronik wajib diisi.',
            'pemrograman.required' => 'Pemrograman wajib diisi.',
        ];

        $request->validate([
            'nama_program' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'level' => 'required',
            'mekanik' => 'required',
            'elektronik' => 'required',
            'pemrograman' => 'required',
        ], $message);

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
        $data = programbelajar::where('id', $id)->first();
        $options = Kategori::all();
        $level = programbelajar::all(); 

        return view('pages.program_belajar.edit_programbelajar',compact('data','options','level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $message = [
        //     'nama_program.required' => 'Nama Program harus diisi.',
        //     'nama_program.unique' => 'Sekolah sudah ada.',
        //     'harga' => 'Harga harus diisi.',
        //     'deskripsi' => 'Deskripsi harus diisi.',
        //     'level' => 'Level harus diisi.',
        //     'jenis_kelas_id' => 'Jenis kelas harus diisi.',
        //     'mekanik' => 'Mekanik harus diisi.',
        //     'elektronik' => 'Elektronik harus diisi.',
        //     'pemrograman' => 'Pemrograman harus diisi.',
        // ];

        // $request->validate([
        //     'nama_program' => 'required.',
        //     'nama_program' => 'required.',
        //     'harga' => 'required.',
        //     'deskripsi' => 'required.',
        //     'level' => 'required.',
        //     'jenis_kelas_id' => 'required.',
        //     'mekanik' => 'required.',
        //     'elektronik' => 'required.',
        //     'pemrograman' => 'required.',
        // ], $message);
        //update data program belajar
        programbelajar::where('id',$id)->update([
            'nama_program' => $request->nama_program,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'level' => $request->level,
            // 'Jenis_kelas_id' => $request->Jenis_kelas_id,
            'mekanik' => $request->mekanik,
            'elektronik' => $request->elektronik,
            'pemrograman' => $request->pemrograman,
        ]);
        return redirect('program_belajar')->with('success','Data berhasil diperbarui');
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    //    programbelajar::find($id)->delete(); // AKU INGIN BERTANYA DIBAGIAN INI SAYANG, IKI PIE KOK WAYAH IKI GAK KENEK
        programbelajar::where('id', $id)->delete(); // TP LEK CARANE NGENE KENEK

        // dd($p);
        return redirect('program_belajar')->with('success', 'Data Berhasil dihapus');
    }
}
