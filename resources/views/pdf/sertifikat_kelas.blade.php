<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100%;
            position: relative;
            background-color: brown
        }

        /* .certificate {
            position: relative;
            width: 100%;
            height: 100%;
        } */

        /* .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            z-index: -1;
        } */
/* 

        .content {
            position: relative;
            z-index: 1;
            padding: 50px;
        }

        .nomor_sertif {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 18px;
            margin-top: 20px;
        }

        .name {
            font-size: 30px;
            font-weight: bold;
            margin-top: 20px;
        }

        .description {
            margin-top: 20px;
            font-size: 18px;
        }

        .grade {
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
        }

        .date {
            margin-top: 30px;
        }

        .issuer {
            margin-top: 20px;
            font-size: 18px;
        } */
    </style>
</head>

<body>
    <div class="certificate">
        <!-- Gambar latar belakang -->
        <img class="background" src="{{ public_path('sertifikat.jpg') }}" alt="Sertifikat Background">

        <!-- Konten sertifikat -->
        <div class="content">
            {{-- {{dd($data)}} --}}
            <div class="nomor_sertif">
                {{ $data['no_sertifikat'] }}
            </div>
            {{-- <div class="subtitle">
                DIBERIKAN KEPADA:
            </div>
            <div class="name">
                {{ $data['nama_siswa'] }}
            </div>
            <div class="description">
                Telah menyelesaikan pelatihan {{ $program_belajar }} di Ruang Robot yang dilaksanakan pada tanggal {{ $tanggal_mulai }} - {{ $tanggal_selesai }} dengan predikat
            </div>
            <div class="grade">
                {{ $predikat }}
            </div>
            <div class="date">
                Kediri, {{ $tanggal_sertifikat }}
            </div>
            <div class="issuer">
                Ruang Robot
            </div> --}}
        </div>
    </div>
</body>

</html>
