@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="{{ $indexPendaftaran->title }}" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">

                                    <div class="container my-3">
                                        <!-- Tombol atas -->
                                        <div class="d-flex justify-content-end align-items-center mb-4">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-success btn-filter"
                                                    data-target="pagado">{{ $count }} Mendaftar</button>
                                                <button type="button" class="btn btn-warning btn-filter"
                                                    data-target="pendiente">{{ \Carbon\Carbon::parse($indexPendaftaran->tanggal_p_awal)->format('d-m-Y') }}</button>
                                                <button type="button" class="btn btn-danger btn-filter"
                                                    data-target="cancelado">{{ \Carbon\Carbon::parse($indexPendaftaran->tanggal_p_akhir)->format('d-m-Y') }}</button>
                                                <button type="button" class="btn btn-info btn-filter"
                                                    data-target="all">{{ $indexPendaftaran->status_pendaftaran == 'open' ? 'OPEN' : 'CLOSED' }}</button>
                                            </div>
                                        </div>

                                        <table class="table table-bordered border-dark mt-2 mb-3 align-middle"
                                            id="example">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;" class="text-center">No.</th>
                                                    <th style="width: 20%;">Nama</th>
                                                    <th style="width: 15%;" class="text-center">Email</th>
                                                    <th style="width: 15%;" class="text-center">No.Wa</th>
                                                    <th style="width: 20%;" class="text-center">Sekolah</th>
                                                    <th style="width: 15%;" class="text-center">Status</th>
                                                    <th style="width: 10%;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Cheking data duplicate</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-sm" id="tabel-hasil">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telp</th>
                                        <th>Alamat</th>
                                        <th>Checked</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="section_validasi" class="">
                        <h1 class="fs-4">Form data siswa</h1>
                        <hr>
                        <form action="{{ route('validasi.acc') }}" id="validasi_pendaftaran" method="POST">
                            @csrf
                            <div class="field">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">

                                    <div class="col-4">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            placeholder="Masukkan username" required>
                                        <div id="error-username" class="text-danger"></div>
                                    </div>

                                    <div class="col-4">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control bg-secondary" id="password"
                                            name="password" value="ruangrobot" readonly>
                                        <div id="error-password" class="text-danger"></div>
                                    </div>

                                    <input type="hidden" name="role" value="Siswa">

                                    <div class="col-4">
                                        <label for="sekolah">Sekolah</label>
                                        <input type="text" id="sekolah" class="form-control bg-secondary"
                                            placeholder="Masukan nama Sekolah" readonly>
                                        <input type="hidden" id="sekolah_id" name="sekolah_id">
                                        <div id="error-sekolah_id" class="text-danger"></div>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" id="nama"
                                            class="form-control bg-secondary" placeholder="Masukkan nama" readonly>
                                        <div id="error-nama" class="text-danger"></div>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <label for="kelas">Kelas di Sekolah</label>
                                        <input type="text" name="kelas" id="kelas_siswa"
                                            class="form-control bg-secondary" placeholder="Masukkan Kelas" readonly>
                                        <div id="error-kelas" class="text-danger"></div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control bg-secondary" placeholder="Masukkan email" readonly>
                                        <div id="error-email" class="text-danger"></div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" name="alamat" id="alamat"
                                            class="form-control bg-secondary" placeholder="Masukkan alamat" readonly>
                                        <div id="error-alamat" class="text-danger"></div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="no_telp">No HP</label>
                                        <input type="text" name="no_telp" id="no_telp"
                                            class="form-control bg-secondary" placeholder="Masukkan nomor HP" readonly>
                                        <div id="error-no_telp" class="text-danger"></div>
                                    </div>

                                    <input type="hidden" name="mekanik" value="0">
                                    <input type="hidden" name="elektronik" value="0">
                                    <input type="hidden" name="pemrograman" value="0">
                                </div>
                            </div>

                            <div class="search_kelas mt-5">
                                <h1 class="fs-4">Cari Kelas</h1>
                                <hr>
                                <div class="field">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Kelas</label>
                                            <input type="text" class="kelas_input form-control"
                                                placeholder="Ketik kode kelas..." autocomplete="off" required>
                                            <input type="hidden" class="kelas_id">
                                            <div class="kelas_list border bg-white shadow-sm rounded"
                                                style="display: none; position: absolute; z-index: 1000;"></div>
                                            <div class="error-kelas_input text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="search_kelas d-none" id="search_kelas">
                        <h1 class="fs-4">Cari Kelas</h1>
                        <hr>
                        <div class="field">
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Kelas</label>
                                    <input type="text" class="kelas_input form-control"
                                        placeholder="Ketik kode kelas..." autocomplete="off" required>
                                    <input type="hidden" class="kelas_id">
                                    <div class="kelas_list border bg-white shadow-sm rounded"
                                        style="display: none; position: absolute; z-index: 1000;"></div>
                                    <div class="error-kelas_input text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer my-2">
                    <button type="submit" form="validasi_pendaftaran" id="btn-buat-akun"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Buat Akun & Masuk Kelas
                    </button>

                    <button id="btn-masukkan-kelas" class="btn btn-primary btn-sm" disabled>
                        <i class="fas fa-door-open"></i> Masukkan Kelas
                    </button>

                    <button class="btn btn-warning btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
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
                    url: "{{ route('validasi.show', ['validasi' => $id]) }}",
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
                        data: 'email',
                        render: function(data, type, row) {
                            return `<div class="text-center">${data}</div>`;
                        }
                    },
                    {
                        data: 'no_telp',
                        render: function(data, type, row) {
                            return `<div class="text-center fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="text-center">${row.sekolah?.nama_sekolah ?? '-'}</div>`;

                        }
                    },
                    {
                        data: 'null',
                        render: function(data, type, row) {
                            return `<div class="text-center">
                                        <span class="bg-success text-white px-2 py-1 rounded fw-bold d-inline-block">
                                            Mendaftar
                                        </span>
                                    </div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex gap-2">
                                    <button 
                                        type="button" 
                                        class="btn btn-primary btn-sm px-2 btn-verifikasi"
                                        id="btn-verifikasi"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal_pengguna"
                                        data-id="${row.id}"
                                        data-nama="${row.nama}"
                                        data-email="${row.email}"
                                        data-alamat="${row.alamat}"
                                        data-no_telp="${row.no_telp}"
                                        data-sekolah_nama="${row.sekolah?.nama_sekolah ?? '-'}"
                                        data-sekolah_id="${row.sekolah_id}"
                                        data-kelas="${row.kelas}"
                                    >
                                        <i class="fa-solid fa-clock"></i>
                                    </button>
                                
                                    <a href="#" class="btn btn-danger btn-sm px-2">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Fungsi membuat pilihan kelas
            let allKelas = [];
            $(document).ready(function() {
                $.ajax({
                    url: '/search-kelas',
                    type: 'GET',
                    success: function(res) {
                        allKelas = res.data;
                    }
                });

                $(document).on('keyup', '.kelas_input', function() {
                    let $container = $(this).closest('.search_kelas');
                    let keyword = $(this).val().toLowerCase();
                    let $kelasList = $container.find('.kelas_list');

                    if (keyword.length === 0) {
                        $kelasList.hide();
                        return;
                    }

                    let filtered = allKelas.filter(item =>
                        item.kode_kelas.toLowerCase().includes(keyword) ||
                        item.nama_kelas.toLowerCase().includes(keyword)
                    );

                    if (filtered.length > 0) {
                        let list = filtered.map(item => `
                            <div class="item-kelas" data-id="${item.id}" style="padding:5px; cursor:pointer;">
                                ${item.kode_kelas} - ${item.nama_kelas}
                            </div>
                        `).join('');

                        $kelasList.html(list).show();
                    } else {
                        $kelasList.html('<div style="padding:5px;">Tidak ditemukan</div>').show();
                    }
                });

                $(document).on('click', '.item-kelas', function() {
                    let nama = $(this).text().trim();
                    let id = $(this).data('id');
                    let $container = $(this).closest('.search_kelas');

                    $container.find('.kelas_input').val(nama);
                    $container.find('.kelas_id').val(id);
                    $container.find('.kelas_list').hide();
                });

                // Sembunyikan jika klik di luar
                $(document).click(function(e) {
                    if (!$(e.target).closest('.kelas_input, .kelas_list').length) {
                        $('.kelas_list').hide();
                    }
                });
            });

            // Form Disable Buat Akun
            let idPendaftaran_siswa = null;
            let kelas_pendaftar = null;
            $(document).on('click', '.btn-verifikasi', function() {
                // Untuk mengisi Variabel global
                idPendaftaran_siswa = $(this).data('id');
                kelas_pendaftar = $(this).data('kelas');

                // Untuk mengisi Form
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let email = $(this).data('email');
                let alamat = $(this).data('alamat');
                let no_telp = $(this).data('no_telp');
                let sekolahNama = $(this).data('sekolah_nama');
                let sekolahId = $(this).data('sekolah_id');
                let kelas = $(this).data('kelas');

                $('#id').val(id);
                $('#nama').val(nama);
                $('#email').val(email);
                $('#alamat').val(alamat);
                $('#no_telp').val(no_telp);
                $('#sekolah').val(sekolahNama);
                $('#sekolah_id').val(sekolahId);
                $('#kelas_siswa').val(kelas);

                // Menampilakn Tabel data duplikat
                $.ajax({
                    type: "GET",
                    url: "/pengguna/Siswa",
                    dataType: "json",
                    success: function(response) {
                        let hasil = response.data.find(item => item.nama.toLowerCase() === nama
                            .toLowerCase());

                        let no = 1;

                        if (hasil) {
                            let html = `
                            <tr>
                                <td>${no}</td>
                                <td>${hasil.nama}</td>
                                <td>${hasil.email}</td>
                                <td>${hasil.no_telp}</td>
                                <td>${hasil.alamat}</td>
                                <td style="width: 1%; white-space: nowrap;" class="text-center align-middle">
                                    <input type="checkbox" class="form-check-input pilih-data" style="transform: scale(1.5);" name=pilih[] value="${hasil.id}">
                                </td>
                            </tr>
                        `;

                            $('#tabel-hasil tbody').html(html);
                        } else {
                            $('#tabel-hasil tbody').html(
                                '<tr><td colspan="6">Tidak ditemukan</td></tr>');
                        }
                    }
                });

                // Logika Mengelola Button
                $(document).on('change', 'input[name="pilih[]"]', function() {
                    let jumlahTercentang = $('input[name="pilih[]"]:checked').length;

                    $('#btn-masukkan-kelas').prop('disabled', jumlahTercentang !== 1);
                    $('#btn-buat-akun').prop('disabled', jumlahTercentang >= 1);

                    if (jumlahTercentang > 0) {
                        $('#section_validasi').addClass('d-none');
                        $('#search_kelas').removeClass('d-none');

                    } else {
                        $('#section_validasi').removeClass('d-none');
                        $('#search_kelas').addClass('d-none');

                    }
                });
            });

            // Logika data pengguna yang di centang checkbox
            $('#btn-masukkan-kelas').on('click', function() {
                // Ambil semua checkbox yang dicentang, karna banyak di tambahkan s (ids)
                let ids = [];
                $('.pilih-data:checked').each(function() {
                    ids.push($(this).val());
                });

                let idTerpilih = parseInt(ids[0]);
                $.ajax({
                    type: "GET",
                    url: `/siswa/${idTerpilih}/json`,
                    dataType: "json",
                    success: function(response) {
                        // Ambil CSRF token dan set ke semua request Ajax
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // Id Form untuk mencari kelas
                        let idForm_index = allKelas[0].id;

                        let dataForm = {
                            id: response.data.id,
                            nama: response.data.pengguna.nama,
                            sekolah_id: response.data.pengguna.sekolah_id,
                            idPendaftaran: idPendaftaran_siswa,
                            kelas_pendaftar: kelas_pendaftar,
                        };

                        $.ajax({
                            type: "POST",
                            url: `/validasi/masukkls/${idForm_index}`,
                            data: dataForm,
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message ?? 'Data berhasil diproses.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.log(dataForm);
                                console.log('Gagal:', xhr.responseText);
                            }
                        });


                    }
                });

            });

        });
    </script>
@endsection
