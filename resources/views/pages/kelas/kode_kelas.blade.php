@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Info Kode Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center align-middle"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;" class="text-center">Nama Kelas</th>
                                                <th style="width: 10%;" class="text-center">Kategori</th>
                                                <th style="width: 10%;" class="text-center">Status Kelas</th>
                                                <th style="width: 25%;" class="text-center">Kode Kelas</th>
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
                    url: `/info_kodeKelas/{{ $kategori_id }}`,
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
                        render: function(data, type, row, meta) {
                            return `<div class="text-start fw-bold text-tabel">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `
                                <div class="text-center">
                                    <span class="badge text-white px-3 py-2 rounded-pill fw-bold"
                                          style="background-color: ${data.kategori.color_bg};">
                                        ${data.kategori.kategori_kelas}
                                    </span>
                                </div>
                            `;

                        }
                    },
                    {
                        data: 'status_kelas',
                        render: function(data, type, row, meta) {
                            let badgeClass = 'bg-secondary';

                            if (data === 'aktif') {
                                badgeClass = 'bg-success';
                            } else if (data === 'selesai') {
                                badgeClass = 'bg-danger';
                            }

                            return `
                                <div class="text-center">
                                    <span class="badge ${badgeClass} text-white px-3 py-2 rounded-pill fw-bold">
                                        ${data}
                                    </span>
                                </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center fw-bold text-tabel">Rahmat123</div>`;
                        }
                    },
                ]
            });
        });
    </script>
@endsection
