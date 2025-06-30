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
                        @if ($id == 'Siswa')
                            <ul class="nav nav-tabs" id="siswaTabs" role="tablist">
                                <li class="nav-item m-0 p-0" role="presentation">
                                    <button class="nav-link active" id="data-tab" data-bs-toggle="tab"
                                        data-bs-target="#dataSiswa" type="button" role="tab" aria-controls="dataSiswa"
                                        aria-selected="true">
                                        Data Siswa
                                    </button>
                                </li>
                                <li class="nav-item m-0 p-0" role="presentation">
                                    <button class="nav-link" id="permintaan-tab" data-bs-toggle="tab"
                                        data-bs-target="#permintaanSiswa" type="button" role="tab"
                                        aria-controls="permintaanSiswa" aria-selected="false">
                                        Permintaan Pendaftaran
                                    </button>
                                </li>
                            </ul>
                        @endif


                        <!-- Tabs Content -->
                        <div class="tab-content" id="siswaTabsContent">
                            {{-- Data Siswa --}}
                            <div class="tab-pane fade show active m-0 p-0" id="dataSiswa" role="tabpanel"
                                aria-labelledby="data-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <x-button.button_add_modal message="Tambah Siswa" id="#modal_pengguna" />
                                        <div class="table-responsive">
                                            <table class="table table-bordered border-dark mt-3 text-center" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Sekolah</th>
                                                        <th>Alamat</th>
                                                        <th>No HP</th>
                                                        <th>Username</th>
                                                        <th>Opsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Permintaan Pendaftaran --}}
                            <div class="tab-pane fade m-0 p-0" id="permintaanSiswa" role="tabpanel"
                                aria-labelledby="permintaan-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-3">Permintaan Pendaftaran</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered border-dark mt-2 text-center"
                                                id="table-permintaan">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center" style="width: 200px;">Nama</th>
                                                        <th class="text-center" style="width: 180px;">Sekolah</th>
                                                        <th class="text-center" style="width: 300px;">Alamat</th>
                                                        <th class="text-center" style="width: 130px;">No HP</th>
                                                        <th class="text-center" style="width: 100px;">Opsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>

                                        </div>
                                    </div>
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
                                    <input type="text" class="form-control" id="password" name="password"
                                        value="ruangrobot" readonly>
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

    {{-- Modal ACC Siswa --}}
    <div class="modal fade" id="modalAcc_pengguna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
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
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control">
                                    <div id="error-username" class="text-danger"></div>
                                </div>

                                <div class="col-4">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password"
                                        value="ruangrobot" readonly>
                                    <div id="error-password" class="text-danger"></div>
                                </div>

                                {{-- <input type="hidden" name="role" value="{{ $id }}"> --}}

                                <div class="col-4">
                                    <label for="sekolah">Sekolah</label>
                                    <select id="sekolah" class="form-control" style="width: 100%;">
                                        <option value="">-- Pilih Sekolah --</option>
                                        <option value="1">SMKN 1 Kediri</option>
                                        <option value="2">SMAN 2 Nganjuk</option>
                                        <option value="3">SMPN 3 Pare</option>
                                    </select>

                                    <div id="error-sekolah_id" class="text-danger"></div>
                                </div>


                                <div class="col-12 mt-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="jancok" class="form-control"
                                        placeholder="masukan nama" value="">
                                    <div id="error-nama" class="text-danger"></div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="masukan email">
                                    <div id="error-email" class="text-danger"></div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control"
                                        placeholder="masukan alamat">
                                    <div id="error-alamat" class="text-danger"></div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="no_telp">No HP</label>
                                    <input type="text" name="no_telp" id="no_telp" class="form-control"
                                        placeholder="masukan nomor hp">
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
                    url: "{{ route('pengguna.json', ['id' => $id]) }}",
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
                            return `<div class="text-start text-tabel fw-bold"><a href="{{ url('/kelas/diikuti/${row.id}') }}">${data}</a></div>`;
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
                            let role = '{{ $id }}';
                            return `
                                    <div class="d-flex justify-content-center gap-1">
                                            <form action="{{ url('/pengguna/reset/${row.id}') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm">Reset Password</button>
                                            </form>
                                            <a href="{{ url('/pengguna/edit/${row.id}/${role}') }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ url('/pengguna/delete/${row.id}/${role}') }}" method="POST" class="d-inline">
                                                @csrf
                                                undefined
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

                // alert(formData);

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
                        // alert(xhr.responseText);
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
                url: "{{ route('sekolah_form.json') }}",
                method: "GET",
                success: function(response) {
                    var programs = response.map(function(item) {
                        return {
                            label: item
                                .nama_sekolah,
                            value: item.nama_sekolah,
                            id: item.id
                        };
                    });

                    // Terapkan autocomplete
                    $('#sekolah').autocomplete({
                        source: programs,
                        minLength: 1,
                        autoFocus: true,
                        select: function(event, ui) {
                            $('#sekolah_id').val(ui.item.id);
                            $(this).val(ui.item
                                .label);
                            return false;
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });

            // Menampilkan data permintaan pendaftaran siswa
            $('#table-permintaan').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('permintaan_join.json', ['id' => $id]) }}",
                    dataSrc: '',
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
                            return `<div class="text-start text-tabel fw-bold"><a href="{{ url('/kelas/diikuti/${row.id}') }}">${data}</a></div>`;
                        }
                    },
                    {
                        data: 'nama_sekolah',
                        render: function(data, type, row) {
                            return `<div class="text-start text-tabel">${data == null ? '' : data}</div>`;
                        }
                    },
                    {
                        data: 'alamat',
                        render: function(data, type, row) {
                            if (!data) return '';
                            const words = data.split(' ');
                            const limited = words.slice(0, 30).join(' ');
                            return `<div class="text-start text-tabel">${words.length > 30 ? limited + ' ...' : data}</div>`;
                        }

                    },
                    {
                        data: 'no_telp',
                        render: function(data, type, row) {
                            return `<div class="text-start text-tabel"><a href="https://wa.me/${data}" target="_blank">${data}</a></div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let role = '{{ $id }}';
                            return `
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-success btn-sm btn-acc" data-row='${JSON.stringify(row)}' title="Terima Pendaftaran">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        <form action="{{ url('/pengguna/delete/${row.id}/${role}') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak Pendaftaran">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                `;
                        }
                    }
                ]
            });

            // Edit permintaan pendaftaran siswa
            $(document).on('click', '.btn-acc', function() {
                let rawData = $(this).attr('data-row'); // ambil string JSON
                let data = JSON.parse(rawData); // ubah jadi objek

                $('#jancok').val(data.nama);
                console.log(data.nama);


                $('#modalAcc_pengguna').modal('show');
            });

            $('#submitAcc_pengguna').on('click', function() {
                let form = $('#pengguna_form');
                let formData = form.serialize();

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
                        // alert(xhr.responseText);
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

    <script>
        if (typeof jQuery === 'undefined') {
            console.error('❌ jQuery belum termuat!');
        } else {
            console.log('✅ jQuery aktif');
        }

        if (typeof $.fn.select2 === 'undefined') {
            console.error('❌ Select2 belum termuat!');
        } else {
            console.log('✅ Select2 aktif');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#sekolah').select2({
                width: '100%',
                placeholder: "-- Pilih Sekolah --",
                allowClear: true,
                dropdownCssClass: "limit-height"
            });
        });
    </script>

    <style>
        .select2-container {
            border: 2px solid red;
        }
    </style>
@endsection
