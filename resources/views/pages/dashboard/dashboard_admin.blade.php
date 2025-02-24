@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Dashboard Admin"/>

            <div class="section-body">
                <div class="row">
                    <x-card_dashboard style="card-icon bg-success" icon="fas fa-users" titlecard="Siswa" value="{{$total['siswa']}}"/>
                    <x-card_dashboard style="card-icon bg-primary" icon="far fa-user" titlecard="Pengajar" value="{{$total['pengajar']}}"/>
                    <x-card_dashboard style="card-icon bg-danger" icon="far fa-newspaper" titlecard="Kelas" value="{{$total['kelas']}}"/>
                    <x-card_dashboard style="card-icon bg-warning" icon="fas fa-money-bill-alt" titlecard="Income" value="0"/>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pembayaran Terbaru</h4>
                                <div class="card-header-action">
                                    <a href="" class="btn btn-danger">Selengkapnya <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
                                            </tr>
                                            {{-- @foreach ($pembayaran as $item)
                                                <tr>
                                                    <td><a class="font-weight-bold"
                                                            href="{{ route('admin.detail-pembayaran', $item->id_selected_class) }}">{{ Ceksiswa::cek_nama_siswa($item->id_selected_class) }}</a>
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'Menunggu Konfirmasi')
                                                            <span
                                                                class="text-dark badge badge-warning badge-pill">{{ $item->status }}</span>
                                                        @elseif ($item->status == 'Pembayaran Diterima')
                                                            <span class="badge badge-success badge-pill">{{ $item->status }}</span>
                                                        @elseif ($item->status == 'Pembayaran Ditolak')
                                                            <span class="badge badge-danger badge-pill">{{ $item->status }}</span>
                                                        @endif
                                                    </td>
                                                    <th>{{ date('d-m-Y', strtotime($item->tanggal_bayar)) }}</th>
                                                    <td class="font-weight-bold text-success">+{{ number_format($item->jumlah) }}</td>
                                                </tr>
                                            @endforeach --}}
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header">
                                <h4>Laporan Keuangan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tabelpemb">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Pendapatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($pembayaran_report as $key => $item)
                                                <tr class="font-weight-bold">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->month . ' / ' . $item->year }}</td>
                                                    <td class="text-success">Rp {{ number_format($item->data) }}</td>
                                                </tr>
                                            @endforeach --}}
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-hero">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="far fa-question-circle"></i>
                                </div>
                                <h4>Absen Terbaru</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="tickets-list">
                                    @foreach ($absenTerbaru as $item)
                                        <div class="ticket-item">
                                            <div class="ticket-title">
                                                <h4 class="text-primary">{{ $item->nama_kelas }}</h4>
                                            </div>
                                            <div class="ticket-info">
                                                <div>{{ $item->pengajar }}</div>
                                                <div class="bullet"></div>
                                                <div>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d,m,Y') }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
