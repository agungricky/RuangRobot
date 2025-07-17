@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
           <x-title_halaman title="Periode {{ \Carbon\Carbon::parse($indexKeuangan->created_at)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($indexKeuangan->updated_at)->translatedFormat('d F Y') }}" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- <div class="add-items d-flex">
                                    <button type="button" class="add btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#modalPembayaran">
                                        <i class="fas fa-plus"></i> Tambah Pembayaran
                                    </button>
                                </div> --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center align-middle"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 20%;" class="text-center">Tipe</th>
                                                <th style="width: 45%;" class="text-center">Keterangan</th>
                                                <th style="width: 15%;" class="text-center">Tanggal</th>
                                                <th style="width: 15%;" class="text-center">Nominal</th>
                                                <th style="width: 10%;" class="text-start">Metode Pembayaran</th>
                                                <th style="width: 20%;" class="text-center">Saldo Terakhir</th>
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

    <!-- Modal Tambah Pembayaran -->
    <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formPembayaran">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Tambah Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label for="tipe" class="form-label">Tipe</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="text" id="nominal_view" class="form-control" required>
                            <input type="hidden" name="nominal" id="nominal" />
                        </div>
                        <div class="col-md-4">
                            <label for="metode" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "/riwayat_periode/{{$id}}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'tipe',
                        render: function(data) {
                            if (data === 'Pemasukan') {
                                return `<div class="text-center text-tabel fw-bold text-success">
                                            <i class="fa-solid fa-arrow-up me-1"></i> ${data}
                                        </div>`;
                            } else {
                                return `<div class="text-center text-tabel fw-bold text-danger">
                                            <i class="fa-solid fa-arrow-down me-1"></i> ${data}
                                        </div>`;
                            }
                        }
                    },
                    {
                        data: 'keterangan',
                        render: function(data) {
                            return `<div class="text-start text-tabel fw-bold">${data}</div>`;
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
                        data: 'metode_pembayaran',
                        render: function(data) {
                            return `<div class="text-center text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'saldo_akhir',
                        render: function(data) {
                            let rupiah = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(data);

                            return `<div class="text-center text-tabel fw-bold">${rupiah}</div>`;
                        }
                    }
                ]
            });

            // $('#formPembayaran').on('submit', function(e) {
            //     e.preventDefault();
            //     let formData = $(this).serialize();
            //     let form = $('#formPembayaran');

            //     $.ajax({
            //         type: 'POST',
            //         url: '/tambah_pembayaran/store',
            //         data: formData,
            //         success: function(res) {
            //             form.trigger('reset');
            //             $('#modal_pengguna').modal('hide');
            //             location.reload();
            //         },
            //         error: function(err) {
            //             alert('Gagal menyimpan data!');
            //         }
            //     });
            // });

            // // Format Rupiah saat diketik
            // $('#nominal_view').on('input', function() {
            //     let angka = $(this).val().replace(/[^,\d]/g, '');
            //     let split = angka.split(',');
            //     let sisa = split[0].length % 3;
            //     let rupiah = split[0].substr(0, sisa);
            //     let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            //     if (ribuan) {
            //         let separator = sisa ? '.' : '';
            //         rupiah += separator + ribuan.join('.');
            //     }

            //     if (split[1] !== undefined) {
            //         rupiah += ',' + split[1];
            //     }

            //     $(this).val('Rp ' + rupiah);

            //     // simpan angka murni ke hidden input
            //     let angkaMurni = angka.replace(/[^0-9]/g, '');
            //     $('#nominal').val(angkaMurni);
            // });

        });
    </script>
@endsection
