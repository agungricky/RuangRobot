<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi : {{ $data->nama_kelas }}</title>
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
            <td style="width: 100px;font-weoght:bold;font-size:19px;">Program Belajar</td>
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
                    <td>{{ $item->pertemuan }}</td>
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
                        {{ $item->jamm ?? '-' }} - {{ $item->jams ?? '-' }}
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
    {{-- <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            @foreach ($slot_kelas as $key => $item)
                <th>#{{ $key + 1 }}</th>
            @endforeach
        </tr>
        @foreach ($siswa as $ki => $item)
            <tr>
                <td>{{ $ki + 1 }}</td>
                <td>{{ $item->nama_siswa }}</td>
                @foreach ($slot_kelas as $key => $items)
                    {{ Ceksiswa::cekabsenaa($item->id, $items->id) }}
                @endforeach
            </tr>
        @endforeach
    </table> --}}
</body>

</html>
