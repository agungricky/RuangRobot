@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Gaji Mengajar -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Detail gaji" />

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
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 30%;">Nama Pengajar</th>
                                                <th style="width: 35%;">Kelas</th>
                                                <th style="width: 10%;">Tanggal</th>
                                                <th style="width: 10%;" class="text-center">Status Pengajar</th>
                                                <th style="width: 10%;" class="text-start">Gaji Mengajar</th>
                                                <th style="width: 60%;">Aksi</th>
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
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->status_pengajar }}</td>
                                                    <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                    @if ($item->status == 'pending')
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <form
                                                                    action="{{ route('gaji.verifikasi', ['id' => $item->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" value="diverifikasi"
                                                                        name="status">
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-check"></i> Verifikasi
                                                                    </button>
                                                                </form>

                                                                <form
                                                                    action="{{ route('gaji.verifikasi', ['id' => $item->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" value="ditolak" name="status">
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    @if ($item->status == 'diverifikasi')
                                                        <td>Terverifikasi</td>
                                                    @endif
                                                    @if ($item->status == 'ditolak')
                                                        <td>Ditolak</td>
                                                    @endif
                                                    @if ($item->status == 'dibayar')
                                                        <td>Terbayar</td>
                                                    @endif
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
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;">Nama Pengajar</th>
                                                <th style="width: 55%;">Kelas</th>
                                                <th style="width: 25%;">Tanggal</th>
                                                <th style="width: 15%;" class="text-center">Status Pengajar</th>
                                                <th style="width: 15%;" class="text-start">Gaji Mengajar</th>
                                                <th style="width: 60%;">Aksi</th>
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
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->status_pengajar }}</td>
                                                    <td>{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                    @if ($item->status == 'pending')
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <form
                                                                    action="{{ route('transport.verifikasi', ['id' => $item->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" value="diverifikasi"
                                                                        name="status">
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-check"></i> Verifikasi
                                                                    </button>
                                                                </form>

                                                                <form
                                                                    action="{{ route('transport.verifikasi', ['id' => $item->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" value="ditolak" name="status">
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    @if ($item->status == 'diverifikasi')
                                                        <td>Terverifikasi</td>
                                                    @endif
                                                    @if ($item->status == 'ditolak')
                                                        <td>Ditolak</td>
                                                    @endif
                                                    @if ($item->status == 'dibayar')
                                                        <td>Terbayar</td>
                                                    @endif
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
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 20%;">Nama Pengajar</th>
                                                <th style="width: 15%;" class="text-start">Tanggal</th>
                                                <th style="width: 15%;" class="text-center">Keterangan</th>
                                                <th style="width: 15%;" class="text-center">Nominal</th>
                                                <th style="width: 10%;">Aksi</th>
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
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                    @if ($item->status == 'pending')
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <form
                                                                    action="{{ route('custom.verifikasi', ['id' => $item->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" value="diverifikasi"
                                                                        name="status">
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-check"></i> Verifikasi
                                                                    </button>
                                                                </form>

                                                                <form
                                                                    action="{{ route('custom.verifikasi', ['id' => $item->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" value="ditolak" name="status">
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    @if ($item->status == 'diverifikasi')
                                                        <td>Terverifikasi</td>
                                                    @endif
                                                    @if ($item->status == 'ditolak')
                                                        <td>Ditolak</td>
                                                    @endif
                                                    @if ($item->status == 'dibayar')
                                                        <td>Terbayar</td>
                                                    @endif
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

            {{-- Kalkulator Gaji --}}
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2">
                                    <form action="{{ route('gaji.terbayar', ['id'=> $data->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="dibayar">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-money-bill-wave"></i> Tandai Telah Dibayar
                                        </button>
                                    </form>
                                </div>
                                <div class="table-responsive d-flex gap-4">
                                    <table class="table table-bordered border-dark mt-2 mb-3 w-50" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;">Nama Gaji</th>
                                                <th style="width: 25%;">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>Gaji Mengajar</td>
                                                <td>Rp. {{ number_format($gaji_pengajar['gaji_mengajar'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>Gaji Transport</td>
                                                <td>Rp. {{ number_format($gaji_pengajar['gaji_transport'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>Gaji Custom</td>
                                                <td>Rp. {{ number_format($gaji_pengajar['gaji_custom'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold">Total Gaji diterima :</td>
                                                <td class="fw-bold">Rp.
                                                    {{ number_format($gaji_pengajar['total'], 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>


                                    <table class="table table-bordered border-dark mt-2 mb-3 w-50" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;">Nama Gaji</th>
                                                <th style="width: 25%;">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>Gaji Mengajar</td>
                                                <td>Rp. {{ number_format($gaji_ditolak['gaji_mengajar'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>Gaji Transport</td>
                                                <td>Rp. {{ number_format($gaji_ditolak['gaji_transport'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>Gaji Custom</td>
                                                <td>Rp. {{ number_format($gaji_ditolak['gaji_custom'], 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold">Total Gaji ditolak :</td>
                                                <td class="fw-bold">Rp.
                                                    {{ number_format($gaji_ditolak['total'], 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
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
