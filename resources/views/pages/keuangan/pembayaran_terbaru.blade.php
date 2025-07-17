@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Pembayaran Terbaru" />

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
                                                <th style="width: 20%;" class="text-center">Nama Siswa</th>
                                                <th style="width: 45%;" class="text-center">Kelas di ikuti</th>
                                                <th style="width: 15%;" class="text-center">Nominal</th>
                                                <th style="width: 15%;" class="text-center">Tanggal</th>
                                                <th style="width: 20%;" class="text-center">Keterangan</th>
                                                <th style="width: 10%;" class="text-start">Metode Pembayaran</th>
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
                    url: "/pembayaran_terbaru",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="text-start text-tabel fw-bold">${data.pengguna.nama}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="text-start text-tabel fw-bold">${data.kelas.nama_kelas}</div>`;
                        }
                    },
                    {
                        data: 'nominal',
                        render: function(data) {
                            let rupiah = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(data);

                            return `<div class="text-center text-tabel fw-bold">${rupiah}</div>`;
                        }
                    },
                    {
                        data: 'tanggal',
                        render: function(data) {
                            const tanggal = new Date(data);
                            const tanggalFormatted = tanggal.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                            return `<div class="text-center text-tabel fw-bold">${tanggalFormatted}</div>`;
                        }
                    },
                    {
                        data: 'jenis_pembayaran',
                        render: function(data) {
                            return `<div class="text-start text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'metode_pembayaran',
                        render: function(data) {
                            return `<div class="text-center text-tabel fw-bold">${data}</div>`;
                        }
                    },
                ]
            });
        });
    </script>
@endsection
