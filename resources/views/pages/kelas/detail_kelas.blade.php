@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif
    <!-- Custom Alert Notifikasi -->
    <x-sweetalert.success_custom text1="Berhasil!" text2="Pertemuan berhasil diupdate!" />

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kelas" />

            {{-- Button --}}
            <div class="row">
                <div class="col d-flex">
                    <a href="{{ route('jurnal_kelas', ['id' => $data->id]) }}" class="btn btn-success mb-4 mr-3"><i
                            class="fas fa-file"></i>
                        Generate Report</a>
                    <a href="{{ route('sertifikat', ['id' => $data->id]) }}" class="btn btn-primary mb-4 mr-3"><i
                            class="fas fa-print"></i>
                        Generate Sertifikat</a>
                    <form action="{{ route('kelas.selesai', ['id' => $data->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info mb-4 mr-3"><i class="fas fa-check"></i> Tandai Kelas
                            Selesai</button>
                    </form>
                </div>
            </div>

            <div class="section-body">
                {{-- Informasi Kelas --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="hero text-white hero-bg-image"
                            style="background-image: url({{ asset('img_videogaming.jpg') }}); padding:35px;">
                            <div class="hero-inner">
                                <h5>{{ $data->nama_kelas }}</h5>
                                <span class="badge badge-danger">{{ $data->kategori_kelas }}</span>
                                <span
                                    class="ml-2 badge {{ $data->status_kelas == 'aktif' ? 'badge-warning' : 'badge-success' }}">{{ $data->status_kelas }}</span>
                                <p class="lead">{{ $data->nama_program }}</p>
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
                                                <b><i class="fas fa-play-circle"></i> Pertemuan Kelas</b>
                                                <div class="profile-desc-item pull-right">{{ $jp }} Pertemuan
                                                </div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-users"></i> Jumlah Siswa</b>
                                                <div class="profile-desc-item pull-right">{{ $jumlahSiswa }} Siswa</div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-user"></i> Penanggung Jawab Kelas </b>
                                                <div class="profile-desc-item pull-right">{{ $data->penanggung_jawab }}
                                                </div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-layer-group"></i> Level </b>
                                                <div class="profile-desc-item pull-right">
                                                    @if ($data->level == 'mudah')
                                                        <span class="badge badge-success"><b>Mudah</b></span>
                                                    @elseif ($data->level == 'sedang')
                                                        <span class="badge badge-warning"><b>Sedang</b></span>
                                                    @elseif ($data->level == 'sulit')
                                                        <span class="badge badge-danger"><b>Sulit</b></span>
                                                    @endif
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
                                                    <b><i class="fas fa-dollar-sign"></i> Gaji Pengajar </b>
                                                    <div class="profile-desc-item pull-right">Rp.
                                                        {{ number_format($data->gaji_pengajar, 0, ',', '.') }} / Pertemuan
                                                    </div>
                                                </div>
                                                <div>
                                                    <b><i class="fas fa-dollar-sign"></i> Gaji Transport </b>
                                                    <div class="profile-desc-item pull-right">Rp.
                                                        {{ number_format($data->gaji_transport, 0, ',', '.') }} / Pertemuan
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-star"></i> Poin Yang Akan Didapatkan </b>
                                                <div class="profile-desc-item pull-right">
                                                    <ul class="list-star">
                                                        <li>Mekanik : <span style="font-weight:bold"
                                                                class="text-info">+{{ $data->mekanik }}</span></li>
                                                        <li>Elektronik : <span style="font-weight:bold"
                                                                class="text-success">+{{ $data->elektronik }}</span></li>
                                                        <li>Pemrograman : <span style="font-weight:bold"
                                                                class="text-danger">+{{ $data->pemrograman }}</span></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tambah pertemuan Kelas --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Pertemuan Kelas" id="#pertemuan_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 8%;" class="text-center">Pertemuan Ke</th>
                                                <th style="width: 15%;" class="text-center">Pengajar</th>
                                                <th style="width: 15%;" class="text-center">Taggal Pertemuan</th>
                                                <th style="width: 10%;" class="text-center">Jam</th>
                                                <th style="width: 10%;" class="text-center">Selegkapnya</th>
                                                <th style="width: 10%;" class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tambah Siswa Kelas --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Siswa" id="#tambah_siswa" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="data_siswa">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;" class="text-center">Nama Siswa</th>
                                                <th style="width: 15%;" class="text-center">Sekolah</th>
                                                <th style="width: 10%;" class="text-center">Kehadiran</th>
                                                <th style="width: 10%;" class="text-center">Nilai</th>
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

    <!-- Modal Pertemuan Kelas -->
    <div class="modal fade" id="pertemuan_kelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pertemuan Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0;">
                    <form id="form_pertemuankelas" method="POST">
                        @csrf
                        <div id="inputFieldsContainer" class="mb-0">
                            <x-form.input_angka label="Jumlah Pertemuan Kelas" name="jumlah_pertemuan"
                                placeholder="Masukan Jumlah Pertemuan Kelas yang ingin ditambahkan" />
                            <input type="hidden" name="id_kelas" value="{{ $data->id }}">
                            <div id="jumlah_pertemuan" class="text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer mt-2 pt-0">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="submit" class="btn btn-success">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="tambah_siswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $data->nama_kelas }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-2">
                    <form id="sekolah_form" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="siswa_kelas"
                                data-page-length="100">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center">Pilih</th>
                                        <th style="width: 5%;" class="text-center">No.</th>
                                        <th style="width: 15%;" class="text-center">Nama Siswa</th>
                                        <th style="width: 50%;" class="text-start">Sekolah</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-3">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="submit_sekolah" class="btn btn-success"><i
                            class="fa-solid fa-add fa-lg"></i> Tambahkan Siswa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal detail pertemuan -->
    <div class="modal fade modal-fullscreen" id="detailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item border-bottom">
                            <b><i class="fas fa-user"></i> Pengajar </b>
                            <div class="profile-desc-item pull-right">
                                <span id="pengajar"></span>
                            </div>
                        </li>
                        <li class="list-group-item border-bottom">
                            <b><i class="fas fa-clock"></i> Waktu Pertemuan </b>
                            <div class="profile-desc-item pull-right">
                                <span id="tanggal"></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-book"></i> Materi </b>
                            <div class="profile-desc-item pull-right">
                                <span id="materi"></span>
                            </div>
                        </li>
                    </ul>
                    <h6 class="mt-3 mb-3">Siswa Yang Hadir :</h6>
                    <div class="inimasuksiswahadir"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit pertemuan -->
    <div class="modal fade" id="editPertemuanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pertemuan Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_pertemuan_form">
                        @csrf
                        <x-form.input_angka label="Pertemuan Ke" name="pertemuan"
                            placeholder="Rubah Pertemuan ke berapa?" />
                        <div id="pertemuanError" class="text-danger"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="Editsubmit" class="btn btn-success">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Menampilkan Data Tabel Pertemuan Kelas
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('pembelajaran.json', ['id' => $data->id]) }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'pertemuan',
                        render: function(data, type, row) {
                            return `<div class="text-tabel text-start fw-bold text-primary">Pertemuan Ke ${data}</div>`;
                        }
                    },
                    {
                        data: 'pengajar',
                        render: function(data, type, row) {
                            return `<div class="text-body-secondary fw-bold text-start">${data}</div>`;
                        }
                    },
                    {
                        data: 'tanggal',
                        render: function(data, type, row) {
                            let color = data == null ? 'warning' : 'success';
                            let formattedDate = 'Belum dilaksanakan';

                            if (data) {
                                let date = new Date(data);
                                formattedDate = date.toLocaleDateString('id-ID', {
                                    weekday: 'long',
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                });
                            }

                            return `<div class="text-tabel text-start"><span class="level w-100 bg-${color}">${formattedDate}</span></div>`;
                        }
                    },
                    {
                        data: 'durasi_belajar',
                        render: function(data, type, row) {
                            return `<div class="text-tabel text-center">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button class="btn btn-success btn-sm" ${data.tanggal != null ? '' : 'disabled'} 
                                            data-id="${row.id}">Selengkapnya</button>
                                    </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                <button class="btn btn-warning btn-sm" id="editBtn" data-bs-toggle="modal" data-bs-target="#editPertemuanModal" data-id="${row.id}">Edit</button>
                                <form action="{{ url('/pertemuan/delete/${row.id}') }}" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        `;
                        }
                    }
                ]
            });

            // Menampilkan Tabel Siswa diKelas
            $('#data_siswa').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('datasiswa_kelas.json', ['id' => $data->id]) }}",
                    dataSrc: function(response) {
                        console.log(response);
                        return JSON.parse(response.data.murid || '[]');
                    },
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
                            return `<div class="text-start fw-bold text-primary">${data}</div>`;
                        }
                    },
                    {
                        data: 'sekolah',
                        render: function(data, type, row) {
                            return `<div class="text-body-secondary text-start">${data}</div>`;
                        }
                    },
                    {
                        data: 'null', // Properti total presensi
                        render: function(data, type, row) {
                            let result = @json($result);
                            if (result[row.id]) {
                                let persentase = result[row.id].persentase;
                                return `
                                        <div class="text-center">
                                            <div class="progress" style="height: 8px; border-radius: 50px; background-color: #e9ecef;">
                                                <div class="progress-bar" role="progressbar" style="width: ${persentase}%; border-radius: 50px; background-color: #4caf50;" aria-valuenow="${persentase}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span style="font-size: 12px; margin-top: 5px; display: inline-block;">${persentase} %</span>
                                        </div>
                                    `;
                            } else {
                                return `<div class="text-center">Belum ada pembelajaran</div>`;
                            }
                        }
                    },
                    {
                        data: 'nilai',
                        render: function(data, type, row) {
                            if (!data) {
                                return `
                                        <div class="text-center bg-info text-light py-1" 
                                           style="border-radius: 8px; font-size: 12px;">Belum di Nilai
                                         </div>`;
                            } else if (data === 'Gagal') {
                                return `
                                        <div class="text-center bg-danger text-white py-1" 
                                            style="border-radius: 8px; font-size: 14px;">${data}
                                        </div>`;
                            } else if (data === 'B') {
                                return `
                                        <div class="text-center bg-warning text-dark py-1" 
                                            style="border-radius: 8px; font-size: 14px;">${data}
                                        </div>`;
                            } else if (data === 'A') {
                                return `
                                        <div class="text-center bg-success text-white py-1" 
                                            style="border-radius: 8px; font-size: 14px;">${data}
                                        </div>`;
                            }
                            return `
                                    <div class="text-center py-1" 
                                        style="border-radius: 8px; font-size: 14px;">${data}
                                    </div>`;
                        }

                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-danger btn-sm btn-hapus" ' +
                                'data-id="' + row.id + '" ' + 'data-kelas-id="' + <?= $data->id ?> +
                                '">' + 'Hapus</button>';
                        }
                    }
                ]
            });

            // Menampilkan modal Data siswa/murid yang akan di add dikelas
            let siswaTable = $('#siswa_kelas').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('siswa_kelas.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="select-checkbox" data-id="${row.id}" data-nama="${row.nama}" data-sekolah="${row.nama_sekolah}" />`;
                        },
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        },
                    },
                    {
                        data: 'nama',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold text-start">${data}</div>`;
                        },
                    },
                    {
                        data: 'nama_sekolah',
                        render: function(data, type, row) {
                            return `<div class="text-body-secondary fw-bold text-start">${data}</div>`;
                        },
                    },
                ],
            });




            // Event klik untuk baris
            $('#siswa_kelas tbody').on('click', 'tr', function(e) {
                // Abaikan klik pada checkbox agar tidak memicu dua kali
                if ($(e.target).is('input[type="checkbox"]')) return;

                const checkbox = $(this).find('.select-checkbox');
                checkbox.prop('checked', !checkbox.prop('checked')); // Toggle checkbox

                // Tambahkan efek visual (highlight baris)
                $(this).toggleClass('selected-row', checkbox.prop('checked'));
            });

            // Button Selengkapnya untuk detail Pertemuan kelas
            $('#example').on('click', '.btn-success', function() {
                let id = $(this).data('id'); // Ambil ID dari tombol
                let url = "{{ route('detail_pertemuan.json', ['id' => ':id']) }}".replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        let data = response.data;

                        console.log(data);

                        // Mendapatkan nama Hari
                        let date = new Date(data.tanggal);
                        let hari = date.toLocaleDateString('id-ID', {
                            weekday: 'long'
                        });
                        let tanggal =
                            `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;

                        // Isi data ke dalam elemen modal
                        $('#pengajar').text(data.pengajar);
                        $('#tanggal').text(`${hari}, ${tanggal}`);
                        $('#materi').text(data.materi);

                        // Proses data absensi
                        let absensi = JSON.parse(data.absensi);
                        let absensiHTML = '';

                        absensi.forEach(item => {
                            absensiHTML += `
                                <div class="d-flex align-items-center border mb-2 rounded shadow-sm" style="background: #fff;">
                                    <div class="p-2 text-white d-flex align-items-center justify-content-center" 
                                         style="background: linear-gradient(135deg, ${item.presensi === 'H' ? 'rgba(40, 167, 69, 0.7)' : 'rgba(220, 53, 69, 0.7)'}, ${item.presensi === 'H' ? 'rgba(102, 217, 159, 0.5)' : 'rgba(248, 169, 183, 0.5)'}); color: ${item.presensi === 'H' ? '#fff' : '#fff'}; width: 50px; height: 50px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                                        <i class="fas ${item.presensi === 'H' ? 'fa-check' : 'fa-times'}" style="font-size: 20px;"></i>
                                    </div>
                                    <div class="p-2 flex-grow-1" style="color: #495057; font-weight: 500;">
                                        ${item.nama}
                                    </div>
                                </div>
                            `;
                        });



                        // Tambahkan HTML ke dalam div.inimasuksiswahadir
                        $('.inimasuksiswahadir').html(absensiHTML);

                        // Tampilkan modal
                        $('#detailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan:", error);
                        alert('Terjadi kesalahan dalam pengambilan data');
                    }
                });
            });



            // submit untuk data yang dipilih
            $('#submit_sekolah').on('click', function() {
                let selectedSiswa = [];
                $('.select-checkbox:checked').each(function() {

                    let no_invoice = $(this).data('no_invoice') ||
                        ''; // Mendapatkan no_invoice terlebih dahulu

                    // Jika no_invoice kosong, buat invoice baru
                    if (!no_invoice) {
                        let currentDate = new Date();
                        let year = currentDate.getFullYear();
                        let month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        let day = ('0' + currentDate.getDate()).slice(-2);
                        let randomNum = Math.floor(1000 + Math.random() * 9000);
                        no_invoice = 'INV' + '-' + month + year + '-' +
                            randomNum; // Mengubah nilai no_invoice
                    }

                    // Format tanggal
                    let currentDate = new Date(); // Mendapatkan tanggal dan waktu saat ini
                    let formattedDate = currentDate.toISOString();

                    selectedSiswa.push({
                        id: $(this).data('id'),
                        nama: $(this).data('nama'),
                        sekolah: $(this).data('sekolah'),
                        tagihan: $(this).data('harga') || {{ $data->harga }},
                        pembayaran: $(this).data('pembayaran') || 0,
                        no_invoice: no_invoice,
                        jatuh_tempo: $(this).data('jatuh_tempo') ||
                            '{{ $data->jatuh_tempo }}',
                        no_sertiv: $(this).data('no_sertiv') || '',
                        status_sertiv: $(this).data('status_sertiv') || 'Belum Terbit',
                        nilai: $(this).data('nilai') || '',
                        created_at: formattedDate,
                        updated_at: formattedDate,
                    });
                });

                if (selectedSiswa.length === 0) {
                    alert('Tidak ada siswa yang dipilih!');
                    return;
                }

                console.log(selectedSiswa);
                $.ajax({
                    url: "{{ route('add_siswa.update', ['id' => $data->id]) }}", // Endpoint untuk membuat data baru
                    method: "POST", // Gunakan POST untuk operasi CREATE
                    data: {
                        _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan
                        siswa: selectedSiswa, // Data siswa yang akan ditambahkan
                    },
                    success: function(response) {
                        $('#tambah_siswa').modal('hide'); // Tutup modal
                        location.reload();
                        // console.log(response);
                        alert('Data siswa berhasil ditambahkan!');
                    },
                    error: function(xhr) {
                        alert(xhr.responseText);
                        console.error("Error:", xhr
                            .responseText); // Tampilkan pesan error di console
                    },
                });
            });

            // Tambah data pertemuan kelas
            $('#submit').on('click', function() {
                let form = $('#form_pertemuankelas'); // Tangkap form
                let formData = form.serialize(); // Ambil data dari form

                $.ajax({
                    type: "POST",
                    url: "{{ route('pembelajaran.store') }}", // Pastikan rutenya sesuai
                    data: formData,
                    success: function(response) {
                        alert('Data berhasil disimpan');
                        form.trigger('reset'); // Reset form setelah berhasil
                        $('#pertemuan_kelas').modal('hide'); // Tutup modal
                        location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseText);
                        let errors = xhr.responseJSON
                            .errors; // Ambil error dari response JSON

                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                let errorMessage = errors[key].join(', ');
                                $('#error-' + key).text(errorMessage);
                            }
                        }
                    }
                });
            });

            // Hapus Siswa di kelas
            $(document).on('click', '.btn-hapus', function() {
                var murid_id = $(this).data('id');
                var kelas_id = $(this).data('kelas-id');

                console.log('Murid ID: ' + murid_id);
                console.log('Kelas ID: ' + kelas_id);


                $.ajax({
                    url: '{{ route('murid.hapus') }}',
                    type: 'POST',
                    data: {
                        id: murid_id,
                        kelas_id: kelas_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert("Data berhasil dihapus");
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            });
        });

        // Edit data Pertemuan 
        $(document).ready(function() {
            let selectedId = null;

            // Ketika tombol Edit ditekan
            $(document).on('click', '#editBtn', function() {
                selectedId = $(this).data('id'); // Ambil ID dari data-id
                console.log('ID yang dipilih:', selectedId);
            });

            // Ketika tombol Kirim ditekan
            $('#Editsubmit').on('click', function() {
                const pertemuanKe = $('input[name="pertemuan"]').val();

                $.ajax({
                    url: "{{ route('pembelajaran.update', ['id' => '__selectedId__']) }}"
                        .replace('__selectedId__',
                            selectedId), // Ubah URL dengan menggantikan selectedId
                    type: 'POST',
                    data: {
                        _method: 'PATCH',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        pertemuan: pertemuanKe,
                    },
                    success: function(response) {
                        $('#editPertemuanModal').modal('hide'); // Menutup modal

                        // Menampilkan notifikasi
                        const notification = $('<div>')
                            .text('Pertemuan berhasil diupdate!')
                            .css({
                                position: 'fixed',
                                top: '20px',
                                right: '20px',
                                padding: '10px 40px',
                                background: '#4CAF50',
                                color: '#fff',
                                borderRadius: '5px',
                                boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
                                zIndex: 9999,

                            })
                            .appendTo('body');

                        // Menghilangkan notifikasi setelah 3 detik dan reload halaman
                        setTimeout(function() {
                            notification.fadeOut(300, function() {
                                $(this).remove();
                                const form = $(
                                    '#edit_pertemuan_form');
                                form.trigger('reset');
                                location.reload();
                            });
                        }, 2000);
                    },
                    error: function(xhr) {
                        // alert(xhr.responseText);
                        const errors = xhr.responseJSON.errors;
                        if (errors.pertemuan) {
                            $('#pertemuanError').text(errors.pertemuan[0]);
                        }
                    },
                });
            });
        });
    </script>
@endsection
