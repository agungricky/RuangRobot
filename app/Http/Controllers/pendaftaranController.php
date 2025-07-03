<?php

namespace App\Http\Controllers;

use App\Models\indexPendaftaran;
use App\Models\muridKelas;
use App\Models\pendaftaran;
use Illuminate\Http\Request;

class pendaftaranController extends Controller
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
        return view('pages.administrasi.validasi');
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
            'code_id' => 'required|string|max:100',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'no_telp' => 'required|string|max:15',
            'sekolah_id' => 'nullable|string|max:100',
            'kelas' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'kategori' => 'required|string',
        ]);

        if (isset($validated['kelas']) && !empty($validated['kelas'])) {
            $validated['kelas'] = strtoupper($validated['kelas']);
        }

        pendaftaran::create($validated);
        return redirect()->route('login')->with('success', 'Registrasi berhasil, Anda akan dihubungi oleh Admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $indexPendaftaran = indexPendaftaran::find($id);
        $data = pendaftaran::with('sekolah')->where('code_id', $indexPendaftaran->code)->get();
        $count = $data->count();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.administrasi.validasi.detail', compact('id', 'indexPendaftaran', 'count'));
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

    public function fix($code)
    {
        $dataIndex_form = indexPendaftaran::where('code', $code)->first();
        $dataPendaftar = pendaftaran::where('code_id', $code)->get();
        // dd($dataPendaftar->toArray());

        // $dataPendaftar = pendaftaran::with(['indexPendaftaran', 'indexPendaftaran.kelas'])->where('code_id', $code)
        //     ->get()
        //     ->map(function ($item) {
        //         return [
        //             'id' => $item->id,
        //             'nama' => $item->nama,
        //             'sekolah' => $item->sekolah->nama ?? '-',
        //             'nilai' => 'Belum Dinilai',
        //             'tagihan' => 300000,
        //             'no_sertiv' => null,
        //             'created_at' => $item->created_at,
        //             'updated_at' => $item->updated_at,
        //             // 'no_invoice' => generateNoInvoice($item), // kamu bisa bikin fungsi sendiri
        //             'pembayaran' => 0,
        //             'jatuh_tempo' => '2025-12-31', // bisa juga pakai Carbon nanti
        //             'status_sertiv' => 'Belum Terbit',
        //         ];
        //     })->toArray();

            // dd($dataPendaftar->toArray());

        $datamurid_kelas = muridKelas::where('kelas_id', $dataIndex_form->kelas_id)->first();


        if ($datamurid_kelas == null) {
            muridKelas::create([
                'murid' => [],
                'kelas_id' => $dataIndex_form->kelas_id,
            ]);
        } else {
            // $datamurid_kelas->update([
            //     'murid' => $dataPendaftar->toArray(),
            // ]);
        }
    }
}
