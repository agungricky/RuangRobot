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
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use GDText\Box;
use GDText\Color;
use Illuminate\Support\Facades\File;



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

        return view('pages.kelas.kelas', compact('data', 'kategori', 'programbelajar'));
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

        return view('pages.kelas.detail_kelas', compact('data', 'jp', 'result'));
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


    public function sertifikat(string $id)
    {
        // Path template sertifikat
        $templatePath = public_path('assets/certificate.jpg');

        // Cek apakah file template tersedia
        if (!file_exists($templatePath)) {
            abort(404, "Template sertifikat tidak ditemukan.");
        }

        // Load template gambar
        $template = imagecreatefromjpeg($templatePath);

        // Array bulan dalam format Romawi
        $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bln = $array_bln[date('n')];

        // Buat teks di atas sertifikat menggunakan GDText\Box
        $box = new Box($template);
        $box->setFontFace(public_path('assets/arial.ttf')); // Pastikan font tersedia
        $box->setFontColor(new Color(0, 0, 0)); // Warna teks hitam
        $box->setFontSize(24); // Ukuran font
        $box->setBox(680, 240, 450, 120); // Area teks (x, y, width, height)
        $box->setTextAlign('center', 'top');
        $box->draw("No : " . $id . "/RUANGROBOT/" . $bln . "/" . date('Y') . "\n\nDIBERIKAN KEPADA :");

        // Teks Nama
        $box = new Box($template); // Gunakan $template
        $box->setFontFace(public_path('assets/arial.ttf')); // Pastikan font tersedia
        $box->setFontColor(new Color(0, 0, 0)); // Warna teks hitam
        $box->setFontSize(55); // Ukuran font
        $box->setBox(500, 330, 800, 160); // Area teks (x, y, width, height)
        $box->setTextAlign('center', 'center');
        $box->draw(ucwords('Ricky Agung Sumiranto')); // Nama

        // Teks Pelatihan
        $box = new Box($template); // Gunakan $template
        $box->setFontFace(public_path('assets/arial.ttf')); // Pastikan font tersedia
        $box->setFontColor(new Color(0, 0, 0)); // Warna teks hitam
        $box->setFontSize(24); // Ukuran font
        $box->setBox(500, 490, 800, 200); // Area teks (x, y, width, height)
        $box->setTextAlign('center', 'top');
        $box->draw('Telah menyelesaikan pelatihan ' . strtoupper('Program Belajar Arduino Dasar') . ' di Ruang Robot yang dilaksanakan pada tanggal ' . '22-04-00' . ' - ' . '25-04-00' . ' dengan predikat');

        $box = new Box($template);
        $box->setFontFace('assets/arial.ttf');
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(25);
        $box->setStrokeColor(new Color(0, 0, 0)); // Set stroke color
        $box->setStrokeSize(.6); // Stroke size in pixels
        $box->setBox(750, 610, 300, 70);
        $box->setTextAlign('center', 'center');
        $box->draw('SANGAT BAIK');

        $box = new Box($template);
        $box->setFontFace('assets/arial.ttf');
        $box->setFontColor(new Color(0, 0, 0));
        $box->setFontSize(25);
        $box->setBox(880, 690, 400, 460);
        $box->setTextAlign('center', 'top');
        $box->draw("Kediri, " . 29-04-00 . "\nRuang Robot\n\n\n\n\nJulian Sahertian, S.Pd., M.T.");

        $nama_ser = 14 . "_" . 'Arduino Dasar' . '_' . 'Ricky' . '.jpeg';
        // header('Content-Disposition: attachment; filename="'.$nama_ser.'.jpeg"');
        // imagejpeg($im);
        // $path = public_path('cert');
        // if (!\file()::isDirectory($path)) {
        //     \file()::makeDirectory($path, 0777, true, true);
        // }


        // Path untuk menyimpan sertifikat yang sudah diberi teks
        $outputPath = public_path('generated/sertifikat_' . $id . '.jpg');

        // Simpan gambar hasil edit
        imagejpeg($template, $outputPath);
        imagedestroy($template); // Bersihkan memori

        // Return file ke browser agar bisa di-preview
        return response()->file($outputPath);
    }
}
