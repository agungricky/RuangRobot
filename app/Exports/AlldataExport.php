<?php

namespace App\Exports;

use App\Models\kelas;
use App\Models\pembelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

// class AlldataExport implements FromCollection, FromArray, WithEvents, WithStyles

class AlldataExport implements FromArray, WithEvents, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $kelas;
    protected $pertemuan;
    public function __construct($kelas_id)
    {
        $this->kelas = Kelas::with('program_belajar')->findOrFail($kelas_id);
        $this->pertemuan = 16;
        // dd($this->kelas->toArray());
    }

    public function array(): array
    {
        // Inisialisasi array kosong
        $data = [];

        // Buat 4 baris kosong awal (baris A1–A4)
        for ($i = 0; $i < 4; $i++) {
            // Jumlah kolom = 4 kolom tetap + $pertemuan + 1 kolom KET
            $jumlahKolom = 4 + $this->pertemuan + 1;
            $data[] = array_fill(0, $jumlahKolom, '');
        }

        // Tambah baris ke-5 kosong (hanya 1 kolom isi kosong)
        $data[] = [''];

        $header = ['NO', 'NAMA LENGKAP', 'SEKOLAH', 'KELAS'];

        for ($i = 1; $i <= $this->pertemuan; $i++) {
            $header[] = (string)$i;
        }

        $header[] = 'KET';
        $data[] = $header;

        // Contoh data siswa, nanti bisa kamu ambil dari DB
        $siswa = [
            [1, 'Ricky Agung Sumiranto', 'SD Rahmat Kota Kediri', '4A'],
            [2, 'Ika Maria Daniati', 'MTSN Kota Kediri', '4B'],
        ];

        foreach ($siswa as $s) {
            $data[] = array_merge($s, array_fill(0, $this->pertemuan + 1, ''));
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $jumlahKolom = 4 + $this->pertemuan + 1;
                $kolomTerakhir = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($jumlahKolom);

                // Merge A1 sampai kolom terakhir baris 4
                $sheet->mergeCells("A1:{$kolomTerakhir}4");
                $sheet->setCellValue('A1', "JURNAL KELAS & DAFTAR HADIR  \n" . $this->kelas->nama_kelas);

                $sheet->getStyle("A1")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                        'wrapText' => true,
                    ],
                ]);

                $sheet->mergeCells("A5:{$kolomTerakhir}5");
                $sheet->setCellValue('A5', 'Program Belajar : ' . $this->kelas->program_belajar->nama_program);

                // Hitung jumlah siswa dari data
                $jumlahSiswa = count([
                    [1, 'Faizar', 'SD 1', '4A'],
                    [2, 'Bilqis', 'SD 2', '4B'],
                ]);
                $akhirBaris = 6 + $jumlahSiswa;

                $sheet->getStyle("A6:{$kolomTerakhir}{$akhirBaris}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                ]);

                foreach (range('A', $kolomTerakhir) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }



    public function styles(Worksheet $sheet)
    {
        return [
            6 => ['font' => ['bold' => true]],
        ];
    }
}
