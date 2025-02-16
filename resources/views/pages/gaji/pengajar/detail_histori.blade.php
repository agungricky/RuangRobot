@extends('main.layout')
@section('content')

    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Detail gajiii" />

            <div class="section-body mt-5">
                <h4 class="mb-3 text-primary">💰 Kalkulator Gaji</h4>

                <div class="card shadow-lg p-4">
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <span class="fw-bold">Gaji Mengajar</span>
                        <span class="text-success">Rp.
                            {{ number_format($gaji_pengajar['gaji_mengajar'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                        <span class="fw-bold">Gaji Transport</span>
                        <span class="text-success">Rp.
                            {{ number_format($gaji_pengajar['gaji_transport'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                        <span class="fw-bold">Gaji Custom</span>
                        <span class="text-success">Rp.
                            {{ number_format($gaji_pengajar['gaji_custom'], 0, ',', '.') }}</span>
                    </div>
                    @if (count($gaji_ditolak) != 0)
                        <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                            <span class="fw-bold">Gaji Mengajar Ditolak</span>
                            <span class="text-success">Rp.
                                {{ number_format($gaji_pengajar_ditolak['gaji_mengajar_ditolak'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if (count($transport_ditolak) != 0)
                        <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                            <span class="fw-bold">Gaji Transport Ditolak</span>
                            <span class="text-success">Rp.
                                {{ number_format($gaji_pengajar_ditolak['gaji_transport_ditolak'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if (count($custom_ditolak) != 0)
                        <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                            <span class="fw-bold">Gaji Custom Ditolak</span>
                            <span class="text-success">Rp.
                                {{ number_format($gaji_pengajar_ditolak['gaji_custom_ditolak'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="d-flex flex-column mt-3 p-2 bg-warning rounded">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-dark">Total Gaji Diterima :</span>
                            <span class="fw-bold text-dark">Rp.
                                {{ number_format($gaji_pengajar['total'], 0, ',', '.') }}</span>
                        </div>
                        @if (count($gaji_ditolak) != 0 || count($transport_ditolak) != 0 || count($custom_ditolak) != 0)
                            <hr class="border-1 p-0 my-1">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-dark">Total Gaji Ditolak :</span>
                                <span class="fw-bold text-dark">Rp.
                                    {{ number_format($gaji_pengajar_ditolak['total_ditolak'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Gaji Mengajar --}}
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
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                    </td>
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
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                    </td>
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
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                    </td>
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

            {{-- Gaji Ditolak --}}
            @if (count($gaji_ditolak) != 0)
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="add-items d-flex">
                                        <p class="fs-4">#Gaji Mengajar Ditolak</p>
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
                                                @foreach ($gaji_ditolak as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{!! 'Pertemuan ke ' . $item->pertemuan . '<br>' . $item->nama_kelas !!}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                        </td>
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
            @endif

            {{-- Gaji Transport Ditolak --}}
            @if (count($transport_ditolak) != 0)
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="add-items d-flex">
                                        <p class="fs-4">#Gaji Transport Ditolak</p>
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
                                                @foreach ($transport_ditolak as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{!! 'Pertemuan ke ' . $item->pertemuan . '<br>' . $item->nama_kelas !!}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                        </td>
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
            @endif

            {{-- Gaji Custom Ditolak --}}
            @if (count($custom_ditolak) != 0)
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
                                                @foreach ($custom_ditolak as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->keterangan }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                        </td>
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
            @endif
        </section>
    </div>
@endsection
