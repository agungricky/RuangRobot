@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kelas" />

            {{-- Button --}}
            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-success mb-4 mr-3"><i class="fas fa-file"></i>
                        Generate Report</a>
                    <a href="" class="btn btn-info mb-4 mr-3"><i class="fas fa-check"></i> Tandai Kelas Selesai</a>
                    <a href="" class="btn btn-primary mb-4"><i class="fas fa-print"></i>
                        Generate Sertifikat</a>
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
                                                <div class="profile-desc-item pull-right">31 Siswa</div>
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
                                                <th style="width: 20%;" class="text-center">Materi Ajar</th>
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
                            return `<div class="text-tabel text-start"><a href="" class="fw-bold text-primary">Pertemuan Ke ${data}<a/></div>`;
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
                            if (data == null) {
                                color = 'warning';
                            }else{
                                color = 'success';
                            }
                            return `<div class="text-tabel text-start"><span class="level w-100 bg-${color}">${data ? data : 'Belum dilaksanakan'}</span></div>`;
                        }
                    },
                    {
                        data: 'materi',
                        render: function(data, type, row) {
                            return `<div class="text-tabel text-center">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                <form action="{{ url('/program_belajar/delete/${row.id}') }}" method="POST" class="d-inline">
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
