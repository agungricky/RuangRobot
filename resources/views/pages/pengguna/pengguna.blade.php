@extends('main.layout')
@section('content')
    @if (session('success'))
    <x-sweetalert.success />
    @endif
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        @if ($id == 'Admin')
        <x-title_halaman title="Data Admin" />
        @endif
        @if ($id == 'Pengajar')
        <x-title_halaman title="Data Pengajar" />
        @endif
        @if ($id == 'Siswa')
        <x-title_halaman title="Data Siswa" />
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="add-items d-flex">
                                @if ($id == 'Admin')
                                <x-button.button_add_modal message="Tambah Admin" id="#modal_pengguna" />
                                @endif
                                @if ($id == 'Pengajar')
                                <x-button.button_add_modal message="Tambah Pengajar" id="#modal_pengguna" />
                                @endif
                                @if ($id == 'Siswa')
                                <x-button.button_add_modal message="Tambah Siswa" id="#modal_pengguna" />
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;" class="text-center">No.</th>
                                            <th style="width: 20%;" class="text-center">Nama</th>
                                            @if ($id == 'Siswa')
                                            <th style="width: 20%;" class="text-center">Sekolah</th>
                                            @endif
                                            @if ($id == 'Admin' || $id == 'Pengajar')
                                            <th style="width: 10%;" class="text-center">Email</th>
                                            @endif
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
<div class="modal fade" id="modal_pengguna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($id == 'Admin')
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Admin</h1>
                @endif
                @if ($id == 'Pengajar')
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Pengajar</h1>
                @endif
                @if ($id == 'Siswa')
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Siswa</h1>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
                <form id="pengguna_form" method="POST">
                    @csrf
                    <div class="field">
                        <div class="row">
                            <div class="col-4">
                                <x-form.input_text name="username" label="Username" placeholder="masukan username" />
                                <div id="error-username" class="text-danger"></div>
                            </div>
                            <div class="col-4">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="ruangrobot"
                                    readonly>
                                <div id="error-password" class="text-danger"></div>
                            </div>
                            <input type="hidden" name="role" value="{{ $id }}">
                            @if ($id == 'Siswa')
                            <div class="col-4">
                                <label for="autocomplete_sekolah">Sekolah</label>
                                <input type="text" id="sekolah" class="form-control"
                                    placeholder="Masukan nama Sekolah" />
                                <input type="hidden" id="sekolah_id" name="sekolah_id" />
                                <div id="error-sekolah_id" class="text-danger"></div>
                            </div>
                            @endif
                            @if ($id == 'Admin' || $id == 'Pengajar')
                            <div class="col-4">
                                <input type="hidden" id="sekolah_id" name="sekolah_id" value="" />
                            </div>
                            @endif
                            <div class="col-12 mt-3">
                                <x-form.input_text name="nama" label="Nama" placeholder="masukan nama" />
                                <div id="error-nama" class="text-danger"></div>
                            </div>
                            <div class="col-12 mt-3">
                                <x-form.input_text name="email" label="email" placeholder="masukan email" />
                                <div id="error-email" class="text-danger"></div>
                            </div>
                            <div class="col-12 mt-3">
                                <x-form.input_text name="alamat" label="Alamat" placeholder="masukan alamat" />
                                <div id="error-alamat" class="text-danger"></div>
                            </div>
                            <div class="col-12 mt-3">
                                <x-form.input_text name="no_telp" label="No HP" placeholder="masukan nomor hp" />
                                <div id="error-no_telp" class="text-danger"></div>
                            </div>

                            <input type="hidden" name="mekanik" value="0">
                            <input type="hidden" name="elektronik" value="0">
                            <input type="hidden" name="pemrograman" value="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer pt-3">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="submit_pengguna" class="btn btn-success"><i
                        class="fa-solid fa-floppy-disk fa-lg"></i> Kirim</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Pastikan dropdown muncul di atas elemen lain */
    .ui-autocomplete {
        z-index: 9999;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #ccc;
    }
</style>

<script>
    $(document).ready(function() {
            // Menampilkan data pengguna menggunakan DataTable
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
                    @if ($id == 'Siswa')
                        {
                            data: 'nama_sekolah',
                            render: function(data, type, row) {
                                return `<div class="text-start text-tabel">${data}</div>`;
                            }
                        },
                    @endif
                    @if ($id == 'Pengajar' || $id == 'Admin')
                        {
                            data: 'email',
                            render: function(data, type, row) {
                                return `<div class="text-start text-tabel">${data}</div>`;
                            }
                        },
                    @endif {
                        data: 'alamat',
                        render: function(data, type, row) {
                            return `<div class="text-start text-tabel">${data}</div>`;
                        }
                    },
                    {
                        data: 'no_telp',
                        render: function(data, type, row) {
                            return `<div class="text-start text-tabel"><a href="https://wa.me/${data}" target="_blank">${data}</a></div>`;
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
                                <form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-info btn-sm">Reset Password</button>
                                </form>
                                <a href="{{ url('/pengguna/edit/${row.id}') }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ url('/pengguna/delete/${row.id}') }}" method="POST" class="d-inline">
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

            // Menambahkan Data
            $('#submit_pengguna').on('click', function() {
                let form = $('#pengguna_form');
                let formData = form.serialize();

                alert(formData);

                $.ajax({
                    type: "POST",
                    url: "{{ route('pengguna.store') }}",
                    data: formData,
                    success: function(response) {
                        form.trigger('reset'); // Reset form setelah berhasil
                        $('#modal_pengguna').modal('hide'); // Tutup modal
                        location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseText);
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

            // Auto Complate Sekolah
            $.ajax({
                url: "{{ route('sekolah.json') }}",
                method: "GET",
                success: function(response) {
                    // Periksa respons yang diterima
                    console.log(response);

                    // Buat array objek dengan hanya nama_sekolah
                    var programs = response.map(function(item) {
                        return {
                            label: item
                                .nama_sekolah, // Nama sekolah yang ditampilkan di autocomplete
                            value: item.nama_sekolah, // Nilai input teks
                            id: item.id // ID yang disimpan di input hidden
                        };
                    });

                    // Terapkan autocomplete
                    $('#sekolah').autocomplete({
                        source: programs,
                        minLength: 1,
                        autoFocus: true,
                        select: function(event, ui) {
                            // Periksa apa yang ada di ui.item
                            console.log(ui.item);

                            // Pastikan ID yang benar disimpan ke input hidden
                            $('#sekolah_id').val(ui.item.id); // Simpan ID di input hidden
                            $(this).val(ui.item
                                .label); // Tampilkan nama sekolah di input teks
                            return false;
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });
</script>
@endsection