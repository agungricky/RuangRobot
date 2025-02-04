@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif
    <!-- Custom Alert Notifikasi -->
    <x-sweetalert.success_custom text1="Berhasil!" text2="Pertemuan berhasil diupdate!" />

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Pembayaran Kelas" />

            <div class="section-body">
                {{-- Informasi Kelas --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="hero text-white hero-bg-image"
                            style="background-image: url({{ asset('img_videogaming.jpg') }}); padding:35px;">
                            <div class="hero-inner">
                                <h5>{{ $data->nama_kelas }}</h5>
                                <span class="badge badge-danger">{{ $data->kategori_kelas }}</span>
                                <span
                                    class="ml-2 badge {{ $data->status_kelas == 'aktif' ? 'badge-warning' : 'badge-success' }}">{{ $data->status_kelas }}</span>
                                <p class="lead">{{ $data->nama_program }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <style>
                                    .border-bottom {
                                        border-bottom: 2px solid #dbdbdb !important;
                                    }
                                </style>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-users"></i> Jumlah Siswa</b>
                                                <div class="profile-desc-item pull-right">{{ $jumlahSiswa }} Siswa</div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-user"></i> Penanggung Jawab Kelas </b>
                                                <div class="profile-desc-item pull-right">{{ $data->penanggung_jawab }}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-dollar-sign"></i> Harga Kelas </b>
                                                <div class="profile-desc-item pull-right text-success">Rp.
                                                    {{ number_format($data->harga, 0, ',', '.') }}
                                                </div>
                                            </li>
                                            <li class="list-group-item border-bottom d-flex gap-3">
                                                <div class="border-end border-1 pe-3">
                                                    <b><i class="fas fa-dollar-sign"></i> Rencana Pendapatan Kelas </b>
                                                    <div class="profile-desc-item pull-right">Rp.
                                                        {{ number_format($rencana_pendapatan, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <b><i class="fas fa-dollar-sign"></i> Total yang di dapat </b>
                                                    <div class="profile-desc-item pull-right">Rp.
                                                        {{ number_format($totalPembayaran, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tambah Siswa Kelas --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="data_siswa">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;" class="text-center">Nama Siswa</th>
                                                <th style="width: 15%;" class="text-center">Sekolah</th>
                                                <th style="width: 10%;" class="text-center">Tagihan</th>
                                                <th style="width: 10%;" class="text-center">Pembayaran</th>
                                                <th style="width: 10%;" class="text-center">Kekurangan</th>
                                                <th style="width: 10%;" class="text-center">Opsi</th>
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

    <!-- Modal edit pertemuan -->
    <div class="modal fade" id="tambahpembayaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Pembayaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_pertemuan_form">
                        @csrf
                        <x-form.input_number label="Tambah Pembayaran" name="tambah_pembayaran"
                            placeholder="Bayar Berapa?" />
                        <div id="tambah_pembayaranError" class="text-danger"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="Editsubmit" class="btn btn-success">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Menampilkan Tabel Siswa diKelas
            $('#data_siswa').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('pembayaran_murid.json', ['id' => $data->id]) }}",
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
                            return `<div class="text-start fw-bold text-primary">${data}</div>`;
                        }
                    },
                    {
                        data: 'sekolah',
                        render: function(data, type, row) {
                            return `<div class="text-body-secondary text-start">${data}</div>`;
                        }
                    },
                    {
                        data: 'tagihan',
                        render: function(data, type, row) {
                            const formattedCurrency = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                currencyDisplay: 'narrowSymbol',
                                minimumFractionDigits: 0
                            }).format(data);

                            return `<div class="text-success fw-bold">${formattedCurrency}</div>`;
                        }
                    },
                    {
                        data: 'pembayaran',
                        render: function(data, type, row) {
                            const formattedCurrency = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                currencyDisplay: 'narrowSymbol',
                                minimumFractionDigits: 0
                            }).format(data);

                            return `<div class="text-success fw-bold">${formattedCurrency}</div>`;
                        }
                    },
                    {
                        data: 'sisa_pembayaran',
                        render: function(data, type, row) {
                            const formattedCurrency = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                currencyDisplay: 'narrowSymbol',
                                minimumFractionDigits: 0
                            }).format(data);

                            return `<div class="text-success fw-bold">${formattedCurrency}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-success btn-sm" ' +
                                    'data-id="' + row.id + '" ' +
                                    'data-kelas-id="' + <?= $data->id ?> + '" ' +
                                    'data-bs-toggle="modal" data-bs-target="#tambahpembayaran">' +
                                    '<i class="fa fa-plus"></i> Bayar</button>';
                        }
                    }
                ]
            });
        });

        // Edit data Pertemuan 
        $(document).ready(function() {
            let selectedId = null;

            $(document).on('click', '#tambahpembayaran', function() {
                selectedId = $(this).data('id');
                console.log('ID yang dipilih:', selectedId);
            });

            // Ketika tombol Kirim ditekan
            $('#Editsubmit').on('click', function() {
                const pertemuanKe = $('input[name="pertemuan"]').val();

                $.ajax({
                    url: "{{ route('pembelajaran.update', ['id' => '__selectedId__']) }}"
                        .replace('__selectedId__',
                            selectedId), // Ubah URL dengan menggantikan selectedId
                    type: 'POST',
                    data: {
                        _method: 'PATCH',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        pertemuan: pertemuanKe,
                    },
                    success: function(response) {
                        $('#editPertemuanModal').modal('hide'); // Menutup modal

                        // Menampilkan notifikasi
                        const notification = $('<div>')
                            .text('Pertemuan berhasil diupdate!')
                            .css({
                                position: 'fixed',
                                top: '20px',
                                right: '20px',
                                padding: '10px 40px',
                                background: '#4CAF50',
                                color: '#fff',
                                borderRadius: '5px',
                                boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
                                zIndex: 9999,

                            })
                            .appendTo('body');

                        // Menghilangkan notifikasi setelah 3 detik dan reload halaman
                        setTimeout(function() {
                            notification.fadeOut(300, function() {
                                $(this).remove();
                                const form = $(
                                    '#edit_pertemuan_form');
                                form.trigger('reset');
                                location.reload();
                            });
                        }, 2000);
                    },
                    error: function(xhr) {
                        // alert(xhr.responseText);
                        const errors = xhr.responseJSON.errors;
                        if (errors.pertemuan) {
                            $('#pertemuanError').text(errors.pertemuan[0]);
                        }
                    },
                });
            });
        });
    </script>
@endsection
