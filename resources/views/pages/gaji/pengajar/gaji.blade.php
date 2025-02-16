@extends('main.layout')
@section('content')

    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Detail gaji" />

            <div class="section-body mt-5">
                    <h4 class="mb-3 text-primary">💰 Kalkulator Gaji</h4>
                
                    <div class="card shadow-lg p-4">
                        <div class="d-flex justify-content-between border-bottom pb-2">
                            <span class="fw-bold">Gaji Mengajar</span>
                            <span class="text-success">Rp. {{ number_format($gaji_pengajar['gaji_mengajar'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                            <span class="fw-bold">Gaji Transport</span>
                            <span class="text-success">Rp. {{ number_format($gaji_pengajar['gaji_transport'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                            <span class="fw-bold">Gaji Custom</span>
                            <span class="text-success">Rp. {{ number_format($gaji_pengajar['gaji_custom'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-3 p-2 bg-warning rounded">
                            <span class="fw-bold text-dark">Total Gaji Diterima :</span>
                            <span class="fw-bold text-dark">Rp. {{ number_format($gaji_pengajar['total'], 0, ',', '.') }}</span>
                        </div>
                        <div class="alert alert-danger d-flex align-items-center p-2 mt-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <small>Gaji ini belum fix, belum diverifikasi, dan masih bersifat pending.</small>
                        </div>
                    </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <p class="fs-4">#Gaji Mengajar</p>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%;" class="text-center">No.</th>
                                                <th style="width: 15%;">Nama Pengajar</th>
                                                <th style="width: 25%;" class="text-center">Kelas</th>
                                                <th style="width: 15%;">Tanggal</th>
                                                <th style="width: 10%;" class="text-center">Status Pengajar</th>
                                                <th style="width: 15%;" class="text-start">Gaji Mengajar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($gaji as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{!! 'Pertemuan ke ' . $item->pertemuan . '<br>' . $item->nama_kelas !!}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}</td>
                                                    <td>{{ $item->status_pengajar }}</td>
                                                    <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gaji Transport --}}
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <p class="fs-4">#Gaji Transport</p>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%;" class="text-center">No.</th>
                                                <th style="width: 15%;">Nama Pengajar</th>
                                                <th style="width: 25%;" class="text-center">Kelas</th>
                                                <th style="width: 15%;">Tanggal</th>
                                                <th style="width: 10%;" class="text-center">Status Pengajar</th>
                                                <th style="width: 15%;" class="text-start">Gaji Mengajar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($transport as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{!! 'Pertemuan ke ' . $item->pertemuan . '<br>' . $item->nama_kelas !!}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}</td>
                                                    <td>{{ $item->status_pengajar }}</td>
                                                    <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Gaji Custom --}}
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <p class="fs-4">#Gaji Custom</p>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%;" class="text-center">No.</th>
                                                <th style="width: 8%;">Nama Pengajar</th>
                                                <th style="width: 25%;" class="text-center">Keterangan</th>
                                                <th style="width: 10%;" class="text-start">Tanggal</th>
                                                <th style="width: 10%;" class="text-center">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($custom as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}</td>
                                                    <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
