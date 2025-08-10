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
                                <div class="add-items d-flex">
                                    {{-- <x-button.button_add_modal message="Tambah Sekolah" id="#form_sekolah" /> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example" data-page-length="25">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 20%;">Nama Pengajar</th>
                                                <th style="width: 25%;" class="text-center">Total Belum Terbayar</th>
                                                <th style="width: 60%;">Aksi</th>
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
                    url: "{{ route('gaji.json') }}",
                    dataSrc: function(response) {
                        // console.log("Data dari API:", response); // Cek apakah API merespon dengan benar
                        // console.log("Total Gaji:", response.total_gaji); // Cek isi total_gaji
                        return response.total_gaji; // Pastikan hanya mengembalikan array data
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama',
                        render: function(data) {
                            return `<div class="text-start fw-bold text-tabel">${data}</div>`;
                        }
                    },
                    {
                        data: 'total',
                        render: function(data) {
                            return `<div class="text-center fw-bold text-tabel text-success">Rp. ${parseInt(data || 0, 10).toLocaleString()}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="d-flex justify-content-start align-items-center"><a href="{{ url('detail/gaji/${row.id}') }}" class="btn btn-success btn-sm">Selengkapnya</a></div>`;
                        }
                    }
                ]
            });

        });
    </script>
@endsection
