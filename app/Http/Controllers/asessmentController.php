<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class asessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'kelas_id' => 'required|integer|exists:kelas,id',
            'idreport' => 'required|integer',

            'pemahaman' => 'required|in:A,A-,B+,B,B-',
            'keterampilan' => 'required|in:A,A-,B+,B,B-',
            'keamanan' => 'required|in:A,A-,B+,B,B-',
            'antusiasme' => 'required|in:A,A-,B+,B,B-',
            'percaya_diri' => 'required|in:A,A-,B+,B,B-',
        ]);

        $kelas = muridKelas::with('kelas')->where('kelas_id', $request->kelas_id)->first();
        $murid = json_decode($kelas->murid, true);
        $muridId = $murid[0]['id'] ?? null;
        $murid = pengguna::where('id', $muridId)->first();
        

        $data = Assessment::create([
            'author_id' => Auth::user()->id,
            'kelas_id' => $request->kelas_id,
            'pemahaman' => $request->pemahaman,
            'keterampilan' => $request->keterampilan,
            'keamanan' => $request->keamanan,
            'antusiasme' => $request->antusiasme,
            'percaya_diri' => $request->percaya_diri,
            'idreport' => $request->idreport,
        ]);

        $response = Http::withHeaders([
                    'Authorization' => '6aESQEF3pHwm9HbAiZYA'
                ])->post('https://api.fonnte.com/send', [
                    'target' => $murid->no_telp,
                    'message' => "
📋 INFORMASI PENILAIAN SISWA

Halo 👋 $murid->nama,
Berikut kami sampaikan hasil assessment siswa selama mengikuti pembelajaran robotika :

Link Report : https://ruangrobot.com/asessment/$data->id

Pesan ini merupakan laporan assessment resmi dari Ruang Robot. 
Apabila terdapat pertanyaan atau kendala, silakan menghubungi Admin di +6281272455577.
"
                ]);

        // Simpan response untuk debug jika diperlukan
        $responses[] = $response->body();

        return redirect()
            ->back()
            ->with('success', 'Assessment berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Assessment::find($id);
        $kelas = muridKelas::with('kelas.program_belajar')->where('kelas_id', $data->kelas_id)->first();
        $murid = json_decode($kelas->murid, true);
        $muridId = $murid[0]['id'] ?? null;
        $murid = pengguna::where('id', $muridId)->first();
        $pengajar = pengguna::where('id', $data->author_id)->first();

        return view('asessment.index', compact('data', 'murid', 'kelas', 'pengajar'));
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
}
