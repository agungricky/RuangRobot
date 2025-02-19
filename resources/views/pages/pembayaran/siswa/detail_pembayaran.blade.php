@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Pembayaran Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                        </div>

                        <div class="m-0">
                            <div class="receipt-card">
                                @if ($data['status_pembayaran'] == 'Lunas')
                                    <div class="ribbon">LUNAS</div>
                                @endif
                                <div class="receipt-header">
                                    <h5>Ruang Robot</h5>
                                    <small class="receipt-address">
                                        Perum Mojoroto Indah No.T-24, Mojoroto, Kec. Mojoroto, Kota Kediri, Jawa Timur 64112
                                    </small>
                                </div>

                                <table class="receipt-table">
                                    <tr>
                                        <th class="title">Nomor Nota</th>
                                        <th class="titik">:</th>
                                        <td class="value">#{{$data['no_invoice']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="title">Nama</th>
                                        <th class="titik">:</th>
                                        <td class="value">{{$data['nama']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="title">Sekolah</th>
                                        <th class="titik">:</th>
                                        <td class="value">{{$data['sekolah']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="title">Tanggal</th>
                                        <th class="titik">:</th>
                                        <td class="value">{{ \Carbon\Carbon::parse($data['updated_at'])->translatedFormat('l, d-m-Y') }}</td>
                                    </tr>
                                </table>

                                <hr>

                                <table class="receipt-table">
                                    <tr>
                                        <th class="title">Nama Kelas</th>
                                        <th class="titik">:</th>
                                        <td class="value">{{$data['nama_kelas']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="title">Program Belajar</th>
                                        <th class="titik">:</th>
                                        <td class="value">{{$data['nama_program']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="title">Status Kelas</th>
                                        <th class="titik">:</th>
                                        <td class="value">{{$data['status_kelas']}}</td>
                                    </tr>
                                </table>

                                <hr>

                                <table class="receipt-table">
                                    <tr>
                                        <th class="title">Tagihan Kelas</th>
                                        <th class="titik">:</th>
                                        <td class="value">Rp. {{ number_format($data['tagihan'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="title">Terbayar</th>
                                        <th class="titik">:</th>
                                        <td class="value">Rp. {{ number_format($data['pembayaran'], 0, ',', '.') }}</td>
                                    </tr>
                                </table>

                                <hr>
                                <table class="receipt-table">
                                    <tr>
                                        <th class="status">Status</th>
                                        <th class="titik">:</th>
                                        <td class="total">{{$data['status_pembayaran']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="status">Total Kekurangan
                                        </th>
                                        <th class="titik">:</th>
                                        <td class="total">Rp. {{ number_format($data['kekurangan'], 0, ',', '.') }}</td>
                                    </tr>
                                </table>

                                <p class="thanks">Terima kasih Atas Kunjungan Anda!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style>
        .receipt-address {
            display: block;
            font-size: 13px;
            color: #555;
            text-align: center;
            margin-top: 5px;
            font-style: italic;
        }

        .receipt-card {
            max-width: 100%;
            padding: 20px;
            position: relative;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 2px solid #ddd;
        }

        .receipt-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding-bottom: 10px;
            border-bottom: 2px dashed #bbb;
        }

        /* Efek Sobekan */
        .receipt-card::before,
        .receipt-card::after {
            content: "";
            position: absolute;
            left: 0;
            width: 100%;
            height: 15px;
            background: white;
            z-index: 1;
        }

        .receipt-card::before {
            top: 0;
            border-bottom: 2px dashed #bbb;
            clip-path: polygon(0% 50%, 10% 100%, 20% 50%, 30% 100%, 40% 50%, 50% 100%, 60% 50%, 70% 100%, 80% 50%, 90% 100%, 100% 50%);
        }

        .receipt-card::after {
            bottom: 0;
            border-top: 2px dashed #bbb;
            clip-path: polygon(0% 50%, 10% 0%, 20% 50%, 30% 0%, 40% 50%, 50% 0%, 60% 50%, 70% 0%, 80% 50%, 90% 0%, 100% 50%);
        }

        /* Pita "LUNAS" */
        .ribbon {
            position: absolute;
            top: 20px;
            right: -50px;
            width: 150px;
            height: 30px;
            background: red;
            color: white;
            font-weight: bold;
            text-align: center;
            line-height: 30px;
            transform: rotate(45deg);
            font-size: 14px;
            text-transform: uppercase;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        }

        /* Tabel Nota */
        .receipt-table {
            width: 100%;
            margin-top: 10px;
        }

        .title {
            width: 30%;
        }

        .titik {
            padding: 0px 10px;
        }

        .value {
            width: 70%;
        }

        .status {
            width: 50% !important;
            font-size: 16px;
            font-weight: bold;
            color: black
        }

        .total {
            font-weight: bold;
            color: black
        }

        /* Pesan Terima Kasih */
        .thanks {
            text-align: center;
            margin-top: 15px;
            font-style: italic;
            color: #555;
        }

        @media (min-width: 768px) {
            .ribbon {
                position: absolute;
                top: 50px;
                right: -55px;
                width: 250px;
                font-size: 25px;
            }

            /* Tabel Nota */
            .receipt-table {
                width: 70%;
                margin-top: 10px;
            }

            .title {
                width: 20%;
            }

            .titik {
                padding: 0px 10px;
            }

            .value {
                width: 70%;
            }

            .status {
                width: 30% !important;
                font-size: 16px;
                font-weight: bold;
                color: black
            }

            .total {
                font-weight: bold;
                color: black
            }
        }
    </style>
@endsection
