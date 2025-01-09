@extends('main.layout')
@section('content')
    <style>
        #example_wrapper {
            margin-bottom: 30px;
        }

        .level {
            display: inline-block;
            color: white;
            width: 60px;
            padding: 3px;
            border-radius: 10px;
            font-size: 14px;
            text-align: center;
            border: none;
            cursor: pointer;
        }
    </style>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Program Belajar" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Kelas" id="#form_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 10%;" class="text-center">Nama Program</th>
                                                <th style="width: 10%;" class="text-center">Harga</th>
                                                <th style="width: 20%;" class="text-center">Deskripsi</th>
                                                <th style="width: 10%;" class="text-center">Level</th>
                                                <th style="width: 10%;" class="text-center">Jenis Kelas</th>
                                                <th style="width: 15%;" class="text-center">Poin</th>
                                                <th style="width: 10%;" class="text-center">Aksi</th>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Sekolah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div id="inputFieldsContainer">
                            <div class="mb-3">
                                <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                                <div class="field d-flex gap-1">
                                    <input type="text" class="form-control border-2" id="nama_sekolah"
                                        name="nama_sekolah" required>
                                    <button type="button" class="btn btn-danger removefield">X</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-info" id="addfild">Tambah Form</button>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success">Kirim</button>
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
                    url: "{{ route('program_belajar.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama_program',
                        render: function(data, type, row) {
                            return `<div class="fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'harga',
                        render: function(data, type, row) {
                            return `<div class="text-success fw-bold">${new Intl.NumberFormat('id-ID', {
                                    style: 'currency', currency: 'IDR'}).format(data)}</div>`;
                        }
                    }, {
                        data: 'deskripsi'
                    },
                    {
                        data: 'level',
                        render: function(data, type, row) {
                            if (data == 'mudah') {
                                color = 'success';
                            }
                            if (data == 'sedang') {
                                color = 'warning';
                            } else if (data == 'sulit') {
                                color = 'danger';
                            }
                            return `<div class="text-center level"><span class="level bg-${color}">${data}</span></div>`;
                        }
                    },
                    {
                        data: 'jenis_kelas'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <div class="text-center text-nowrap text-success fw-bold">
                                        M${row.mekanik} &#8226; E${row.elektronik} &#8226; P${row.pemrograman}
                                    </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                    <a href="" class="btn btn-info btn-sm">Selengkapnya</a>
                                    <a href="" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                            </div>
                            `;
                        }
                    }
                ]
            });


            // Menambahkan Field Form
            $('#addfild').click(function(e) {
                $('#inputFieldsContainer').append(`
                    <div class="d-flex gap-1 mt-3 field">
                        <input type="text" class="form-control border-2" name="nama_sekolah" required>
                        <button type="button" class="btn btn-danger removefield">X</button>
                    </div>
                `);
            });

            // Menghapus Field Form dengan event delegation
            $(document).on('click', '.removefield', function() {
                $(this).closest('.field').remove();
            });
        });
    </script>
@endsection
