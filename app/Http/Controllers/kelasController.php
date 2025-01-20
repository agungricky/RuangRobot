<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\pembelajaran;
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
        $data = kelas::join('kategori_kelas', 'kategori_kelas.id', '=', 'kelas.kategori_kelas_id')
        ->select('kelas.*', 'kategori_kelas.kategori_kelas')
        ->get();
        $kategori = Kategori::all(); 
        $programbelajar = programbelajar::all(); 
        // dd($kategori);
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.kelas.kelas', compact('data','kategori','programbelajar'));
    }

    public function program_belajar()
    {
        $program_belajar = programbelajar::select('id', 'nama_program')->get();
        return response()->json(['data' => $program_belajar]);
    }

    public function pengajar()
    {
        $pengajar = pengguna::where('akun.role', 'pengajar')
        ->join('akun', 'akun.id', '=', 'profile.id')
        ->select('profile.id', 'profile.nama', 'akun.role')->get();
        return response()->json(['data' => $pengajar]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'penanggung_jawab.required' => 'Penanggung Jawab harus diisi.',
            'mulai.required' => 'Tanggal Mulai harus diisi.',
            'selesai.required' => 'Tanggal Selesai harus diisi.',
            'program_id.required' => 'Program Belajar harus diisi.',
            'jenis_kelas.required' => 'Jenis Kelas harus diisi.',
            'gaji_pengajar.required' => 'Gaji Pengajar harus diisi.',
            'gaji_transport.required' => 'Gaji Transport harus diisi.',
            'status_kelas.required' => 'Status Kelas harus diisi.',
        ];

        $request->validate([
            'nama_kelas' => 'required',
            'penanggung_jawab' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'program_id' => 'required',
            'jenis_kelas' => 'required',
            'gaji_pengajar' => 'required',
            'gaji_transport' => 'required',
            'status_kelas' => 'required',
        ], $message);

        $durasi_belajar = $request->mulai . '-' . $request->selesai;

        kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'durasi_belajar' => $durasi_belajar,
            'program_belajar_id' => $request->program_id,
            'jenis_kelas_id' => $request->jenis_kelas,
            'penanggung_jawab' => $request->penanggung_jawab,
            'gaji_pengajar' => $request->gaji_pengajar,
            'gaji_transport' => $request->gaji_transport,
            'status_kelas' => $request->status_kelas,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = kelas::join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
        ->join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
        ->where('kelas.id', $id)->first();

        $jp = pembelajaran::where('id', $id)->count();

        // dd($data);
        return view('pages.kelas.detail_kelas', compact('data', 'jp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = kelas::where('kelas.id', $id)
        ->join('program_belajar', 'program_belajar.id', '=', 'kelas.program_belajar_id')
        ->join('jenis_kelas', 'jenis_kelas.id', '=', 'kelas.jenis_kelas_id')
        ->select('kelas.*', 'program_belajar.nama_program', 'jenis_kelas.jenis_kelas')
        ->first();

        $kategori = Kategori::all();
        // dd($data);
        return view('pages.kelas.edit_kelas', compact('data', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = [
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'durasi_belajar.required' => 'Durasi Belajar harus diisi.',
            'program_belajar.required' => 'Program Belajar harus diisi.',
            'jenis_kelas.required' => 'Jenis Kelas harus diisi.',
            'penanggung_jawab.required' => 'Penanggung Jawab harus diisi.',
            'gaji_pengajar.required' => 'Gaji Pengajar harus diisi.',
            'gaji_transport.required' => 'Gaji Transport harus diisi.',
            'status_kelas.required' => 'Status Kelas harus diisi.',
        ];

        $request->validate([
            'nama_kelas' => 'required',
            'durasi_belajar' => 'required',
            'program_belajar' => 'required',
            'jenis_kelas' => 'required',
            'penanggung_jawab' => 'required',
            'gaji_pengajar' => 'required',
            'gaji_transport' => 'required',
            'status_kelas' => 'required',
        ], $message);

        // dd($request);
        kelas::where('id', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'durasi_belajar' => $request->durasi_belajar,
            'program_belajar_id' => $request->programId,
            'jenis_kelas_id' => $request->jenis_kelas,
            'penanggung_jawab' => $request->penanggung_jawab,
            'gaji_pengajar' => $request->gaji_pengajar,
            'gaji_transport' => $request->gaji_transport,
            'status_kelas' => $request->status_kelas,
        ]);

        return redirect('kelas')->with('success', 'Data Kelas Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
