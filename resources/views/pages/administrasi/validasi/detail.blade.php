@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="{{ $indexPendaftaran->title }}" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">


                                    <div class="container my-3">
                                        <!-- Tombol atas -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <a href="{{ route('validasi.fix', ['code'=> $indexPendaftaran->code]) }}">
                                                <button class="btn btn-primary">Validasi Semua</button>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-success btn-filter"
                                                    data-target="pagado">{{ $count }} Mendaftar</button>
                                                <button type="button" class="btn btn-warning btn-filter"
                                                    data-target="pendiente">{{ \Carbon\Carbon::parse($indexPendaftaran->tanggal_p_awal)->format('d-m-Y') }}</button>
                                                <button type="button" class="btn btn-danger btn-filter"
                                                    data-target="cancelado">{{ \Carbon\Carbon::parse($indexPendaftaran->tanggal_p_akhir)->format('d-m-Y') }}</button>
                                                <button type="button" class="btn btn-info btn-filter"
                                                    data-target="all">{{ $indexPendaftaran->status_pendaftaran == 'open' ? 'OPEN' : 'CLOSED' }}</button>
                                            </div>
                                        </div>

                                        <table class="table table-bordered border-dark mt-2 mb-3 align-middle"
                                            id="example">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;" class="text-center">No.</th>
                                                    <th style="width: 20%;">Nama</th>
                                                    <th style="width: 15%;" class="text-center">Email</th>
                                                    <th style="width: 15%;" class="text-center">No.Wa</th>
                                                    <th style="width: 20%;" class="text-center">Sekolah</th>
                                                    <th style="width: 15%;" class="text-center">Status</th>
                                                    <th style="width: 10%;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script>
        $(document).ready(function() {

            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('validasi.show', ['validasi' => $id]) }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            return `<div class="text-center">${data}</div>`;
                        }
                    },
                    {
                        data: 'no_telp',
                        render: function(data, type, row) {
                            return `<div class="text-center fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="text-center fw-bold text-tabel">${data.sekolah.nama_sekolah}</div>`;
                        }
                    },
                    {
                        data: 'null',
                        render: function(data, type, row) {
                            return `<div class="text-center">
                                        <span class="bg-success text-white px-2 py-1 rounded fw-bold d-inline-block">
                                            Mendaftar
                                        </span>
                                    </div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-primary btn-sm px-2">
                                            <i class="fa-solid fa-clock"></i>
                                        </a>
                                        
                                        <a href="#" class="btn btn-danger btn-sm px-2">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                        `;
                        }
                    }

                ]
            });
        });
    </script>
@endsection
