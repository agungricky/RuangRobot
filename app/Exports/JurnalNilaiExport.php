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

class JurnalNilaiExport implements FromArray, WithEvents, WithTitle
{
    protected $kelas;
    protected $muridKelas;

    public function __construct($kelas_id)
    {
        $this->kelas = kelas::with(['program_belajar', 'pengajar'])->findOrFail($kelas_id);
        $this->muridKelas = muridKelas::where('kelas_id', $kelas_id)->first();
    }

    public function array(): array
    {
        $data = [];

        // Baris kosong 1-7
        for ($i = 0; $i < 7; $i++) {
            $data[] = array_fill(0, 5, ''); // 5 kolom: NO, NAMA, KELAS, NILAI, KETERANGAN
        }

        // Baris 8: Header
        $data[] = ['NO', 'NAMA', 'KELAS', 'NILAI', 'KETERANGAN'];

        // Data murid
        $muridArray = json_decode($this->muridKelas->murid, true);
        foreach ($muridArray as $i => $murid) {
            $nilai = $murid['nilai'] ?? '-';
            $keterangan = match ($nilai) {
                'A' => 'Sangat baik dan aktif dalam mengikuti materi ' . $this->kelas->program_belajar->nama_program,
                'B' => 'Baik dalam mengikuti materi ' . $this->kelas->program_belajar->nama_program,
                default => 'Belum Menyelesaikan Kelas',
            };

            $data[] = [
                $i + 1,
                $murid['nama'],
                $murid['kelas'],
                $nilai,
                $keterangan,
            ];
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $kolomTerakhir = 'E';

                // Judul Utama
                $sheet->mergeCells("A1:{$kolomTerakhir}3");
                $sheet->setCellValue('A1', "JURNAL NILAI SISWA\n" . $this->kelas->nama_kelas);
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

                // Program Belajar
                $sheet->setCellValue('A6', 'Program Belajar :');
                $sheet->mergeCells("B6:E6");
                $sheet->setCellValue('B6', $this->kelas->program_belajar->nama_program);
                $sheet->getStyle('A6')->applyFromArray(['font' => ['bold' => true]]);

                // Pengajar
                $sheet->setCellValue('A7', 'Penanggung Jawab :');
                $sheet->mergeCells("B7:E7");
                $sheet->setCellValue('B7', $this->kelas->pengajar->nama);
                $sheet->getStyle('A7')->applyFromArray(['font' => ['bold' => true]]);

                // Merge header baris 8
                foreach (range(1, 5) as $i) {
                    $col = Coordinate::stringFromColumnIndex($i);
                    $sheet->mergeCells("{$col}8:{$col}8");
                }

                // Style Header
                $sheet->getStyle("A8:E8")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '000000'],
                    ],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
                ]);

                // Style isi
                $jumlahBaris = count(json_decode($this->muridKelas->murid, true) ?? []) + 8;
                $sheet->getStyle("A9:A{$jumlahBaris}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("C9:E{$jumlahBaris}")->getAlignment()->setHorizontal('center')->setVertical('center');

                // Border
                $sheet->getStyle("A8:E{$jumlahBaris}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Auto size
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Nilai Siswa';
    }
}
