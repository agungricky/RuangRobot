@extends('main.layout')
@section('content')
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Riwayat Gaji" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="resume-box">
                            <ul>
                                @foreach ($data as $list_gajian)
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <span
                                            class="time">{{ \Carbon\Carbon::parse($list_gajian->tanggal_terbayar)->translatedFormat('l, d F Y') }}</span>
                                        <h5 class="m-0 p-0">Gaji diterima - 
                                            <a
                                                href="{{ route('detail.riwayat.histori', ['id' => $dataLogin->id, 'idtanggal' => $list_gajian->id]) }}">
                                                Lihat Detail
                                            </a>
                                        </h5>
                                        <p style="text-align: justify;" class="mt-1">Halo {{$dataLogin->nama}} Gaji kamu sudah di bayarkan ya pada tanggal <span class="text-nowrap">{{ \Carbon\Carbon::parse($list_gajian->tanggal_terbayar)->translatedFormat('d F Y') }}</span> kemarin 😊.</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    </div>

    <style>
        .resume-box {
            background: #ffffff;
            box-shadow: 0 0 1.25rem rgba(31, 45, 61, 0.08);
            border-radius: 10px;
            position: relative;
        }

        .resume-box ul {
            margin: 0;
            padding: 30px 20px;
            list-style: none;
            position: relative;
        }

        .resume-box ul::before {
            content: "";
            position: absolute;
            top: 60px;
            /* Jarak dari atas supaya tidak menyentuh ikon pertama */
            bottom: 0;
            left: 40px;
            width: 1px;
            border-left: 1px dashed #537afc;
            z-index: 0;
        }

        .resume-box li {
            position: relative;
            padding: 0 20px 0 60px;
            margin: 0 0 30px;
        }

        .resume-box li:last-child {
            margin-bottom: 0;
        }

        .resume-box li::after {
            content: none;
        }

        .resume-box .icon {
            width: 40px;
            height: 40px;
            position: absolute;
            left: 0;
            right: 0;
            color: #5364fc;
            line-height: 40px;
            background: #ffffff;
            text-align: center;
            z-index: 1;
            border: 1px dashed;
            border-radius: 50%;
        }

        .resume-box .time {
            background: #5388fc;
            color: #ffffff;
            font-size: 10px;
            padding: 2px 10px;
            display: inline-block;
            margin-bottom: 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .resume-box h5, .resume-box a {
            font-weight: 700;
            color: #20247b;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .resume-box p {
            margin: 0;
        }
    </style>
@endsection
