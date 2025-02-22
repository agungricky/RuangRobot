@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Gaji Saya" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    {{-- <x-button.button_add_modal message="Tambah Sekolah" id="#form_sekolah" /> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 20%;">Tanggal gajian</th>
                                                <th style="width: 10%;">Aksi</th>
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
                    url: "{{ route('gaji_saya.json') }}",
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
                        data: 'taggal_terbayar',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">Rp. 0</>`;
                        }
                    },
                    {
                        data: 'null',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">Rp. 0</>`;
                        }
                    },
                    {
                        data: 'null',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">Rp. 0</>`;
                        }
                    },
                    {
                        data: 'null',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">Rp. 0</>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-success btn-sm">Selengkapnya</button>
                            </div>
                        `;
                        }

                    }
                ]
            });

            // Menambahkan Data
            $('#submit_sekolah').on('click', function() {
                let form = $('#sekolah_form'); // Tangkap form
                let formData = form.serialize(); // Ambil data dari form

                $.ajax({
                    type: "POST",
                    url: "{{ route('sekolah.store') }}", // Pastikan rutenya sesuai
                    data: formData,
                    success: function(response) {
                        form.trigger('reset'); // Reset form setelah berhasil
                        $('#form_sekolah').modal('hide'); // Tutup modal
                        location.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors; // Ambil error dari response JSON

                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                let errorMessage = errors[key].join(', ');
                                $('#error-' + key).text(errorMessage);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
