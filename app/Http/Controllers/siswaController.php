<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\siswa;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;
use GDText\Box;
use GDText\Color;

class siswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $data = pengguna::where('id', $id)->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $kelas_diikuti = json_decode($data->kelas_diikuti, true);
        $id_kelas_array = array_column($kelas_diikuti, 'id_kelas');

        $kelas = kelas::whereIn('kelas.id', $id_kelas_array)
            ->where('kelas.status_kelas', 'Aktif')
            ->join('program_belajar', 'kelas.program_belajar_id', 'program_belajar.id')
            ->select('kelas.*', 'program_belajar.nama_program')
            ->get();

        $kelas_selesai = kelas::whereIn('kelas.id', $id_kelas_array)
            ->where('kelas.status_kelas', 'Selesai')
            ->join('program_belajar', 'kelas.program_belajar_id', 'program_belajar.id')
            ->select('kelas.*', 'program_belajar.nama_program')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'kelas' => $kelas,
                'kelas_selesai' => $kelas_selesai,
            ]);
        }

        return view('pages.kelas.siswa.kelas', compact('id'));
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
        $kelas = Kelas::where('kelas.id', $id)
            ->join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
            ->join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
            ->select('kelas.id', 'kelas.nama_kelas', 'kelas.status_kelas', 'program_belajar.nama_program', 'program_belajar.level', 'program_belajar.mekanik', 'program_belajar.elektronik', 'program_belajar.pemrograman', 'kategori_kelas.kategori_kelas')
            ->first();

        $jumlah_pertemuan = pembelajaran::where('kelas_id', $id)->count();

        $pembelajaran = pembelajaran::where('pembelajaran.kelas_id', $id)
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('pembelajaran.*', 'kelas.durasi_belajar')
            ->orderBy('pertemuan', 'asc')
            ->get();

        $siswa_login = Auth::user();
        $siswa = pengguna::where('id', $siswa_login->id)->first();

        foreach ($pembelajaran as $item) {
            $absensi = json_decode($item->absensi, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                dd("Error JSON: ", json_last_error_msg());
            }

            $dataAbsen = [];

            if ($absensi) {
                foreach ($absensi as $absen) {
                    if (trim($absen['nama']) === trim($siswa->nama)) {
                        $dataAbsen[] = [
                            'nama' => $absen['nama'],
                            'presensi' => $absen['presensi']
                        ];
                    }
                }
            }

            $item->absensi_siswa = $dataAbsen;
        }

        $daftar_siswa = muridKelas::where('murid_kelas.kelas_id', $id)->first();
        $daftar_siswa = json_decode($daftar_siswa->murid);

        $kehadiran = [];
        $totalPertemuan = $pembelajaran->count();

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
                        'total' => $totalPertemuan,
                        'persentase' => 0
                    ];
                }

                if ($presensi === 'H') {
                    $kehadiran[$id]['hadir']++;
                }
            }
        }

        foreach ($kehadiran as &$siswa) {
            $siswa['persentase'] = ($siswa['hadir'] / $siswa['total']) * 100;
        }

        foreach ($daftar_siswa as &$siswa) {
            $id = $siswa->id;
            $siswa->persentase = isset($kehadiran[$id]) ? $kehadiran[$id]['persentase'] : 0;
        }

        $status_pembayaran = '';
        $kekurangan = '';
        foreach ($daftar_siswa as $value) {
            if ($value->id == $siswa->id) {
                $status_pembayaran = $value->pembayaran == $value->tagihan ? 'Lunas' : 'Belum Lunas';
                $kekurangan = $value->tagihan - $value->pembayaran;
                break;
            }
        }

        return view('pages.kelas.siswa.detail_kelas', compact('kelas', 'jumlah_pertemuan', 'pembelajaran', 'daftar_siswa', 'status_pembayaran', 'kekurangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function pembayaran(Request $request, $id)
    {
        $data = pengguna::where('id', $id)->first();

        $kelas_diikuti = json_decode($data->kelas_diikuti, true);

        $id_kelas_array = array_column($kelas_diikuti, 'id_kelas');

        $kelas = kelas::whereIn('kelas.id', $id_kelas_array)
            ->join('program_belajar', 'kelas.program_belajar_id', 'program_belajar.id')
            ->select('kelas.*', 'program_belajar.nama_program')
            ->get();

        $data_siswa = [];

        foreach ($kelas as $item) {
            $muridKelas = muridKelas::where('kelas_id', $item->id)->first();

            if ($muridKelas && $muridKelas->murid) {
                $murid = json_decode($muridKelas->murid, true);

                if (is_array($murid)) {
                    foreach ($murid as $key => $value) {
                        if ($value['id'] == $data->id) {
                            $value['nama_kelas'] = $item->nama_kelas;
                            $value['nama_program'] = $item->nama_program;
                            $value['status_kelas'] = $item->status_kelas;
                            $value['kekurangan'] = $value['tagihan'] - $value['pembayaran'];
                            $value['status_pembayaran'] = ($value['pembayaran'] == $value['tagihan']) ? 'Lunas' : 'Belum Lunas';
                            $data_siswa[] = $value;
                            break;
                        }
                    }
                }
            }
        }

        // dd($data_siswa);

        return view('pages.pembayaran.siswa.pembayaran', compact('data_siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function detail_pembayaran(Request $request)
    {
        $data = $request->except('_token');
        return view('pages.pembayaran.siswa.detail_pembayaran', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function generate_sertiv()
    {
        $templatePath = public_path('assets/certificate.jpg');
        if (!file_exists($templatePath)) {
            abort(404, "Template sertifikat tidak ditemukan.");
        }

        $template = imagecreatefromjpeg($templatePath);
        $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bln = $array_bln[date('n')];

        // Teks No Sertifikat
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf'));
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(680, 240, 450, 120);
        $box->setTextAlign('center', 'top');
        $box->draw("No : " . 12 . "/RUANGROBOT/" . $bln . "/" . date('Y') . "\n\nDIBERIKAN KEPADA :");

        // Teks Nama
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf'));
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(55);
        $box->setBox(500, 330, 800, 160);
        $box->setTextAlign('center', 'center');
        $box->draw(ucwords("Ricky Agung Sumiranto"));

        // Teks Pelatihan
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf'));
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(500, 490, 800, 200);
        $box->setTextAlign('center', 'top');
        $box->draw('Telah menyelesaikan pelatihan ' . strtoupper("7B") . ' di Ruang Robot yang dilaksanakan pada tanggal ' . '22-04-00' . ' - ' . '25-04-00' . ' dengan predikat');

        // Buat file gambar sementara
        return response()->streamDownload(function () use ($template) {
            imagejpeg($template);
            imagedestroy($template);
        }, "sertifikat_17.jpg");
    }
}
