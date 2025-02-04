@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Pembayaran Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;" class="text-center">Nama Kelas</th>
                                                <th style="width: 15%;" class="text-center">Jenis Kelas</th>
                                                <th style="width: 15%;" class="text-center">Status Kelas</th>
                                                <th style="width: 10%;" class="text-center">Dibuat Tanggal</th>
                                                <th style="width: 20%;" class="text-center">Opsi</th>
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
                    url: "{{ route('kelas.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama_kelas',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold text-start text-justify">${data}</div>`;
                        }
                    },
                    {
                        data: 'kategori_kelas',
                        render: function(data, type, row) {
                            return `<div class="text-center text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'status_kelas',
                        render: function(data, type, row) {
                            if (data == 'aktif') {
                                color = 'primary';
                            } else if (data == 'selesai') {
                                color = 'success';
                            }
                            return `<div class="text-center level"><span class="level bg-${color}">${data}</span></div>`;
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            var date = new Date(data);
                            var day = String(date.getDate()).padStart(2, '0');
                            var month = String(date.getMonth() + 1).padStart(2, '0');
                            var year = date.getFullYear();
                            return `<div class="text-center text-tabel fw-bold">${day}-${month}-${year}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                    <a href="{{ url('/pembayaran/detail/${row.id}') }}" class="btn btn-success btn-sm m-auto"><i class="fa-solid fa-arrow-right fa-lg"></i>Selengkapnya</a>
                            </div>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
