<?php

namespace App\Exports;

use App\Models\kelas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class JurnalAbsensiExport implements FromArray, WithEvents, WithTitle
{
    protected $kelas;
    protected $jumlahPertemuan;
    protected $pembelajaran;
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

        // dd($this->kelas->toArray());
    }

    public function array(): array
    {
        $data = [];

        for ($i = 0; $i < 3; $i++) {
            $jumlahKolom = 4 + $this->jumlahPertemuan + 2;
            $data[] = array_fill(0, $jumlahKolom, '');
        }

        for ($i = 0; $i < 4; $i++) {
            $data[] = array_fill(0, $jumlahKolom, '');
        }

        // Header statis
        $header = ['NO', 'NAMA', 'KELAS', 'TANGGAL'];

        // Tambah kolom P1, P2, ..., sesuai jumlah pertemuan
        for ($i = 1; $i <= $this->jumlahPertemuan; $i++) {
            $header[] = 'P' . $i;
        }

        // Tambah kolom akhir
        $header[] = 'NILAI';
        $header[] = 'KETERANGAN';

        // Tambahkan ke data array sebagai baris ke-8
        $data[] = $header;

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $jumlahKolom = 4 + $this->jumlahPertemuan + 2;
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
