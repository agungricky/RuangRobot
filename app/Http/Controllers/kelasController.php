<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\muridKelas;
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
            'harga_kelas.required' => 'Harga harus diisi.',
            'mulai.required' => 'Tanggal Mulai harus diisi.',
            'selesai.required' => 'Tanggal Selesai harus diisi.',
            'nama_program.required' => 'Program Belajar harus diisi.',
            'nama_program.exists' => 'Program Belajar tidak ada di database.',
            'kategori_kelas.required' => 'Kategori Kelas harus diisi.',
            'penanggung_jawab.required' => 'Penanggung Jawab harus diisi.',
            'penanggung_jawab.exists' => 'Penanggung Jawab tidak ada di database.',
            'gaji_pengajar.required' => 'Gaji Pengajar harus diisi.',
            'gaji_transport.required' => 'Gaji Transport harus diisi.',
            'status_kelas.required' => 'Status Kelas harus diisi.',
            'jatuh_tempo.required' => 'Jatuh Tempo harus diisi.',
        ];

        $request->validate([
            'nama_kelas' => 'required',
            'harga_kelas' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'nama_program' => 'required|exists:program_belajar,id',
            'kategori_kelas' => 'required',
            'penanggung_jawab' => 'required|exists:profile,nama',
            'gaji_pengajar' => 'required',
            'gaji_transport' => 'required',
            'status_kelas' => 'required',
            'jatuh_tempo' => 'required',
        ], $message);

        $durasi_belajar = $request->mulai . '-' . $request->selesai;

        $kelas = kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'harga' => $request->harga_kelas,
            'durasi_belajar' => $durasi_belajar,
            'program_belajar_id' => $request->nama_program,
            'kategori_kelas_id' => $request->kategori_kelas,
            'penanggung_jawab' => $request->penanggung_jawab,
            'gaji_pengajar' => $request->gaji_pengajar,
            'gaji_transport' => $request->gaji_transport,
            'status_kelas' => $request->status_kelas,
            'jatuh_tempo' => $request->jatuh_tempo,
        ]);

        muridKelas::create([
            'kelas_id' => $kelas->id,
            'murid' => json_encode(new \stdClass()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = kelas::join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
        ->join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
        ->select('kelas.*', 'kategori_kelas.kategori_kelas', 'program_belajar.nama_program', 'program_belajar.level', 'program_belajar.mekanik', 'program_belajar.elektronik', 'program_belajar.pemrograman')
        ->where('kelas.id', $id)->first();

        // dd($data);

        $jp = pembelajaran::where('id', $id)->count();

        return view('pages.kelas.detail_kelas', compact('data', 'jp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = kelas::join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
        ->join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
        ->select('kelas.*', 'program_belajar.nama_program', 'kategori_kelas.kategori_kelas')
        ->where('kelas.id', $id)
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
            'jatuh_tempo.required' => 'Jatuh Tempo harus diisi.',
            'harga_kelas.required' => 'Harga Kelas harus diisi.',
            'programId' => 'data tidak ada di database',
        ];

        $request->validate([
            'nama_kelas' => 'required',
            'durasi_belajar' => 'required',
            'programId' => 'required|exists:program_belajar,id',
            'kategori_kelas' => 'required',
            'penanggung_jawab' => 'required|exists:profile,nama',
            'gaji_pengajar' => 'required',
            'gaji_transport' => 'required',
            'status_kelas' => 'required',
            'jatuh_tempo' => 'required',
            'harga_kelas' => 'required',
        ], $message);

        // dd($request);
        kelas::where('id', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'durasi_belajar' => $request->durasi_belajar,
            'program_belajar_id' => $request->programId,
            'kategori_kelas_id' => $request->kategori_kelas,
            'penanggung_jawab' => $request->penanggung_jawab,
            'gaji_pengajar' => $request->gaji_pengajar,
            'gaji_transport' => $request->gaji_transport,
            'status_kelas' => $request->status_kelas,
            'jatuh_tempo' => $request->jatuh_tempo,
        ]);

        return redirect('kelas')->with('success', 'Data Kelas Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        muridKelas::where('kelas_id', $id)->delete();
        kelas::where('id', $id)->delete();
        return redirect('kelas')->with('success', 'Data Kelas Berhasil Dihapus');
    }
}
