<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\siswa;
use Carbon\Carbon;
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
        $kelas = Invoice::with([
            'kelas.kategori',
            'kelas.program_belajar'
        ])
            ->where('profile_id', $id)
            ->whereHas('kelas', function ($q) {
                $q->where('status_kelas', 'aktif');
            })
            ->get();

        $kelas_selesai = Invoice::with(['kelas.kategori', 'kelas.program_belajar'])
            ->where('profile_id', $id)
            ->whereHas('kelas', function ($q) {
                $q->where('status_kelas', 'selesai');
            })
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
        $kelas = kelas::with(['kategori', 'program_belajar'])
            ->where('kelas.id', $id)
            ->first();

        $jumlah_pertemuan = pembelajaran::where('kelas_id', $id)->count();
        $pembelajaran = pembelajaran::with('kelas.pengajar')->where('pembelajaran.kelas_id', $id)->get();

        // Kebutuhan nomor Sertif
        $awal = Pembelajaran::whereNotNull('tanggal')->orderByDesc('id')->first();
        $akhir = Pembelajaran::whereNotNull('tanggal')->latest('id')->first();

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

        $status_pembayaran = '';
        $kekurangan = '';
        foreach ($daftar_siswa as $value) {
            if ($value->id == $siswa->id) {
                $status_pembayaran = $value->pembayaran == $value->tagihan ? 'Lunas' : 'Belum Lunas';
                $kekurangan = $value->tagihan - $value->pembayaran;
                break;
            }
        }

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


        return view('pages.kelas.siswa.detail_kelas', compact('kelas', 'jumlah_pertemuan', 'pembelajaran', 'daftar_siswa', 'status_pembayaran', 'kekurangan', 'siswa', 'awal', 'akhir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function pembayaran(Request $request, $id)
    {
        $kelas = invoice::where('invoice.profile_id', $id)
            ->join('kelas', 'invoice.kelas_id', 'kelas.id')
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
                        if ($value['id'] == $id) {
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
    public function generate_sertiv(Request $request)
    {
        // dd($request->all());
        $templatePath = public_path('assets/sertifikat.jpg');
        $ttdPath = public_path('assets/ttd2.png');
        $fontPath = public_path('assets/arial.ttf');

        $folderPath = public_path('generated/temp_sertifikat');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $no_sertiv_safe = str_replace(['/', '\\'], '-', $request->no_sertiv);
        $nama_safe = str_replace(' ', '_', $request->nama);

        $outputPath = public_path('generated/temp_sertifikat/' . $no_sertiv_safe . '_' . $nama_safe . '.jpg');

        if (!file_exists($templatePath)) {
            abort(404, "Template sertifikat tidak ditemukan.");
        }

        $template = imagecreatefromjpeg($templatePath);
        $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bln = $array_bln[date('n')];

        // --------- Header Sertifikat (Nomor) ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(680, 240, 450, 120);
        $box->setTextAlign('center', 'top');
        $box->draw("No : {$request->no_sertiv}/RUANGROBOT/{$bln}/" . date('Y') . "\n\nDIBERIKAN KEPADA :");

        // --------- Nama Peserta ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(55);
        $box->setBox(500, 330, 800, 160);
        $box->setTextAlign('center', 'center');
        $box->draw(ucwords($request->nama));

        // Garis di tengah
        $nama = ucwords($request->nama);
        $panjang = mb_strlen($request->nama);
        $garis = str_repeat('─', $panjang + 5);

        // ---------- Garis Bawah Nama ----------
        $box = new Box($template);
        $box->setFontFace($fontPath); // font sama biar rata tengah
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(30); // lebih kecil dari nama
        $box->setBox(500, 423, 800, 160); // posisinya tepat di bawah nama
        $box->setTextAlign('center', 'top');
        $box->draw($garis);

        if (($request->sekolah != null) || ($request->sekolah != '')) {
            // --------- Nama Sekolah ------------
            $box = new Box($template);
            $box->setFontFace($fontPath);
            $box->setFontColor(new Color(0, 0, 0));
            $box->setFontSize(30);
            $box->setBox(500, 450, 800, 200);
            $box->setTextAlign('center', 'top');
            $box->draw($request->sekolah);
        }

        // --------- Deskripsi Pelatihan ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(500, 530, 800, 200);
        $box->setTextAlign('center', 'top');

        $tanggalAwalFormatted  = \Carbon\Carbon::parse($request->tanggal_mulai)->format('d-m-Y');
        $tanggalAkhirFormatted = \Carbon\Carbon::parse($request->tanggal_selesai)->format('d-m-Y');
        $box->draw(strip_tags($request->keterangan) .
            ' di Ruang Robot yang dilaksanakan pada tanggal ' .
            $tanggalAwalFormatted . ' s/d ' . $tanggalAkhirFormatted . ' dengan predikat :');

        // --------- Nilai / Predikat ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(45);
        $box->setStrokeColor(new Color(0, 0, 0));
        $box->setStrokeSize(.6);
        $box->setBox(750, 610, 300, 70);
        $box->setTextAlign('center', 'center');
        $keterangan = match ($request->nilai) {
            "A" => "Sangat Baik",
            "B" => "Baik",
            null => "-",
            default => "-",
        };
        $box->draw($keterangan);


        // --------- Tambah Gambar Tanda Tangan ------------
        $ttd = imagecreatefrompng($ttdPath);
        imagealphablending($ttd, true);
        imagesavealpha($ttd, true);

        // Resize (jika perlu)
        $ttdWidth = 400;
        $ttdHeight = 230;
        $resizedTTD = imagecreatetruecolor($ttdWidth, $ttdHeight);
        imagealphablending($resizedTTD, false);
        imagesavealpha($resizedTTD, true);
        imagecopyresampled($resizedTTD, $ttd, 0, 0, 0, 0, $ttdWidth, $ttdHeight, imagesx($ttd), imagesy($ttd));

        // Tempel tanda tangan ke posisi (sesuaikan X dan Y-nya)
        imagecopy($template, $resizedTTD, 910, 715, 0, 0, $ttdWidth, $ttdHeight);

        // --------- Teks Nama Penandatangan ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(25);
        $box->setBox(880, 690, 400, 460);
        $box->setTextAlign('center', 'top');
        $box->draw("Kediri, " . Carbon::now()->format('d-m-Y') . "\n\n\n\n\n\nJulian Sahertian, S.Pd., M.T.");

        // Simpan ke file
        imagejpeg($template, $outputPath);
        imagedestroy($template);
        imagedestroy($ttd);
        imagedestroy($resizedTTD);

        // Buat file gambar sementara
        return response()->streamDownload(function () use ($template) {
            ob_clean(); // bersihkan buffer
            flush();    // paksa kirim header bersih

            imagejpeg($template);
            imagedestroy($template);
        }, $no_sertiv_safe . '_' . $nama_safe . '.jpg', [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename="' . $no_sertiv_safe . '_' . $nama_safe . '.jpg"',
        ]);
    }
}
