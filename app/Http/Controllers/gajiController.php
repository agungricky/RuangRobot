<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\gajiCustom;
use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\historigaji;
use App\Models\pengguna;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class gajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = akun::where('role', 'Pengajar')
            ->join('profile', 'profile.id', 'akun.id')
            ->get();

        foreach ($data as $value) {
            $gaji = gajiUtama::where('pengajar', $value->id)
                ->where('gajis.status', 'pending')
                ->sum('nominal');

            $gaji_transport = gajiTransport::where('pengajar', $value->id)
                ->where('transport.status', 'pending')
                ->sum('nominal');

            $gaji_custom = gajiCustom::where('pengajar', $value->id)
                ->where('gaji_custom.status', 'pending')
                ->sum('nominal');

            $gaji_pengajar[] = [
                'id' => $value->id,
                'nama' => $value->nama,
                'gaji_mengajar' => $gaji,
                'gaji_transport' => $gaji_transport,
                'gaji_custom' => $gaji_custom,
                'total' => $gaji + $gaji_transport + $gaji_custom
            ];
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'total_gaji' => $gaji_pengajar,
            ]);
        }

        // dd($data);
        return view('pages.gaji.gaji', compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = pengguna::where('id', $id)->first();
        $gaji = gajiUtama::where('gajis.pengajar', $id)
            ->where('gajis.status', '!=', 'dibayar')
            ->join('profile', 'profile.id', 'gajis.pengajar')
            ->join('pembelajaran', 'pembelajaran.id', 'gajis.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('gajis.*', 'profile.nama', 'pembelajaran.pertemuan', 'pembelajaran.tanggal', 'kelas.nama_kelas')
            ->get();

        $transport = gajiTransport::where('transport.pengajar', $id)
            ->where('transport.status', '!=', 'dibayar')
            ->join('profile', 'profile.id', 'transport.pengajar')
            ->join('pembelajaran', 'pembelajaran.id', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('transport.*', 'profile.nama', 'pembelajaran.pertemuan', 'pembelajaran.tanggal', 'kelas.nama_kelas')
            ->get();

        $custom = gajiCustom::where('gaji_custom.pengajar', $id)
            ->where('gaji_custom.status', '!=', 'dibayar')
            ->join('profile', 'profile.id', 'gaji_custom.pengajar')
            ->select('gaji_custom.*', 'profile.nama')
            ->get();

        // ================================================== //
        // ================== Gaji Diterima ================= //
        // ================================================== //
        $total_gaji = gajiUtama::where('pengajar', $data->id)
            ->where('gajis.status', 'diverifikasi')
            ->sum('nominal');

        $total_gajitransport = gajiTransport::where('pengajar', $data->id)
            ->where('transport.status', 'diverifikasi')
            ->sum('nominal');

        $total_gajicustom = gajiCustom::where('pengajar', $data->id)
            ->where('gaji_custom.status', 'diverifikasi')
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];

        // ================================================== //
        // ================== Gaji Ditolak ================= //
        // ================================================== //
        $gaji_ditolak = gajiUtama::where('pengajar', $data->id)
            ->where('gajis.status', 'ditolak')
            ->sum('nominal');

        $transport_ditolak = gajiTransport::where('pengajar', $data->id)
            ->where('transport.status', 'ditolak')
            ->sum('nominal');

        $custom_ditolak = gajiCustom::where('pengajar', $data->id)
            ->where('gaji_custom.status', 'ditolak')
            ->sum('nominal');

        $gaji_ditolak = [
            'gaji_mengajar' => $gaji_ditolak,
            'gaji_transport' => $transport_ditolak,
            'gaji_custom' => $custom_ditolak,
            'total' => $gaji_ditolak + $transport_ditolak + $custom_ditolak
        ];
        // dd($gaji_pengajar);
        return view('pages.gaji.detail_gaji', compact('data', 'gaji', 'transport', 'custom', 'gaji_pengajar', 'gaji_ditolak'));
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
    public function gaji_utama(Request $request, string $id)
    {
        gajiUtama::where('id', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    public function gaji_transport(Request $request, string $id)
    {
        gajiTransport::where('id', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    public function gaji_custom(Request $request, string $id)
    {
        gajiCustom::where('id', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    public function gaji_terbayar(Request $request, string $id)
    {
        $gaji = gajiUtama::where('pengajar', $id)
            ->where('status', 'diverifikasi')
            ->Orwhere('status', 'ditolak')
            ->get()->toArray();

        $transport = gajiTransport::where('pengajar', $id)
            ->Orwhere('status', 'ditolak')
            ->where('status', 'diverifikasi')->get()->toArray();

        $custom = gajiCustom::where('pengajar', $id)
            ->Orwhere('status', 'ditolak')
            ->where('status', 'diverifikasi')->get()->toArray();

        $histori = historigaji::whereDate('tanggal_terbayar', now()->toDateString())->first();

        if (!$histori) {
            $histori = historigaji::create([
                'tanggal_terbayar' => now(),
            ]);
        }

        foreach ($gaji as $key => $value) {
            gajiUtama::where('id', $value['id'])
                ->update([
                    'status' => $request->status,
                    'history_gaji_id' => $histori->id
                ]);
        }

        foreach ($transport as $key => $value) {
            gajiTransport::where('id', $value['id'])
                ->update([
                    'status' => $request->status,
                    'history_gaji_id' => $histori->id
                ]);
        }

        foreach ($custom as $key => $value) {
            gajiCustom::where('id', $value['id'])
                ->update([
                    'status' => $request->status,
                    'history_gaji_id' => $histori->id
                ]);
        }

        return back()->with('success', 'Data berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function verif_all($id)
    {
        $gaji = gajiUtama::where('status', 'pending')
        ->where('pengajar', $id)
        ->get();
        $transport = gajiTransport::where('status', 'pending')
        ->where('pengajar', $id)
        ->get();
        $custom = gajiCustom::where('status', 'pending')
        ->where('pengajar', $id)
        ->get();

        foreach ($gaji as $item) {
            $item->update(['status' => 'diverifikasi']);
        }

        foreach ($transport as $item) {
            $item->update(['status' => 'diverifikasi']);
        }

        foreach ($custom as $item) {
            $item->update(['status' => 'diverifikasi']);
        }

        return redirect()->back()->with('success', 'Semua data telah diverifikasi.');
    }


    public function historigaji(Request $request)
    {
        $data = historigaji::join('gajis', 'gajis.history_gaji_id', 'history_gaji.id')
            ->join('profile', 'profile.id', 'gajis.pengajar')
            ->select('profile.nama', 'history_gaji.tanggal_terbayar', 'gajis.pengajar', 'history_gaji.id')
            ->distinct()
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.gaji.histori_gaji');
    }

    public function detailhistori(String $pengajar_id, $tanggal_id)
    {
        $gaji = gajiUtama::join('history_gaji', 'history_gaji.id', 'gajis.history_gaji_id')
            ->join('profile', 'profile.id', 'gajis.pengajar')
            ->join('pembelajaran', 'pembelajaran.id', 'gajis.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->where('gajis.pengajar', $pengajar_id)
            ->where('gajis.history_gaji_id', $tanggal_id)
            ->select('gajis.pengajar', 'gajis.nominal', 'pembelajaran.pertemuan', 'gajis.status_pengajar', 'history_gaji.tanggal_terbayar', 'profile.nama', 'kelas.nama_kelas')
            ->get();

        $transport = gajiTransport::join('history_gaji', 'history_gaji.id', 'transport.history_gaji_id')
            ->join('profile', 'profile.id', 'transport.pengajar')
            ->join('pembelajaran', 'pembelajaran.id', 'transport.pembelajaran_id')
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->where('transport.pengajar', $pengajar_id)
            ->where('transport.history_gaji_id', $tanggal_id)
            ->select('transport.pengajar', 'transport.nominal', 'pembelajaran.pertemuan', 'transport.status_pengajar', 'history_gaji.tanggal_terbayar', 'profile.nama', 'kelas.nama_kelas')
            ->get();

        $custom = gajiCustom::join('history_gaji', 'history_gaji.id', 'gaji_custom.history_gaji_id')
            ->join('profile', 'profile.id', 'gaji_custom.pengajar')
            ->select('history_gaji.tanggal_terbayar', 'gaji_custom.keterangan', 'gaji_custom.nominal', 'gaji_custom.tanggal', 'profile.nama')
            ->get();

        // ================================================== //
        // ================== Gaji Diterima ================= //
        // ================================================== //
        $total_gaji = gajiUtama::where('pengajar', $pengajar_id)
            ->where('gajis.history_gaji_id', $tanggal_id)
            ->where('gajis.status', 'dibayar')
            ->join('history_gaji', 'history_gaji.id', 'gajis.history_gaji_id')
            ->sum('nominal');

        $total_gajitransport = gajiTransport::where('pengajar',  $pengajar_id)
            ->where('transport.history_gaji_id', $tanggal_id)
            ->where('transport.status', 'dibayar')
            ->join('history_gaji', 'history_gaji.id', 'transport.history_gaji_id')
            ->sum('nominal');

        $total_gajicustom = gajiCustom::where('pengajar', $pengajar_id)
            ->where('gaji_custom.history_gaji_id', $tanggal_id)
            ->where('gaji_custom.status', 'dibayar')
            ->join('history_gaji', 'history_gaji.id', 'gaji_custom.history_gaji_id')
            ->sum('nominal');

        $gaji_pengajar = [
            'gaji_mengajar' => $total_gaji,
            'gaji_transport' => $total_gajitransport,
            'gaji_custom' => $total_gajicustom,
            'total' => $total_gaji + $total_gajitransport + $total_gajicustom
        ];

        // ================================================== //
        // ================== Gaji Ditolak ================= //
        // ================================================== //
        $total_gaji_ditolak = gajiUtama::where('pengajar', $pengajar_id)
            ->where('gajis.history_gaji_id', $tanggal_id)
            ->where('gajis.status', 'ditolak')
            ->orWhere('gajis.status', 'pending')
            ->join('history_gaji', 'history_gaji.id', 'gajis.history_gaji_id')
            ->sum('nominal');

        $total_gajitransport_ditolak = gajiTransport::where('pengajar',  $pengajar_id)
            ->where('transport.history_gaji_id', $tanggal_id)
            ->where('transport.status', 'ditolak')
            ->orWhere('transport.status', 'pending')
            ->join('history_gaji', 'history_gaji.id', 'transport.history_gaji_id')
            ->sum('nominal');

        $total_gajicustom_ditolak = gajiCustom::where('pengajar', $pengajar_id)
            ->where('gaji_custom.history_gaji_id', $tanggal_id)
            ->where('gaji_custom.status', 'ditolak')
            ->orWhere('gaji_custom.status', 'pending')
            ->join('history_gaji', 'history_gaji.id', 'gaji_custom.history_gaji_id')
            ->sum('nominal');

        $gaji_ditolak = [
            'gaji_mengajar_ditolak' => $total_gaji_ditolak,
            'gaji_transport_ditolak' => $total_gajitransport_ditolak,
            'gaji_custom_ditolak' => $total_gajicustom_ditolak,
            'total' => $total_gaji_ditolak + $total_gajitransport_ditolak + $total_gajicustom_ditolak
        ];

        // dd($total_gajicustom);
        return view('pages.gaji.detail_histori', compact('gaji', 'transport', 'custom', 'gaji_pengajar', 'gaji_ditolak'));
    }
}
