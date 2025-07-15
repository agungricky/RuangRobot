@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kategori Pekerjaan" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Kategori Pekerjaan" id="#form_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center align-middle"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 20%;" class="text-center">Nama Pekerjaan</th>
                                                <th style="width: 45%;" class="text-center">Keterangan</th>
                                                <th style="width: 20%;" class="text-center">Nominal Gaji</th>
                                                <th style="width: 10%;" class="text-start">Opsi</th>
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

    <!-- Modal -->
    <div class="modal fade" id="form_kelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Tipe Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0;">
                    <form id="kategoriForm" method="POST" class="d-flex flex-column gap-3">
                        @csrf
                        <div id="inputFieldsContainer" class="mb-0">
                            <x-form.input_text label="Nama Pekerjaan" name="nama_pekerjaan"
                                placeholder="Menyolder || Mengkabeli || dll" />
                            <div id="errornama_pekerjaan" class="text-danger"></div>
                        </div>
                        <div id="inputFieldsContainer" class="mb-0">
                            <x-form.input_text label="Keterangan" name="keterangan" placeholder="Masukan Keterangan" />
                            <div id="errorketerangan" class="text-danger"></div>
                        </div>
                        <div id="inputFieldsContainer" class="mb-0">
                            <label for="gaji" class="form-label">Nominal Gaji</label>
                            <input type="text" id="gaji" name="gaji" class="form-control"
                                placeholder="Masukan Nominal Gaji">
                            <div id="errornama_pekerjaan" class="text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer mt-3 pt-0">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="submitKategori" class="btn btn-success">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "/kategori_pekerjaan",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama_pekerjaan',
                        render: function(data) {
                            return `<div class="text-start text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'keterangan',
                        render: function(data) {
                            return `<div class="text-center text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'gaji',
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
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex gap-1">
                                    <a href="{{ url('/tipe_kelas/edit/${row.id}') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/tipe_kelas/delete/${row.id}') }}" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            `;
                        }
                    }

                ]
            });

            // Format Rupiah saat diketik
            $('#gaji').on('input', function() {
                let angka = $(this).val().replace(/[^,\d]/g, '');
                let split = angka.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                if (split[1] !== undefined) {
                    rupiah += ',' + split[1];
                }

                $(this).val('Rp ' + rupiah);
            });

            // Menambahkan Data via AJAX
            $('#submitKategori').on('click', function() {
                // 🔥 Bersihkan nilai sebelum dikirim
                let angkaMurni = $('#gaji').val().replace(/[^0-9]/g, '');
                $('#gaji').val(angkaMurni); // ubah input jadi angka murni

                let form = $('#kategoriForm'); // Tangkap form
                let formData = form.serialize(); // Ambil data dari form

                $.ajax({
                    type: "POST",
                    url: "{{ route('kategori_pekerjaan.store') }}",
                    data: formData,
                    success: function(response) {
                        form.trigger('reset'); // Reset form
                        $('#form_kelas').modal('hide'); // Tutup modal
                        location.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += '<p>' + errors[key].join(', ') + '</p>';
                            }
                        }

                        $('#errorMessages').html(errorMessages);
                    }
                });
            });

        });
    </script>
@endsection
