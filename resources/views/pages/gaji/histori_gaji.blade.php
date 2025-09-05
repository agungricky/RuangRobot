@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Gaji Pengajar" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 align-middle" id="example"
                                        data-page-length="25">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 15%;">Tanggal Histori</th>
                                                <th style="width: 20%;">Nama</th>
                                                <th style="width: 80%;">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
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
                    url: "{{ route('histori_gaji') }}",
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'tanggal_terbayar',
                        render: function(data) {
                            return `<div class="text-start fw-bold text-tabel">${moment(data).format('DD-MM-YYYY')}</div>`;
                        }
                    },
                    {
                        data: 'nama',
                        render: function(data) {
                            return `<div class="text-start fw-bold text-tabel">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="d-flex justify-content-start align-items-center"><a href="{{ url('/detail/histori/${row.pengajar}/${row.id}') }}" class="btn btn-success btn-sm">Selengkapnya</a></div>`;
                        }
                    }
                ]
            });

        });
    </script>
@endsection
