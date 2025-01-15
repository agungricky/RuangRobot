@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kelas" />

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
                                                <th style="width: 25%;" class="text-center">Nama Kelas</th>
                                                <th style="width: 5%;" class="text-center">Jenis Kelas</th>
                                                <th style="width: 10%;" class="text-center">Gaji Pengajar</th>
                                                <th style="width: 10%;" class="text-center">Gaji Transport</th>
                                                <th style="width: 10%;" class="text-center">Status Kelas</th>
                                                <th style="width: 10%;" class="text-center">Dibuat Tanggal</th>
                                                <th style="width: 20%;" class="text-center">Opsi</th>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div id="inputFieldsContainer">
                            <div class="field-group mb-3 shadow p-3 rounded bg-white">
                                <div class="field">
                                    <div class="row m">
                                        <div class="col-12 mb-3">
                                            <x-form.input_text name="nama_kelas" label="Nama Kelas"
                                                placeholder="nama kelas" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <x-form.input_text name="durasi_belajar" label="Durasi Belajar"
                                                placeholder="durasi belajar" />
                                        </div>
                                        <div class="col-12 mb-3">
                                            {{-- <x-form.input_dropdown name="program_belajar" label="Program Belajar" placeholder="Program Belajar" /> --}}
                                            <label for="">Program Belajar</label>
                                            <select class="form-control" name="program_belajar">
                                                <option value="">Pilih Program Belajar</option>
                                                <option value="program1">Maker</option>
                                                <option value="program2">Programming</option>
                                                <option value="program3">Lomba</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3">
                                            {{-- <x-form.input_dropdown name="jenis_kelas" label="jenis Kelas" placeholder="Jenis Kelas" /> --}}
                                            <label for="">Jenis Kelas</label>
                                            <select class="form-control" name="jenis_kelas">
                                                <option value="">Pilih Jenis Kelas</option>
                                                <option value="program1">Kelas Ekskul</option>
                                                <option value="program2">Kelas Reguler</option>
                                                <option value="program3">Kelas Lomba</option>
                                                <option value="program4">Kelas Maker</option>
                                                <option value="program5">Kelas Programming</option>
                                                <option value="program6">Kelas Game Programming</option>
                                                <option value="program7">Kelas Project</option>
                                            </select>
                                        </div> 
                                        <div class="col-12 mb-3">
                                            <x-form.input_text name="penanggung_jawab" label="Penanggung Jawab"
                                                placeholder="Penanggung jawab" />
                                        </div>
                                        <div class="col-12 mb-3">
                                            <x-form.input_text name="gaji_pengajar" label="Gaji Pengajar"
                                                placeholder="gaji_pengajar" />
                                        </div>
                                        <div class="col-12 mb-3">
                                            <x-form.input_text name="gaji_transport" label="Gaji Transport"
                                                placeholder="gaji_transport" />
                                        </div>
                                        <div class="col-12 mb-3">
                                            {{-- <x-form.input_dropdown name="status_kelas" label="Status Kelas" placeholder="Status Kelas" /> --}}
                                            <label for="">Status form_kelas</label>
                                            <select class="form-control" name="program_belajar">
                                                <option value="">Pilih Status Kelas</option>
                                                <option value="program1">Selesai</option>
                                                <option value="program2">belum selesai</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <x-form.input_text name="create_at" label="Dibuat Pada"
                                                placeholder="tanggal" type="date" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
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
                    url: "{{ route('kelas.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama_kelas',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold text-start">${data}</div>`;
                        }
                    },
                    {
                        data: 'jenis_kelas',
                        render: function(data, type, row) {
                            if (data == 'Ekskul') {
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
                        data: 'gaji_pengajar',
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
                        data: 'gaji_transport',
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
                        data: 'status_kelas',
                        render: function(data, type, row) {
                            if (data == 'aktif') {
                                color = 'warning';
                            }
                            else if (data == 'selesai') {
                                color = 'success';
                            }
                            return `<div class="text-center level"><span class="level bg-${color}">${data}</span></div>`;
                        }
                    },
                    {
                        data: 'updated_at',
                        render: function(data, type, row) {
                            var date = new Date(data);
                            var day = String(date.getDate()).padStart(2, '0');
                            var month = String(date.getMonth() + 1).padStart(2, '0');
                            var year = date.getFullYear();
                            return `<div class="text-center text-tabel">${day}-${month}-${year}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                    <a href="" class="btn btn-success btn-sm"><i class="fa-solid fa-arrow-right"></i>Selengkapnya</a>
                                    <a href="" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>Hapus</button>
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
