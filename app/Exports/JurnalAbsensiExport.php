<?php

namespace App\Exports;

use App\Models\kelas;
use App\Models\muridKelas;
use Maatwebsite\Excel\Concerns\FromArray;
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
        $this->kelas = kelas::with([
            'program_belajar',
            'pengajar',
            'pembelajaran' => function ($query) {
                $query->orderByRaw('ISNULL(tanggal), tanggal ASC');
            },
        ])->findOrFail($kelas_id);

        $this->pembelajaran = $this->kelas->pembelajaran;
        $this->jumlahPertemuan = count($this->pembelajaran);
        $this->muridKelas = muridKelas::where('kelas_id', $kelas_id)->first();
    }

    public function array(): array
    {
        $data = [];

        // Baris kosong 1-7
        for ($i = 0; $i < 7; $i++) {
            $data[] = array_fill(0, 3 + $this->jumlahPertemuan, '');
        }

        // Header baris 8
        $header = ['NO', 'NAMA', 'KELAS'];
        for ($i = 1; $i <= $this->jumlahPertemuan; $i++) {
            $header[] = 'P' . $i;
        }
        $data[] = $header;

        // Baris 9: tanggal
        $tanggalBaris = ['', '', ''];
        foreach ($this->pembelajaran as $p) {
            $tanggalBaris[] = !empty($p['tanggal'])
                ? \Carbon\Carbon::parse($p['tanggal'])->translatedFormat('d M Y')
                : '';
        }
        $data[] = $tanggalBaris;

        // Isi data murid
        $muridArray = json_decode($this->muridKelas->murid, true);
        foreach ($muridArray as $i => $murid) {
            $row = [
                $i + 1,
                $murid['nama'],
                $murid['kelas']
            ];

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

            $data[] = $row;
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $jumlahKolom = 3 + $this->jumlahPertemuan;
                $kolomTerakhir = Coordinate::stringFromColumnIndex($jumlahKolom);

                // Header kelas
                $sheet->mergeCells("A1:{$kolomTerakhir}3");
                $sheet->setCellValue('A1', "JURNAL NILAI & ABSENSI SISWA\n" . $this->kelas->nama_kelas);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(80);

                // Alamat
                $sheet->mergeCells("A4:{$kolomTerakhir}4");
                $sheet->setCellValue('A4', "Ruang Robot Perum Mojoroto Indah Blok AA-6, Kota Kediri 085655770506");
                $sheet->getStyle('A4')->applyFromArray([
                    'font' => ['size' => 12],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);

                // Program belajar
                $sheet->setCellValue('A6', 'Program Belajar :');
                $sheet->mergeCells("B6:{$kolomTerakhir}6");
                $sheet->setCellValue('B6', $this->kelas->program_belajar->nama_program);
                $sheet->getStyle('A6')->applyFromArray(['font' => ['bold' => true]]);

                // Pengajar
                $sheet->setCellValue('A7', 'Penanggung Jawab :');
                $sheet->mergeCells("B7:{$kolomTerakhir}7");
                $sheet->setCellValue('B7', $this->kelas->pengajar->nama);
                $sheet->getStyle('A7')->applyFromArray(['font' => ['bold' => true]]);

                // Merge kolom A, B, C (NO, NAMA, KELAS)
                for ($i = 1; $i <= 3; $i++) {
                    $col = Coordinate::stringFromColumnIndex($i);
                    $sheet->mergeCells("{$col}8:{$col}9");
                }

                // Style header baris 8
                $sheet->getStyle("A8:{$kolomTerakhir}8")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
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

                // Style untuk P1 - Pn (judul & tanggal)
                $startIndex = 4;
                for ($i = 0; $i < $this->jumlahPertemuan; $i++) {
                    $colIndex = $startIndex + $i;
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                    foreach ([8, 9] as $row) {
                        $sheet->getStyle("{$colLetter}{$row}")->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => '000000'],
                            ],
                            'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                        ]);
                    }
                }

                // Rata tengah kolom tertentu
                $sheet->getStyle('A8:A1000')->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle('C8:C1000')->getAlignment()->setHorizontal('center')->setVertical('center');

                // Rata tengah isi P1-Pn
                $jumlahBaris = count($this->muridKelas ? json_decode($this->muridKelas->murid, true) : []) + 9;
                for ($i = 0; $i < $this->jumlahPertemuan; $i++) {
                    $colLetter = Coordinate::stringFromColumnIndex(4 + $i);
                    $sheet->getStyle("{$colLetter}8:{$colLetter}{$jumlahBaris}")
                        ->getAlignment()
                        ->setHorizontal('center')
                        ->setVertical('center');
                }

                // Border seluruh tabel
                $barisAwal = 8;
                $barisAkhir = $barisAwal + 1 + count(json_decode($this->muridKelas->murid, true));
                $range = "A{$barisAwal}:{$kolomTerakhir}{$barisAkhir}";
                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Auto-size
                foreach (range('A', $kolomTerakhir) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Daftar Hadir';
    }
}
