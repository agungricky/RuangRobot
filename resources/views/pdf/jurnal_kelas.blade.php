<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data->nama_kelas }}</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        table th {
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 15px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <center>
        <h3 style="text-transform: uppercase">Jurnal Kelas {{ $data->nama_kelas }}</h3>
    </center>
    <center>
        <h4>Ruang Robot Perum Mojoroto Indah Blok AA-6, Kota Kediri 085655770506</h4>
    </center>
    <hr>

    <table style="border:0px !important;">
        <tr>
            <td style="width: 100px;font-size: 19px;white-space: nowrap;">
                Program Belajar
            </td>
            
            <td>: {{ $data->nama_program }}</td>
        </tr>
        <tr>
            <td style="width: 100px;font-weoght:bold;font-size:19px;">Pengajar</td>
            <td>: {{ $data->penanggung_jawab }}</td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pertemuan ke</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Materi</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($data_pertemuan)}} --}}
            @foreach ($data_pertemuan as $item)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->pertemuan }}</td>
                    <td>
                        @php
                            $daftar_hari = [
                                'Sunday' => 'Minggu',
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                            ];
    
                            // Validasi tanggal sebelum digunakan
                            if (!empty($item->tanggal)) {
                                $namahari = date('l', strtotime($item->tanggal));
                                echo $daftar_hari[$namahari] . ', ' . date('d-m-Y', strtotime($item->tanggal));
                            } else {
                                echo '-'; // Tampilkan '-' jika tanggal kosong
                            }
                        @endphp
                    </td>
                    <td>
                        {{-- Tampilkan jam jika ada --}}
                        {{ $item->durasi_belajar }}
                    </td>
                    <td>{{ $item->materi ?: '-' }}</td>
                    <td></td> <!-- Kolom tanda tangan -->
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="page-break-after: always;"></div>
    <center>
        <h3>Absensi Siswa</h3>
    </center>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            @foreach ($absensi_siswa as $key => $item)
                <th>#{{ $item->pertemuan }}</th>
            @endforeach
        </tr>
    
        @php
            // Menyusun data siswa yang unik berdasarkan id
            $siswaUnik = [];
            foreach ($absensi_siswa as $item) {
                foreach ($item->absensi as $absen) {
                    if (!isset($siswaUnik[$absen['id']])) {
                        $siswaUnik[$absen['id']] = [
                            'nama' => $absen['nama'],
                            'id' => $absen['id'],
                        ];
                    }
                }
            }
    
            // Menyusun ulang data untuk tampilan
            $no = 1;
        @endphp
    
        @foreach ($siswaUnik as $siswa)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $siswa['nama'] }}</td>
                @foreach ($absensi_siswa as $pertemuan)
                    @php
                        $presensi = '-';
                        foreach ($pertemuan->absensi as $absen) {
                            if ($absen['id'] === $siswa['id']) {
                                $presensi = $absen['presensi'];
                                break;
                            }
                        }
    
                        // Tentukan warna latar berdasarkan presensi
                        $bgColor = '';
                        if ($presensi === 'H') {
                            $bgColor = '#28a745';
                        } elseif ($presensi === 'I') {
                            $bgColor = '#F93827';
                        }
                    @endphp
                    <td style="background-color: {{ $bgColor }}; color: white;">
                        {{-- {{ $presensi }} --}}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
        
</body>

</html>
