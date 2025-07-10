<?php

namespace App\Exports;

use App\Models\kelas;
use App\Models\muridKelas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;

class JurnalAbsensiExport implements FromArray, WithEvents, WithTitle
{
    protected $kelas;
    protected $jumlahPertemuan;
    protected $pembelajaran;
    protected $muridKelas;
    public function __construct($kelas_id)
    {
        $this->kelas = kelas::with(
            [
                'program_belajar',
                'pengajar',
                'pembelajaran' => function ($query) {
                    $query->orderBy('tanggal', 'asc');
                },
            ]
        )->findOrFail($kelas_id);

        $this->pembelajaran = $this->kelas->pembelajaran;
        $this->jumlahPertemuan = count($this->pembelajaran);

        $this->muridKelas = muridKelas::where('kelas_id', $kelas_id)->first();

        // dd($this->muridKelas->toArray());
    }

    public function array(): array
    {
        $data = [];

        // Baris kosong untuk header di atas (baris 1-7)
        for ($i = 0; $i < 7; $i++) {
            $jumlahKolom = 3 + $this->jumlahPertemuan + 2; // 3 kolom tetap + pertemuan + nilai + keterangan
            $data[] = array_fill(0, $jumlahKolom, '');
        }

        // Baris ke-8: Header kolom
        $header = ['NO', 'NAMA', 'KELAS'];
        for ($i = 1; $i <= $this->jumlahPertemuan; $i++) {
            $header[] = 'P' . $i;
        }
        $header[] = 'NILAI';
        $header[] = 'KETERANGAN';
        $data[] = $header;

        // Baris ke-9: Tanggal pertemuan
        $tanggalBaris = ['', '', '']; // untuk NO, NAMA, KELAS
        foreach ($this->pembelajaran as $p) {
            $tanggalBaris[] = \Carbon\Carbon::parse($p['tanggal'])->translatedFormat('d M Y');
        }
        $tanggalBaris[] = '';
        $tanggalBaris[] = '';
        $data[] = $tanggalBaris;

        // Decode JSON murid
        $muridArray = json_decode($this->muridKelas->murid, true);

        // Tambahkan data murid
        foreach ($muridArray as $i => $murid) {
            $row = [
                $i + 1,
                $murid['nama'],
                $murid['kelas']
            ];

            // Loop pertemuan
            foreach ($this->pembelajaran as $pertemuan) {
                $absensi = json_decode($pertemuan['absensi'], true);
                $hadir = false;

                foreach ($absensi as $siswa) {
                    if ($siswa['id'] == $murid['id'] && $siswa['presensi'] == "H") {
                        $hadir = true;
                        break;
                    }
                }

                $row[] = $hadir ? '✔' : '';
            }

            // Nilai & Keterangan
            $row[] = $murid['nilai'] ?? '-';

            $keterangan = kelas::with('program_belajar')->find($this->kelas->id);
            // dd($keterangan->toArray());

            if ($murid['nilai'] == 'A') {
                $row[] = 'Sangat baik dan aktif dalam mengikuti materi' . ' ' . $keterangan->program_belajar->nama_program;
            } else if ($murid['nilai'] == 'B') {
                $row[] = 'Baik dalam mengikuti materi' . ' ' . $keterangan->program_belajar->nama_program;
            } else {
                $row[] = 'Belum Menyelesaikan Kelas';
            }
            // $row[] = ($murid['nilai'] ?? '') === 'A' ? 'Sangat baik dan aktif dalam mengikuti materi' . ' ' . $keterangan->program_belajar->nama_program : 'Baik dalam mengikuti materi' . $keterangan->program_belajar->nama_program;

            $data[] = $row;
        }

        return $data;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $jumlahKolom = 3 + $this->jumlahPertemuan + 2;
                $kolomTerakhir = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($jumlahKolom);

                // Membuat Header Kelas
                $sheet->mergeCells("A1:{$kolomTerakhir}3");
                $sheet->setCellValue('A1', "JURNAL NILAI & ABSENSI SISWA\n" . $this->kelas->nama_kelas);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(80);

                // Membuat Thumnile RR
                $sheet->mergeCells("A4:{$kolomTerakhir}4");
                $sheet->setCellValue('A4', "Ruang Robot Perum Mojoroto Indah Blok AA-6, Kota Kediri 085655770506");
                $sheet->getStyle('A4')->applyFromArray([
                    'font' => ['size' => 12],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);

                // A5 Kosong

                // B6 Isi Program Belajar (Merge)
                $sheet->setCellValue('A6', 'Program Belajar :');
                $sheet->mergeCells("B6:{$kolomTerakhir}6");
                $sheet->setCellValue('B6', $this->kelas->program_belajar->nama_program);
                $sheet->getStyle('A6')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // B7 Penanggung Jawab (Merge)
                $sheet->setCellValue('A7', 'Penanggung Jawab :');
                $sheet->mergeCells("B7:{$kolomTerakhir}7");
                $sheet->setCellValue('B7', $this->kelas->pengajar->nama);
                $sheet->getStyle('A7')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // Merge kolom A, B, C (NO, NAMA, KELAS)
                for ($i = 1; $i <= 3; $i++) {
                    $col = Coordinate::stringFromColumnIndex($i);
                    $sheet->mergeCells("{$col}8:{$col}9");
                }

                // Skip kolom P1 - Pn (tidak di-merge), langsung ke kolom setelahnya
                $startNilaiIndex = 3 + $this->jumlahPertemuan + 1; // kolom setelah terakhir pertemuan (NILAI)
                for ($i = $startNilaiIndex; $i <= $startNilaiIndex + 1; $i++) { // NILAI dan KETERANGAN
                    $col = Coordinate::stringFromColumnIndex($i);
                    $sheet->mergeCells("{$col}8:{$col}9");
                }

                // Style Header Menu Data
                $sheet->getStyle("A8:{$kolomTerakhir}8")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'], // Warna teks putih
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '000000'], // Background hitam
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                        'wrapText' => true, // Kalau perlu bungkus teks panjang
                    ],
                ]);

                $startIndex = 4;
                for ($i = 0; $i < $this->jumlahPertemuan; $i++) {
                    $colIndex = $startIndex + $i;
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex);

                    // Style baris 8 dan 9 (judul P dan tanggal)
                    foreach ([8, 9] as $row) {
                        $sheet->getStyle("{$colLetter}{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => '000000'],
                            ],
                            'alignment' => [
                                'horizontal' => 'center',
                                'vertical' => 'center',
                                'wrapText' => true,
                            ],
                        ]);
                    }
                }

                // Rata tengah semua isi kolom A dan C
                $sheet->getStyle('A8:A1000')->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle('C8:C1000')->getAlignment()->setHorizontal('center')->setVertical('center');

                $jumlahBaris = count($this->muridKelas ? json_decode($this->muridKelas->murid, true) : []) + 9;

                // Mulai dari kolom ke-4 (P1 dimulai dari index ke-4)
                $startIndex = 4;
                for ($i = 0; $i < $this->jumlahPertemuan; $i++) {
                    $colIndex = $startIndex + $i;
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                    $sheet->getStyle("{$colLetter}8:{$colLetter}{$jumlahBaris}")
                        ->getAlignment()
                        ->setHorizontal('center')
                        ->setVertical('center');
                }

                // Kolom KETERANGAN (setelah kolom nilai)
                $colKeterangan = Coordinate::stringFromColumnIndex(3 + $this->jumlahPertemuan + 1);
                $sheet->getStyle("{$colKeterangan}8:{$colKeterangan}{$jumlahBaris}")
                    ->getAlignment()->setHorizontal('center')->setVertical('center');

                // Hitung jumlah kolom dan baris
                $jumlahKolom = 3 + $this->jumlahPertemuan + 2; // NO, NAMA, KELAS + Pn + NILAI + KETERANGAN
                $kolomTerakhir = Coordinate::stringFromColumnIndex($jumlahKolom);

                // Hitung jumlah baris (7 baris kosong + 2 header + jumlah murid)
                $jumlahBarisData = count(json_decode($this->muridKelas->murid, true));
                $barisAwal = 8; // Header mulai baris 8
                $barisAkhir = $barisAwal + 1 + $jumlahBarisData; // header + tanggal + murid

                // Terapkan border ke seluruh range dari A8 hingga kolom terakhir dan baris akhir
                $range = "A{$barisAwal}:{$kolomTerakhir}{$barisAkhir}";
                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                foreach (range('A', $kolomTerakhir) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Daftar Hadir & Nilai';
    }
}
