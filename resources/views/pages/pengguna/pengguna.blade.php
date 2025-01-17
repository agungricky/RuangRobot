@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Data Admin" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Admin" id="#form_admin" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 20%;" class="text-center">Nama</th>
                                                @if (!empty($data) && isset($data[0]) && $data[0]->role == 'Siswa')
                                                    <th style="width: 20%;" class="text-center">Sekolah</th>
                                                @endif
                                                <th style="width: 10%;" class="text-center">Email</th>
                                                <th style="width: 10%;" class="text-center">Alamat</th>
                                                <th style="width: 10%;" class="text-center">No telp</th>
                                                <th style="width: 10%;" class="text-center">Username</th>
                                                <th style="width: 25%;" class="text-center">Opsi</th>
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
    <div class="modal fade" id="admin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('admin.json', ['id' => $id]) }}",
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
                            return `<div class="text-start text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    ...(isSiswa ? [{
                        data: 'nama_sekolah',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold">${data}</div>`;
                        }
                    }] : []),
                    {
                        data: 'email',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'alamat',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'no_telp',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'username',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center gap-1">
                                    <a href="" class="btn btn-info btn-sm">Reset Password</a>
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
        });
    </script>
@endsection
