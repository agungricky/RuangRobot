<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\programbelajar;
use App\Models\Tipekelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class programbelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = programbelajar::join('tipe_kelas', 'tipe_kelas.id', 'program_belajar.tipe_kelas_id')
            ->select('program_belajar.*', 'tipe_kelas.tipe_kelas')->get();

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
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'level.required' => 'Level wajib diisi.',
            'mekanik.required' => 'Mekanik wajib diisi.',
            'elektronik.required' => 'Elektronik wajib diisi.',
            'pemrograman.required' => 'Pemrograman wajib diisi.',
        ];

        $request->validate([
            'nama_program' => 'required',
            'deskripsi' => 'required',
            'level' => 'required',
            'mekanik' => 'required',
            'elektronik' => 'required',
            'pemrograman' => 'required',
        ], $message);

        programbelajar::create([
            'nama_program' => $request->nama_program,
            'deskripsi' => $request->deskripsi,
            'level' => $request->level,
            'tipe_kelas_id' => $request->tipe_kelas,
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
        $data = programbelajar::join('tipe_kelas', 'tipe_kelas.id', 'program_belajar.tipe_kelas_id')
            ->where('program_belajar.id', $id)
            ->select('program_belajar.*', 'tipe_kelas.tipe_kelas')
            ->first();
        $tipe_kelas = Tipekelas::all();

        return view('pages.program_belajar.edit_programbelajar', compact('data', 'tipe_kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = [
            'nama_program.required' => 'Nama Program harus diisi.',
            'nama_program.unique' => 'Nama program sudah ada coba buat yag lain.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'level.required' => 'Level harus diisi.',
            'tipe_kelas_id.required' => 'Tipe kelas harus diisi.',
            'mekanik.required' => 'Mekanik harus diisi.',
            'elektronik.required' => 'Elektronik harus diisi.',
            'pemrograman.required' => 'Pemrograman harus diisi.',
        ];

        $request->validate([
            'nama_program' => 'required|string|unique:program_belajar,nama_program,' . $id,
            'deskripsi' => 'required',
            'level' => 'required',
            'tipe_kelas_id' => 'required',
            'mekanik' => 'required',
            'elektronik' => 'required',
            'pemrograman' => 'required',
        ], $message);

        programbelajar::where('id', $id)->update([
            'nama_program' => $request->nama_program,
            'deskripsi' => $request->deskripsi,
            'level' => $request->level,
            'tipe_kelas_id' => $request->tipe_kelas_id,
            'mekanik' => $request->mekanik,
            'elektronik' => $request->elektronik,
            'pemrograman' => $request->pemrograman,
        ]);

        return redirect('program_belajar')->with('success', 'Data berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        programbelajar::where('id', $id)->delete();

        return redirect('program_belajar')->with('success', 'Data Berhasil dihapus');
    }
}
