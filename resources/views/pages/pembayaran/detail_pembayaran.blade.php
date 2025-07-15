@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Pembayaran Kelas" />

            @php
                $hex = $data->kategori->color_bg;
                $r = hexdec(substr($hex, 1, 2));
                $g = hexdec(substr($hex, 3, 2));
                $b = hexdec(substr($hex, 5, 2));
                $bb = hexdec(substr($hex, 9, 5));
                $rgba = "rgba($r, $g, $b, 1)";
                $rgbb = "rgba($r, $g, $bb, 0.4)";
            @endphp

            <div class="section-body">
                {{-- Informasi Kelas --}}
                <div class="row">
                    <div class="col-md-12">

                        <div class="hero text-white hero-bg-image"
                            style="background-image: url({{ asset('img_videogaming1.png') }});
                                    background-color: {{ $rgba }};
                                    /* background-blend-mode: overlay; */
                                    padding:35px";>
                            <div class="hero-inner d-flex flex-column gap-1">
                                <h5>{{ $data->nama_kelas }}</h5>
                                <div class="d-flex gap-2">
                                    <span class="ml-2 badge"
                                        style="
                                        background-color: blue;
                                        background-blend-mode: overlay;
                                        ">{{ $data->program_belajar->nama_program }}</span>
                                    <span
                                        style="
                                        background-color: red;
                                        color: white;
                                        padding: 1px 15px;
                                        border-radius: 999px;
                                        display: inline-block;
                                    ">
                                        {{ $data->kategori->kategori_kelas }}
                                    </span>

                                    @php
                                        $aktif = 'Aktif';
                                        $selesai = 'Selesai';
                                    @endphp
                                    <span
                                        class="ml-2 badge {{ $data->status_kelas == 'aktif' ? 'badge-success' : 'badge-secondary-dark' }}">{{ $data->status_kelas == 'aktif' ? $aktif : $selesai }}</span>
                                </div>

                                <p class="lead d-none d-sm-none d-md-block mt-3"
                                    style="width: 55%; text-align: justify; line-height: 1.5;">
                                    {!! $data->program_belajar->deskripsi !!}</p>
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
                                                <div class="profile-desc-item pull-right">{{ $data->pengajar->nama }}
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

                <button class="btn btn-primary mb-4" id="pembayaran"><i class="fas fa-add"></i> Buat Penagihan
                    Pembayaran</button>

                {{-- Data Siswa --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center align-middle"
                                        id="data_siswa">
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
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i>
                        Batal</button>
                    <button type="button" id="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>
                        Kirim</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Buku Pembayaran --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="">
                        <h5 class="modal-title text-dark fw-bold mb-1" id="modalLabel"># Detail Pembayaran</h5>

                        <div class="border rounded px-3 py-2 bg-light">
                            <div class="d-flex justify-content-between small text-muted gap-5">
                                <span><strong>Nama Siswa:</strong> Budi Santoso</span>
                                <span><strong>Kelas:</strong> VII-A</span>
                            </div>
                        </div>
                    </div>


                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th style="width: 1%;">No</th>
                                <th class="col-1">Jenis Pembayaran</th>
                                <th class="col-1">Nominal</th>
                                <th class="col-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="modalTableBody">
                        </tbody>
                    </table>
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
                        className: 'text-start',
                        render: function(data, type, row) {
                            return `
                                <a href="#" class="text-primary fw-bold" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#modalDetail" 
                                   data-id="${row.id}">
                                    ${data}
                                </a>`;
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
                            if (row.sisa_pembayaran <= 0) {
                                return '<button class="btn btn-success btn-sm readonly"><i class="fa-solid fa-check"></i> Lunas </button>';
                            } else {
                                return '<div class="d-flex gap-3 justify-content-center">' +
                                    '<button class="btn btn-warning btn-sm" ' +
                                    'data-id="' + row.id + '" ' +
                                    'data-kelas-id="' + <?= $data->id ?> + '" ' +
                                    'data-bs-toggle="modal" data-bs-target="#tambahpembayaran">' +
                                    '<i class="fa fa-plus"></i></button>' +

                                    '<button class="btn btn-danger btn-sm" ' +
                                    'data-id="' + row.id + '" ' +
                                    'data-kelas-id="<?= $data->id ?>">' +
                                    '<i class="fa fa-exclamation-circle"></i></button>' +
                                    '</div>';
                            }
                        }
                    }
                ]
            });

            // Variabel global untuk menyimpan ID kita button tambah di klik
            let selectedKelasId;
            let selectedSiswaId;
            $(document).on('click', '.btn-warning', function() {
                selectedSiswaId = $(this).data('id');
                selectedKelasId = $(this).data('kelas-id');
            });

            $(document).on('click', '.btn-danger', function() {
                selectedSiswaId = $(this).data('id');
                selectedKelasId = $(this).data('kelas-id');
                
                $.ajax({
                    type: "GET",
                    url: `/penagiha/personal/${selectedSiswaId}/${selectedKelasId}`,
                    dataType: "json",
                    success: function (response) {
                        console.log(response.data);
                    }
                });
            });

            // Tambah Pembayaran
            $(document).on("click", "#submit", function(e) {
                if (!selectedKelasId || !selectedSiswaId) {
                    alert("Error: Kelas ID atau Siswa ID tidak ditemukan!");
                    return;
                }

                $("#submit").on("click", function() {
                    let $btn = $(this); // Simpan referensi tombol
                    let originalHtml = $btn.html(); // Simpan teks asli tombol

                    // Ubah tombol menjadi loading
                    $btn.prop("disabled", true).html(
                        '<i class="fa fa-spinner fa-spin"></i> Mengirim...');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('pembayaran.murid', ['kelas_id' => '__KELAS_ID__', 'siswa_id' => '__SISWA_ID__']) }}"
                            .replace('__KELAS_ID__', selectedKelasId)
                            .replace('__SISWA_ID__', selectedSiswaId),
                        data: $("#edit_pertemuan_form").serialize() + "&_method=PATCH",
                        dataType: "json",
                        success: function(response) {
                            $('#tambahpembayaran').modal('hide');
                            $('#edit_pertemuan_form').trigger('reset');
                            location.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pembayaran berhasil diperbarui!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan: ' + xhr.responseText,
                                confirmButtonText: 'OK'
                            });
                        },
                        complete: function() {
                            // Kembalikan tombol ke kondisi awal
                            $btn.prop("disabled", false).html(originalHtml);
                        }
                    });
                });


            });

            // Penagihan Kekurangan Pembayaran
            $(document).on('click', '#pembayaran', function() {
                let namaKelas = '{{ $data->nama_kelas }}'

                Swal.fire({
                    title: "Mohon Tunggu...",
                    html: '<img src="https://i.gifer.com/ZZ5H.gif" width="50" height="50"> <br> Sedang mengirim pesan',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('pembayaran_murid.json', ['id' => $data->id]) }}",
                    dataType: "json",
                    success: function(response) {
                        let data = Array.isArray(response) ? response : response.data || [];
                        let filteredData = data.filter(item => item.sisa_pembayaran != 0).map(
                            item => ({
                                ...item,
                                namaKelas: namaKelas
                            })
                        );

                        if (filteredData.length > 0) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('penagihan') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    pembayaran: filteredData
                                },
                                success: function(res) {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: "Data berhasil dikirim!",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        title: "Gagal!",
                                        text: "Gagal Mengirim Pesan!",
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                }
                            });
                        } else {
                            Swal.close();
                            Swal.fire({
                                title: "Tidak Ada Tagihan",
                                text: "Tidak ada data yang perlu ditagih.",
                                icon: "info",
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        console.error("Terjadi kesalahan:", error);
                    }
                });
            });

            $('#modalDetail').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');

                const data = [{
                        col1: '1',
                        col2: 'Uang Pendaftaran',
                        col3: 'Rp. 100.000',
                        col4: '2023-01-01'
                    },
                    {
                        col1: '2',
                        col2: 'Seragam',
                        col3: 'Rp. 50.000',
                        col4: '2023-01-05'
                    },
                    {
                        col1: '3',
                        col2: 'Buku Paket',
                        col3: 'Rp. 75.000',
                        col4: '2023-01-10'
                    },
                    {
                        col1: '4',
                        col2: 'Kegiatan Sekolah',
                        col3: 'Rp. 60.000',
                        col4: '2023-01-12'
                    },
                    {
                        col1: '5',
                        col2: 'SPP Januari',
                        col3: 'Rp. 150.000',
                        col4: '2023-01-15'
                    },
                    {
                        col1: '6',
                        col2: 'SPP Februari',
                        col3: 'Rp. 150.000',
                        col4: '2023-02-01'
                    },
                    {
                        col1: '7',
                        col2: 'SPP Maret',
                        col3: 'Rp. 150.000',
                        col4: '2023-03-01'
                    },
                    {
                        col1: '8',
                        col2: 'Ujian Tengah Semester',
                        col3: 'Rp. 80.000',
                        col4: '2023-03-10'
                    },
                    {
                        col1: '9',
                        col2: 'Praktikum',
                        col3: 'Rp. 70.000',
                        col4: '2023-03-15'
                    },
                    {
                        col1: '10',
                        col2: 'SPP April',
                        col3: 'Rp. 150.000',
                        col4: '2023-04-01'
                    },
                    {
                        col1: '11',
                        col2: 'Uang Gedung',
                        col3: 'Rp. 300.000',
                        col4: '2023-04-10'
                    },
                    {
                        col1: '12',
                        col2: 'SPP Mei',
                        col3: 'Rp. 150.000',
                        col4: '2023-05-01'
                    },
                    {
                        col1: '13',
                        col2: 'Kegiatan Akhir Semester',
                        col3: 'Rp. 100.000',
                        col4: '2023-05-20'
                    },
                    {
                        col1: '14',
                        col2: 'SPP Juni',
                        col3: 'Rp. 150.000',
                        col4: '2023-06-01'
                    },
                    {
                        col1: '15',
                        col2: 'Perpustakaan',
                        col3: 'Rp. 40.000',
                        col4: '2023-06-10'
                    },
                    {
                        col1: '16',
                        col2: 'SPP Juli',
                        col3: 'Rp. 150.000',
                        col4: '2023-07-01'
                    },
                    {
                        col1: '17',
                        col2: 'LKS Semester 1',
                        col3: 'Rp. 90.000',
                        col4: '2023-07-10'
                    },
                    {
                        col1: '18',
                        col2: 'SPP Agustus',
                        col3: 'Rp. 150.000',
                        col4: '2023-08-01'
                    },
                    {
                        col1: '19',
                        col2: 'Kegiatan Pramuka',
                        col3: 'Rp. 55.000',
                        col4: '2023-08-15'
                    },
                    {
                        col1: '20',
                        col2: 'SPP September',
                        col3: 'Rp. 150.000',
                        col4: '2023-09-01'
                    }
                ];


                let rows = '';
                data.forEach(d => {
                    rows += `
            <tr>
                <td>${d.col1}</td>
                <td>${d.col2}</td>
                <td>${d.col3}</td>
                <td>${d.col4}</td>
            </tr>`;
                });

                $('#modalTableBody').html(rows);
            });


        });
    </script>
@endsection
