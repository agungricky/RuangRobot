<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\Kategori;
use App\Models\kelas;
use App\Models\muridKelas;
use App\Models\pembelajaran;
use App\Models\pengguna;
use App\Models\programbelajar;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use GDText\Box;
use GDText\Color;
use Illuminate\Support\Facades\File;
use ZipArchive;

class kelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $data = kelas::join('kategori_kelas', 'kategori_kelas.id', 'kelas.kategori_kelas_id')
            ->where('kelas.kategori_kelas_id', $id)
            ->select('kelas.*', 'kategori_kelas.kategori_kelas')
            ->orderByDesc('created_at')
            ->get();
        $kategori = Kategori::all();
        $programbelajar = programbelajar::all();
        // dd($data);
        if ($request->ajax()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return view('pages.kelas.kelas', compact('data', 'kategori', 'programbelajar', 'id'));
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
        $jp = pembelajaran::where('id', $id)->count();

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
    public function destroy(string $id)
    {
        muridKelas::where('kelas_id', $id)->delete();
        kelas::where('id', $id)->delete();
        return redirect('kelas')->with('success', 'Data Kelas Berhasil Dihapus');
    }

    public function jurnalkelas(string $id)
    {
        $data = kelas::where('kelas.id', $id)
            ->join('program_belajar', 'program_belajar.id', 'kelas.program_belajar_id')
            ->select('kelas.*', 'program_belajar.nama_program')
            ->first();

        $data_pertemuan = pembelajaran::where('pembelajaran.kelas_id', $id)
            ->join('kelas', 'kelas.id', 'pembelajaran.kelas_id')
            ->select('pembelajaran.pertemuan', 'pembelajaran.tanggal', 'pembelajaran.materi', 'pembelajaran.pengajar', 'kelas.durasi_belajar')
            ->get();

        $absensi_siswa = pembelajaran::where('pembelajaran.kelas_id', $id)
            ->select('pertemuan', 'absensi')
            ->get();

        $absensi_siswa->each(function ($item) {
            $item->absensi = json_decode($item->absensi, true);
        });

        // Kirim data ke view PDF
        $pdf = FacadePdf::loadView('pdf.jurnal_kelas', compact('data', 'data_pertemuan', 'absensi_siswa'));

        // Tampilkan terlebih dahulu
        return $pdf->stream('jurnal_kelas.pdf');
    }

    public function generateAndDownloadZip($id)
    {
        $participants = muridKelas::where('murid_kelas.kelas_id', $id)
            ->join('kelas', 'kelas.id', 'murid_kelas.kelas_id')
            ->select('murid_kelas.*', 'kelas.nama_kelas')
            ->first();

        if (!$participants) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $muridData = json_decode($participants->murid, true);
        // dd($muridData);

        $zipFileName = public_path('generated/sertifikat.zip');
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $tempDir = public_path('generated/temp_sertifikat/');
            File::makeDirectory($tempDir, 0777, true, true);

            $nama_kelas = $participants->nama_kelas;
            foreach ($muridData as $murid) {
                if (!isset($murid['id'], $murid['nama'], $nama_kelas)) {
                    continue;
                }

                $certificatePath = $this->createCertificate(
                    $murid['id'],
                    $murid['nama'],
                    $nama_kelas,
                    $murid['nilai'],
                );

                $zip->addFile($certificatePath, basename($certificatePath));
            }

            $zip->close();
            File::deleteDirectory($tempDir);

            // return response()->download($zipFileName, $participants->nama_kelas)->deleteFileAfterSend(true);
            $namaFileAman = str_replace(['/', '\\'], '_', $participants->nama_kelas);
            return response()->download($zipFileName, $namaFileAman . '.zip')->deleteFileAfterSend(true);
        }

        return response()->json(['error' => 'Gagal membuat file ZIP'], 500);
    }


    private function createCertificate($id, $nama, $kelas, $nilai)
    {
        $templatePath = public_path('assets/certificate.jpg');
        if (!file_exists($templatePath)) {
            abort(404, "Template sertifikat tidak ditemukan.");
        }

        $template = imagecreatefromjpeg($templatePath);
        $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bln = $array_bln[date('n')];

        // Buat teks di atas sertifikat menggunakan GDText\Box
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf'));
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(680, 240, 450, 120); // Area teks (x, y, width, height)
        $box->setTextAlign('center', 'top');
        $box->draw("No : " . $id . "/RUANGROBOT/" . $bln . "/" . date('Y') . "\n\nDIBERIKAN KEPADA :");

        // Teks Nama
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf'));
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(55);
        $box->setBox(500, 330, 800, 160);
        $box->setTextAlign('center', 'center');
        $box->draw(ucwords($nama));

        // Teks Pelatihan
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf'));
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(24);
        $box->setBox(500, 490, 800, 200);
        $box->setTextAlign('center', 'top');
        $box->draw('Telah menyelesaikan pelatihan ' . strtoupper($kelas) . ' di Ruang Robot yang dilaksanakan pada tanggal ' . '22-04-00' . ' - ' . '25-04-00' . ' dengan predikat');

        // Teks Nilai
        $box = new Box($template);
        $box->setFontFace('assets/arial.ttf');
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(25);
        $box->setStrokeColor(new Color(0, 0, 0));
        $box->setStrokeSize(.6);
        $box->setBox(750, 610, 300, 70);
        $box->setTextAlign('center', 'center');
        $box->draw($nilai);

        // Teks Ttd
        $box = new Box($template);
        $box->setFontFace('assets/arial.ttf');
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(25);
        $box->setBox(880, 690, 400, 460);
        $box->setTextAlign('center', 'top');
        $box->draw("Kediri, " . Carbon::now()->format('d-m-Y') . "\nRuang Robot\n\n\n\n\nJulian Sahertian, S.Pd., M.T.");

        $outputPath = public_path('generated/temp_sertifikat/' . $id . '_' . str_replace(' ', '_', $nama) . '.jpg');
        imagejpeg($template, $outputPath);
        imagedestroy($template);

        return $outputPath;
    }

    public function generate_show()
    {
        return view('pages.kelas.sertiv_custom');
    }
}
