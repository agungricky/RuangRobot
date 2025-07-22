<?php

namespace App\Http\Controllers;

use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Profiler\Profile;

class kelaspengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function kelas_aktif(Request $request, $id)
    {
        $kelas_aktif = kelas::with('program_belajar.tipe_kelas', 'kategori')
            ->where('kelas.status_kelas', 'aktif')
            ->where('kelas.kategori_kelas_id', $id)
            ->orderBy('kelas.id', 'desc')
            ->get();

        $data = Kategori::findOrfail($id);

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $kelas_aktif,
            ]);
        }

        return view('pages.kelas.pengajar.kelas_pengajar_aktif', compact('id', 'data'));
    }

    public function kelas_selesai(Request $request)
    {
        $data = kelas::with('program_belajar.tipe_kelas', 'kategori')->where('kelas.status_kelas', 'selesai')->get();

        if (request()->ajax()) {
            return response()->json([
                'data' => $data,
            ]);
        }

        return view('pages.kelas.pengajar.kelas_pengajar_selesai', compact('data'));
    }

    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = kelas::with('kategori', 'program_belajar.tipe_kelas', 'pengajar')->where('kelas.id', $id)->first();
        $jumlah_pertemuan = pembelajaran::where('kelas_id', $id)->count();

        // Mengambil Semua Siswa di Kelas
        $daftar_siswa = muridKelas::where('murid_kelas.kelas_id', $id)->first();
        $daftar_siswa = json_decode($daftar_siswa->murid);

        $pembelajaran = pembelajaran::with('kelas')->where('pembelajaran.kelas_id', $id)->get();
        $kehadiran = [];
        foreach ($pembelajaran as $pertemuan) {
            $absensi = json_decode($pertemuan->absensi, true);

            foreach ($absensi as $siswa) {
                $id = $siswa['id'];
                $nama = $siswa['nama'];
                $presensi = $siswa['presensi'];

                if (!isset($kehadiran[$id])) {
                    $kehadiran[$id] = [
                        'nama' => $nama,
                        'hadir' => 0,
                        'total' => $jumlah_pertemuan,
                        'persentase' => 0
                    ];
                }

                if ($presensi === 'H') {
                    $kehadiran[$id]['hadir']++;
                }
            }
        }

        // Hitung persentase kehadiran
        $data_siswa = [];
        foreach ($kehadiran as $id => $siswa) {
            $siswa['persentase'] = (int) round(($siswa['hadir'] / $siswa['total']) * 100);
            $data_siswa[$id] = $siswa;
        }

        $dataFix = [];
        foreach ($daftar_siswa as $item) {
            $id = $item->id;

            $dataFix[$id] = (object) [
                'id'         => $id,
                'nama'       => $item->nama,
                'nilai'       => $item->nilai,
                'kelas'      => $item->kelas,
                'sekolah'    => $item->sekolah,
                'hadir'      => isset($data_siswa[$id]) ? $data_siswa[$id]['hadir'] : 0,
                'total'      => isset($data_siswa[$id]) ? $data_siswa[$id]['total'] : 0,
                'persentase' => isset($data_siswa[$id]) ? (int) $data_siswa[$id]['persentase'] : 0,
            ];
        }

        return view('pages.kelas.pengajar.detail_kelas_pengajar', compact('kelas', 'jumlah_pertemuan', 'pembelajaran', 'dataFix'));
    }

    public function show_selesai(string $id)
    {
        $kelas = kelas::with('kategori', 'program_belajar.tipe_kelas', 'pengajar')->where('kelas.id', $id)->first();
        $jumlah_pertemuan = pembelajaran::where('kelas_id', $id)->where('pembelajaran.tanggal', '!=', null)->count();

        $pembelajaran = pembelajaran::with('kelas')
            ->where('pembelajaran.kelas_id', $id)
            ->where('pembelajaran.tanggal', '!=', null)
            ->get();

        // Mengambil Semua Siswa di Kelas
        $daftar_siswa = muridKelas::where('murid_kelas.kelas_id', $id)->first();
        $daftar_siswa = json_decode($daftar_siswa->murid);

        $kehadiran = [];
        foreach ($pembelajaran as $pertemuan) {
            $absensi = json_decode($pertemuan->absensi, true);

            foreach ($absensi as $siswa) {
                $id = $siswa['id'];
                $nama = $siswa['nama'];
                $presensi = $siswa['presensi'];

                if (!isset($kehadiran[$id])) {
                    $kehadiran[$id] = [
                        'nama' => $nama,
                        'hadir' => 0,
                        'total' => $jumlah_pertemuan,
                        'persentase' => 0
                    ];
                }

                if ($presensi === 'H') {
                    $kehadiran[$id]['hadir']++;
                }
            }
        }

        // Hitung persentase kehadiran
        $data_siswa = [];
        foreach ($kehadiran as $id => $siswa) {
            $siswa['persentase'] = (int) round(($siswa['hadir'] / $siswa['total']) * 100);
            $data_siswa[$id] = $siswa;
        }

        $dataFix = [];
        foreach ($daftar_siswa as $item) {
            $id = $item->id;

            $dataFix[$id] = (object) [
                'id'         => $id,
                'nama'       => $item->nama,
                'nilai'       => $item->nilai,
                'kelas'      => $item->kelas,
                'sekolah'    => $item->sekolah,
                'hadir'      => isset($data_siswa[$id]) ? $data_siswa[$id]['hadir'] : 0,
                'total'      => isset($data_siswa[$id]) ? $data_siswa[$id]['total'] : 0,
                'persentase' => isset($data_siswa[$id]) ? (int) $data_siswa[$id]['persentase'] : 0,
            ];
        }

        return view('pages.kelas.pengajar.detail_kelas_selesai', compact('kelas', 'jumlah_pertemuan', 'pembelajaran', 'dataFix'));
    }

    public function detail_absensi($id)
    {
        $absen = pembelajaran::with('pengajar')->where('id', $id)->first();
        $siswa = json_decode($absen->absensi);

        return response()->json([
            'data' => $siswa,
            'absen' => $absen
        ]);
    }

    public function pengajar_bantu(Request $request, $id)
    {
        try {
            $kelas = kelas::where('id', $request->id_kelas)->first();

            $program_belajar = programbelajar::where('id', $kelas->program_belajar_id)->first();
            pengguna::where('id', $request->pengajar)->increment('elektronik', $program_belajar->elektronik ?? 0);
            pengguna::where('id', $request->pengajar)->increment('mekanik', $program_belajar->mekanik ?? 0);
            pengguna::where('id', $request->pengajar)->increment('pemrograman', $program_belajar->pemrograman ?? 0);

            gajiUtama::create([
                'pengajar' => $request->pengajar,
                'nominal' => $request->gaji_pengajar,
                'status' => $request->status_pembayaran,
                'status_pengajar' => $request->status_pengajar,
                'pembelajaran_id' => $id,
            ]);

            if ($request->gaji_transport != 0) {
                gajiTransport::create([
                    'pengajar' => $request->pengajar,
                    'nominal' => $request->gaji_transport,
                    'status' => $request->status_pembayaran,
                    'status_pengajar' => $request->status_pengajar,
                    'pembelajaran_id' => $id,
                ]);
            }

            return response()->json(['message' => 'Gaji Mengajar dan Gaji Transport Berhasil di Tambahkan di akunmu'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function pengajarbantu_searchRiwayat($idPertemuan)
    {
        $dataLogin = Auth::user();
        $data = gajiUtama::where('pembelajaran_id', $idPertemuan)
            ->where('pengajar', $dataLogin->id)
            ->exists();

        return response()->json([
            'data' => $data,
        ]);
    }


    public function siswa_show($id)
    {
        $siswa = muridKelas::where('kelas_id', $id)->first();
        $siswa_kelas = json_decode($siswa->murid);
        return response()->json([
            'data' => $siswa_kelas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $message = [
            'pengajar.required' => 'Pengajar harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'materi.required' => 'Materi harus diisi',
            'absensi.required' => 'Absensi harus diisi',
            'status_tersimpan.required' => 'Status harus diisi',
        ];

        $request->validate([
            'pengajar'           => 'required',
            'tanggal'            => 'required',
            'materi'             => 'required',
            'absensi'            => 'required',
            'status_tersimpan'   => 'required',
        ], $message);

        try {
            pembelajaran::where('id', $id)->update([
                'pengajar' => $request->pengajar_id,
                'tanggal' => $request->tanggal,
                'materi' => $request->materi,
                'catatan_pengajar' => $request->catatan_pengajar,
                'absensi' => $request->absensi,
                'status_tersimpan' => "permanen",
            ]);

            $kelas = kelas::where('id', $request->id_kelas)->first();

            $program_belajar = programbelajar::where('id', $kelas->program_belajar_id)->first();
            pengguna::where('id', $request->pengajar_id)->increment('elektronik', $program_belajar->elektronik ?? 0);
            pengguna::where('id', $request->pengajar_id)->increment('mekanik', $program_belajar->mekanik ?? 0);
            pengguna::where('id', $request->pengajar_id)->increment('pemrograman', $program_belajar->pemrograman ?? 0);

            gajiUtama::create([
                'pengajar' => $request->pengajar_id,
                'nominal' => $kelas->gaji_pengajar,
                'status' => "pending",
                'status_pengajar' => "Pengajar Utama",
                'pembelajaran_id' => $id,
            ]);

            if ($request->gaji_transport != 0) {
                gajiTransport::create([
                    'pengajar' => $request->pengajar_id,
                    'nominal' => $kelas->gaji_transport,
                    'status' => "pending",
                    'status_pengajar' => "Pengajar Utama",
                    'pembelajaran_id' => $id,
                ]);
            }

            $poin_siswa = $request->absensi;

            foreach ($poin_siswa as $siswa) {
                $id = $siswa['id'];
                $presensi = $siswa['presensi'];

                $elektronik = 0;
                $mekanik = 0;
                $pemrograman = 0;
                if ($presensi == 'H') {
                    $elektronik = $program_belajar->elektronik;
                    $mekanik = $program_belajar->mekanik;
                    $pemrograman = $program_belajar->pemrograman;
                } elseif ($presensi == 'I') {
                    $elektronik = 0;
                    $mekanik = 0;
                    $pemrograman = 0;
                }

                // Tambahkan poin ke kategori yang sesuai
                pengguna::where('id', $id)->increment('elektronik', $elektronik);
                pengguna::where('id', $id)->increment('mekanik', $mekanik);
                pengguna::where('id', $id)->increment('pemrograman', $pemrograman);
            }

            return response()->json(['message' => 'Kelas Selesai'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function siswa_selesai(Request $request, $id_kelas, $id_siswa)
    {
        try {
            $murid = muridKelas::where('kelas_id', $id_kelas)->first();
            if (!$murid) {
                return response()->json(['error' => 'Data murid tidak ditemukan'], 404);
            }

            $murid_kelas = json_decode($murid->murid, true);

            foreach ($murid_kelas as &$siswa) {
                if ($siswa['id'] == $id_siswa) {
                    $siswa['nilai'] = $request->input('nilai', $siswa['nilai']);
                    $siswa['no_sertiv'] = $request->input('no_sertiv', $siswa['no_sertiv']);
                    $siswa['status_sertiv'] = $request->input('status_sertiv', $siswa['status_sertiv']);
                    break;
                }
            }

            $murid->murid = json_encode($murid_kelas);
            $murid->save();

            return response()->json([
                'message' => 'Data siswa berhasil diperbarui',
                'data' => $murid_kelas
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function finish_kelas(Request $request, $id)
    {
        try {
            kelas::where('id', $id)->update([
                'status_kelas' => $request->status_kelas
            ]);

            return back()->with('success', 'Kelas Selesai');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
