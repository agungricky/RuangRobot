@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Daftar Sekolah / Mitra" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Kelas" id="#form_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 20%;">Nama Sekolah</th>
                                                <th style="width: 25%;">Penanggung Jawab Robotik</th>
                                                <th style="width: 10%;">No-hp</th>
                                                <th style="width: 65%;">Aksi</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Sekolah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div id="inputFieldsContainer">
                            <div class="field-group mb-3 shadow p-3 rounded bg-white">
                                <div class="field">
                                    <div class="row">
                                        <div class="col-4">
                                            <x-form.input_text name="nama_sekolah" label="Nama Sekolah"
                                                placeholder="Sekolah" />
                                        </div>
                                        <div class="col-4">
                                            <x-form.input_text name="guru" label="Guru Penanggung Jawab"
                                                placeholder="Guru" />
                                        </div>
                                        <div class="col-3">
                                            <x-form.input_text name="no_hp" label="No HP" placeholder="No HP" />
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger removefield">X</button>
                                        </div>
                                    </div>
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
                    url: "{{ route('sekolah.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama_sekolah'
                    },
                    {
                        data: 'guru',
                        render: function(data, type, row) {
                            return `<div class="text-center">${data}</>`;
                        }
                    },
                    {
                        data: 'no_hp',
                        render: function(data, type, row) {
                            return `<div class="text-center"><a href="https://wa.me/${data}" target="_blank">${data}</a></>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-primary btn-sm edit-button" data-id="${row.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-button" data-id="${row.id}">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        `;
                        }

                    }
                ]
            });

            // Menambahkan Field Form
            $('#addfild').click(function(e) {
                $('#inputFieldsContainer').append(`
                    <div class="field-group mb-3 shadow p-3 rounded bg-white">
                                <div class="field">
                                    <div class="row">
                                        <div class="col-4">
                                            <x-form.input_text name="nama_sekolah" label="Nama Sekolah" placeholder="Sekolah" />
                                        </div>
                                        <div class="col-4">
                                            <x-form.input_text name="guru" label="Guru Penanggung Jawab" placeholder="Guru" />
                                        </div>
                                        <div class="col-3">
                                            <x-form.input_text name="no_hp" label="No HP" placeholder="No HP" />
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger removefield">X</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                `);
            });

            // Menghapus Field Form dengan event delegation
            $(document).on('click', '.removefield', function() {
                $(this).closest('.field-group').remove();
            });
        });
    </script>
@endsection
