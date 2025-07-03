@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Validasi Pendaftaran" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 align-middle" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 50%;">Judul Form</th>
                                                <th style="width: 15%;" class="text-center">Kategori</th>
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
        </section>
    </div>

    <script>
        $(document).ready(function() {

            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('validasi.index') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'title',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="text-center">${data.kategori.kategori_kelas}</div>`;
                        }
                    },
                    {
                        data: 'status_pendaftaran',
                        render: function(data, type, row) {
                            return `<div class="text-center fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                           <div class="d-flex gap-1">
                                <a href="{{url('/validasi/${data.id}')}}" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-eye"></i>
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
