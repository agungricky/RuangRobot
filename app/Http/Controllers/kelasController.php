<?php

namespace App\Http\Controllers;

use App\Exports\AlldataExport;
use App\Exports\JurnalIndexnExport;
use App\Models\akun;
use App\Models\gajiTransport;
use App\Models\gajiUtama;
use App\Models\invoice;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use App\Models\riwayatPembayaran;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use GDText\Box;
use GDText\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Illuminate\Support\Str;

class kelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $data = kelas::with('kategori')->where('kelas.kategori_kelas_id', $id)->orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.kelas.kelas', compact('data', 'id'));
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
            'kode_kelas.required' => 'Kode Kelas harus diisi.',
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
            'kode_kelas' => 'required',
            'harga_kelas' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'nama_program' => 'required|exists:program_belajar,id',
            'kategori_kelas' => 'required',
            'penanggung_jawab' => 'required|exists:profile,id',
            'gaji_pengajar' => 'required',
            'gaji_transport' => 'required',
            'status_kelas' => 'required',
            'jatuh_tempo' => 'required',
        ], $message);

        $durasi_belajar = $request->mulai . '-' . $request->selesai;

        $kelas = kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kode_kelas' => $request->kode_kelas . '-' . Str::upper(Str::random(5)),
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
            'murid' => json_encode([]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = kelas::with('program_belajar', 'kategori', 'pengajar')->where('id', $id)->first();

        // Menghitung Jumlah Siswa
        $jm = kelas::where('kelas.id', $id)
            ->join('murid_kelas', 'murid_kelas.kelas_id', 'kelas.id')
            ->first();

        if ($jm && $jm->murid) {
            $muridArray = json_decode($jm->murid, true);
            $jumlahSiswa = count($muridArray);
        } else {
            $jumlahSiswa = 0;
        }


        // Jumlah Pembelajaran
        $jp = pembelajaran::where('kelas_id', $id)->count();


        // =============================================== // 
        // Jumlah Pembelajaran Total Absensi Siswa //
        // =============================================== // 

        // Ambil data pembelajaran berdasarkan kelas_id
        $total_kelas = Pembelajaran::where('kelas_id', $id)->get();

        $totalAbsensi = [];
        $totalPertemuan = $total_kelas->count(); // Hitung total pertemuan

        // Loop melalui setiap pertemuan
        foreach ($total_kelas as $pertemuan) {
            // Decode data absensi, pastikan JSON valid
            $absensiList = json_decode($pertemuan->absensi, true) ?? [];

            // Loop setiap siswa di absensi
            foreach ($absensiList as $absen) {
                $id = $absen['id'];
                $nama = $absen['nama'];

                // Pastikan setiap siswa ada di totalAbsensi dengan nilai awal
                if (!isset($totalAbsensi[$id])) {
                    $totalAbsensi[$id] = [
                        'id' => $id,
                        'nama' => $nama,
                        'kehadiran' => 0
                    ];
                }

                // Tambahkan jika presensi 'H'
                if ($absen['presensi'] === 'H') {
                    $totalAbsensi[$id]['kehadiran']++;
                }
            }
        }

        // Hitung persentase kehadiran
        $result = array_map(function ($absen) use ($totalPertemuan) {
            $absen['persentase'] = $totalPertemuan > 0
                ? round(($absen['kehadiran'] / $totalPertemuan) * 100, 2)
                : 0;
            return $absen;
        }, $totalAbsensi);

        return view('pages.kelas.detail_kelas', compact('data', 'jp', 'result', 'jumlahSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = kelas::with(['program_belajar', 'kategori', 'pengajar'])->where('kelas.id', $id)->first();
        $pengajarList = akun::with('pengguna')->where('role', 'Pengajar')->get();
        $programBelajar = ProgramBelajar::all();
        $kategori = Kategori::all();

        return view('pages.kelas.edit_kelas', compact('data', 'kategori', 'pengajarList', 'programBelajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = [
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'kode_kelas.required' => 'Kode Kelas harus diisi.',
            'harga_kelas.required' => 'Harga Kelas harus diisi.',
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
            'kode_kelas' => 'required',
            'harga_kelas' => 'required',
            'durasi_belajar' => 'required',
            'programId' => 'required|exists:program_belajar,id',
            'kategori_kelas' => 'required',
            'penanggung_jawab' => 'required|exists:profile,id',
            'gaji_pengajar' => 'required',
            'gaji_transport' => 'required',
            'status_kelas' => 'required',
            'jatuh_tempo' => 'required',
            'harga_kelas' => 'required',
        ], $message);

        $kelas = kelas::findOrFail($id);
        $kode_kelas = $kelas->kode_kelas == $request->kode_kelas ? $kelas->kode_kelas : $request->kode_kelas . '-' . Str::upper(Str::random(5));

        kelas::where('id', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'kode_kelas' => $kode_kelas,
            'harga' => $request->harga_kelas,
            'durasi_belajar' => $request->durasi_belajar,
            'program_belajar_id' => $request->programId,
            'kategori_kelas_id' => $request->kategori_kelas,
            'penanggung_jawab' => $request->penanggung_jawab,
            'gaji_pengajar' => $request->gaji_pengajar,
            'gaji_transport' => $request->gaji_transport,
            'status_kelas' => $request->status_kelas,
            'jatuh_tempo' => $request->jatuh_tempo,
        ]);




        return redirect(route('kelas', ['id' => $request->kategoriKelas]))->with('success', 'Data Kelas Berhasil Diupdate');
    }

    public function kelasselesai($id)
    {
        kelas::where('id', $id)->update([
            'status_kelas' => 'selesai'
        ]);

        return back()->with('success', 'Status kelas berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                riwayatPembayaran::where('kelas_id', $id)->delete();
                invoice::where('kelas_id', $id)->delete();

                $pembelajaran = pembelajaran::where('kelas_id', $id)->get();
                foreach ($pembelajaran as $key => $value) {
                    gajiUtama::where('pembelajaran_id', $value->id)->delete();
                    gajiTransport::where('pembelajaran_id', $value->id)->delete();
                }

                pembelajaran::where('kelas_id', $id)->delete();
                muridKelas::where('kelas_id', $id)->delete();
                kelas::where('id', $id)->delete();
            });

            return redirect(route('kelas', ['id' => $request->kelas]))->with('success', 'Data Kelas Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function jurnalkelas(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $namaFile = 'Jurnal Kelas - ' . preg_replace('/[\/\\\\:*?"<>|]/', '-', $kelas->nama_kelas) . '.xlsx';
        return Excel::download(new JurnalIndexnExport($id), $namaFile);
    }

    public function generateAndDownloadZip($id)
    {
        $participants = muridKelas::with(['kelas.program_belajar', 'kelas.pembelajaran'])->where('murid_kelas.kelas_id', $id)->first();

        $pembelajaran = $participants->kelas->pembelajaran;
        $tanggalAwal = optional($pembelajaran->first())->tanggal;
        $tanggalAkhir = optional($pembelajaran->last())->tanggal;

        // dd($tanggalAwal, $tanggalAkhir);

        // dd($participants->toArray());
        if (!$participants) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $muridData = json_decode($participants->murid, true);

        $zipFileName = public_path('generated/sertifikat.zip');
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $tempDir = public_path('generated/temp_sertifikat/');
            File::makeDirectory($tempDir, 0777, true, true);

            $nama_kelas = $participants->kelas->nama_kelas;
            foreach ($muridData as $murid) {
                if (!isset($murid['id'], $murid['nama'], $nama_kelas)) {
                    continue;
                }

                $certificatePath = $this->createCertificate(
                    $murid['id'],
                    $murid['nama'],
                    $nama_kelas,
                    $murid['sekolah'],
                    $murid['nilai'],
                    $participants,
                    $tanggalAwal,
                    $tanggalAkhir
                );

                $zip->addFile($certificatePath, basename($certificatePath));
            }

            $zip->close();
            File::deleteDirectory($tempDir);

            $namaFileAman = str_replace(['/', '\\'], '_', $participants->kelas->nama_kelas);
            return response()->download($zipFileName, $namaFileAman . '.zip')->deleteFileAfterSend(true);
        }

        return response()->json(['error' => 'Gagal membuat file ZIP'], 500);
    }


    // private function createCertificate($id, $nama, $kelas, $sekolah, $nilai, $dataKelas, $tanggalAwal, $tanggalAkhir)
    // {
    //     // dd($dataKelas->toArray());
    //     $templatePath = public_path('assets/sertifikat.jpg');
    //     if (!file_exists($templatePath)) {
    //         abort(404, "Template sertifikat tidak ditemukan.");
    //     }

    //     $template = imagecreatefromjpeg($templatePath);
    //     $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    //     $bln = $array_bln[date('n')];

    //     // Buat teks di atas sertifikat menggunakan GDText\Box
    //     $box = new Box($template);
    //     $box->setFontFace(public_path('assets/arial.ttf'));
    //     $box->setFontColor(new Color(0, 0, 0));
    //     $box->setFontSize(24);
    //     $box->setBox(680, 240, 450, 120); // Area teks (x, y, width, height)
    //     $box->setTextAlign('center', 'top');
    //     $box->draw("No : " . $dataKelas->kelas_id . "/RUANGROBOT/" . $bln . "/" . date('Y') . "\n\nDIBERIKAN KEPADA :");

    //     // Teks Nama
    //     $box = new Box($template);
    //     $box->setFontFace(public_path('assets/arial.ttf'));
    //     $box->setFontColor(new Color(0, 0, 0));
    //     $box->setFontSize(55);
    //     $box->setBox(500, 330, 800, 160);
    //     $box->setTextAlign('center', 'center');
    //     $box->draw(ucwords($nama));

    //     // Text Sekolah
    //     $box = new Box($template);
    //     $box->setFontFace(public_path('assets/arial.ttf'));
    //     $box->setFontColor(new Color(0, 0, 0));
    //     $box->setFontSize(30);
    //     $box->setBox(500, 450, 800, 200);
    //     $box->setTextAlign('center', 'top');
    //     $box->draw("----" . " " . $sekolah . " " . "----");

    //     // Teks Pelatihan
    //     $box = new Box($template);
    //     $box->setFontFace(public_path('assets/arial.ttf'));
    //     $box->setFontColor(new Color(0, 0, 0));
    //     $box->setFontSize(24);
    //     $box->setBox(500, 530, 800, 200);
    //     $box->setTextAlign('center', 'top');
    //     $box->draw('Telah menyelesaikan pelatihan ' . strtoupper($dataKelas->kelas->program_belajar->nama_program) . ' di Ruang Robot yang dilaksanakan pada tanggal ' . $tanggalAwal . ' - ' . $tanggalAkhir . ' dengan predikat : ');

    //     // // Teks Nilai
    //     $box = new Box($template);
    //     $box->setFontFace('assets/arial.ttf');
    //     $box->setFontColor(new Color(0, 0, 0));
    //     $box->setFontSize(30);
    //     $box->setStrokeColor(new Color(0, 0, 0));
    //     $box->setStrokeSize(.6);
    //     $box->setBox(750, 610, 300, 70);
    //     $box->setTextAlign('center', 'center');

    //     if ($nilai == "A") {
    //         $keterangan = "Sangat Baik";
    //     } elseif ($nilai == "B") {
    //         $keterangan = "Baik";
    //     } else {
    //         $keterangan = "Belum LULUS";
    //     }
    //     $box->draw($keterangan);

    //     $box->draw(($nilai  == "A") ? "Sangat Baik" : (($nilai == "B") ? "Baik" : (($nilai == "C") ? "Cukup" : "Kurang")));

    //     // Load TT

    //     // Teks Ttd
    //     $box = new Box($template);
    //     $box->setFontFace('assets/arial.ttf');
    //     $box->setFontColor(new Color(0, 0, 0));
    //     $box->setFontSize(25);
    //     $box->setBox(880, 690, 400, 460);
    //     $box->setTextAlign('center', 'top');
    //     $box->draw("Kediri, " . Carbon::now()->format('d-m-Y') . "\nRuang Robot\n\n\n\n\nJulian Sahertian, S.Pd., M.T.");

    //     $outputPath = public_path('generated/temp_sertifikat/' . $id . '_' . str_replace(' ', '_', $nama) . '.jpg');
    //     imagejpeg($template, $outputPath);
    //     imagedestroy($template);

    //     return $outputPath;
    // }

    private function createCertificate($id, $nama, $kelas, $sekolah, $nilai, $dataKelas, $tanggalAwal, $tanggalAkhir)
    {
        $templatePath = public_path('assets/sertifikat.jpg');
        $ttdPath = public_path('assets/ttd2.png');
        $fontPath = public_path('assets/arial.ttf');
        $outputPath = public_path('generated/temp_sertifikat/' . $id . '_' . str_replace(' ', '_', $nama) . '.jpg');

        if (!file_exists($templatePath)) {
            abort(404, "Template sertifikat tidak ditemukan.");
        }

        if (!file_exists($ttdPath)) {
            abort(404, "Gambar tanda tangan tidak ditemukan.");
        }

        $template = imagecreatefromjpeg($templatePath);
        $array_bln = [1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        $bln = $array_bln[date('n')];

        // --------- Header Sertifikat (Nomor) ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(680, 240, 450, 120);
        $box->setTextAlign('center', 'top');
        $box->draw("No : {$dataKelas->kelas_id}/RUANGROBOT/{$bln}/" . date('Y') . "\n\nDIBERIKAN KEPADA :");

        // --------- Nama Peserta ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(55);
        $box->setBox(500, 330, 800, 160);
        $box->setTextAlign('center', 'center');
        $box->draw(ucwords($nama));

        // Garis di tengah
        $nama = ucwords($nama);
        $panjang = mb_strlen($nama);
        $garis = str_repeat('─', $panjang + 5);

        // ---------- Garis Bawah Nama ----------
        $box = new Box($template);
        $box->setFontFace($fontPath); // font sama biar rata tengah
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(30); // lebih kecil dari nama
        $box->setBox(500, 423, 800, 160); // posisinya tepat di bawah nama
        $box->setTextAlign('center', 'top');
        $box->draw($garis);

        // --------- Nama Sekolah ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(30);
        $box->setBox(500, 450, 800, 200);
        $box->setTextAlign('center', 'top');
        $box->draw($sekolah);

        // --------- Deskripsi Pelatihan ------------
        $box = new Box($template);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(500, 530, 800, 200);
        $box->setTextAlign('center', 'top');

        $tanggalAwalFormatted  = \Carbon\Carbon::parse($tanggalAwal)->format('d-m-Y');
        $tanggalAkhirFormatted = \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y');
        $box->draw('Telah menyelesaikan pelatihan ' . strtoupper($dataKelas->kelas->program_belajar->nama_program) .
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
        $keterangan = match ($nilai) {
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

        return $outputPath;
    }


    public function generate_show()
    {
        return view('pages.kelas.sertiv_custom');
    }
}
