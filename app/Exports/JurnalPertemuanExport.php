<?php

namespace App\Exports;

use App\Models\kelas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class JurnalPertemuanExport implements FromArray, WithEvents, WithTitle
{
    protected $kelas;
    protected $jumlahPertemuan;
    public function __construct($kelas_id)
    {
        $this->kelas = Kelas::with(
            [
                'program_belajar',
                'pengajar',
                'pembelajaran' => function ($query) {
                    $query->orderBy('tanggal', 'asc');
                },
            ]
        )->findOrFail($kelas_id);


        // dd($this->kelas->toArray());
    }

    public function array(): array
    {
        $data = [
            ['', '', '', '', ''], // A1 - E1
            ['', '', '', '', ''], // A2 - E2
            ['', '', '', '', ''], // A3 - E3
            ['', '', '', '', ''], // A4 - E4
            ['', '', '', '', ''], // A5 - E5
            ['Program Belajar :', ''],
            ['Penanggung Jawab :', ''],
            ['Pertemuan Ke', 'Tanggal', 'Jam', 'Materi', 'Tanda Tangan'],
        ];

        foreach ($this->kelas->pembelajaran as $i => $pertemuan) {
            $data[] = [
                $i + 1,                         // Kolom A
                \Carbon\Carbon::parse($pertemuan['tanggal'])->translatedFormat('l, d F Y'), // Kolom B
                $this->kelas->durasi_belajar,                               // Kolom C
                $pertemuan['materi'],                            // Kolom D
                '',                                              // Kolom E (Tanda tangan)
            ];
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header A1 - E3
                $sheet->mergeCells('A1:E3');
                $sheet->setCellValue('A1', "JURNAL KELAS\n" . $this->kelas->nama_kelas);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(80);

                // Thumnil Mojoroto Indah A4 -  E4
                $sheet->mergeCells('A4:E4');
                $sheet->setCellValue('A4', "Ruang Robot Perum Mojoroto Indah Blok AA-6, Kota Kediri 085655770506");
                $sheet->getStyle('A4')->applyFromArray([
                    'font' => ['size' => 12],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);

                // A5 - E5 KOSONG

                // A6 Program Belajar
                $sheet->getStyle('A6')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // B6 Isi Program Belajar (Merge)
                $sheet->mergeCells('B6:E6');
                $sheet->setCellValue('B6', $this->kelas->program_belajar->nama_program);

                // A7 Penanggung Jawab
                $sheet->getStyle('A7')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // B7 Isi Penanggung Jawab (Merge)
                $sheet->mergeCells('B7:E7');
                $sheet->setCellValue('B7', $this->kelas->pengajar->nama);

                // Style Header Menu Data
                $sheet->getStyle('A8:E8')->applyFromArray([
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

                // Menghitung jumlah data untuk menengahkan data pada kolom
                $this->jumlahPertemuan = count($this->kelas->pembelajaran);
                $awal = 9;
                $akhir = $awal + $this->jumlahPertemuan - 1;

                // Style kolom A Tengah
                $sheet->getStyle("A{$awal}:A{$akhir}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // Style kolom C Tengah
                $sheet->getStyle("C{$awal}:C{$akhir}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // Style border
                $sheet->getStyle("A{$awal}:E{$akhir}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);


                // Kolom A - E Lebarnya menyesuaikan konten
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
            },
        ];
    }

    public function title(): string
    {
        return 'Jurnal Kelas';
    }
}
