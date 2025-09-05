@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif
    @if (session('error'))
        <x-sweetalert.failed />
    @endif


    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex gap-3">
                                    <x-button.button_add_modal message="Tambah Kelas" id="#form_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center align-middle"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;" class="text-center">Nama Kelas</th>
                                                <th style="width: 10%;" class="text-center">Kode Kelas</th>
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
                <div class="modal-body pb-0">
                    <form id="data_form" method="POST">
                        @csrf
                        <div id="inputFieldsContainer">
                            <div class="field">
                                <div class="row">
                                    <div class="col-8 mb-3">
                                        <x-form.input_text name="nama_kelas" label="Nama Kelas"
                                            placeholder="Masukan Nama Kelas" />
                                        <div id="error-nama_kelas" class="text-danger"></div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="kode_kelas">Kode Kelas</label>
                                        <input type="text" id="kode_kelas" name="kode_kelas" class="form-control"
                                            placeholder="Masukan kode kelas" />
                                        <div id="error-kode_kelas" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="penanggung_jawab">Penanggung Jawab Kelas</label>
                                        <input type="text" id="penanggung_jawab_autocomplete" class="form-control"
                                            placeholder="Pilih Penanggung Jawab Kelas" />
                                        <input type="hidden" id="penanggung_jawab" name="penanggung_jawab" />
                                        <div id="error-penanggung_jawab" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="">Jenis Kelas</label>
                                        <select class="form-control" name="kategori_kelas">
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}">{{ $item->kategori_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-form.input_clock name="mulai" id="mulai" label="Durasi Belajar"
                                            placeholder="Jam Mulai" />
                                        <div id="error-mulai" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-form.input_clock name="selesai" id="selesai" label="Durasi Belajar"
                                            placeholder="Jam Selesai" />
                                        <div id="error-selesai" class="text-danger"></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="nama_program">Program Belajar</label>
                                        <input type="text" id="nama_program_autocomplete" class="form-control"
                                            placeholder="Pilih Program Belajar" />
                                        <input type="hidden" id="nama_program" name="nama_program" />
                                        <div id="error-nama_program" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-form.input_number name="gaji_pengajar" label="Gaji Pengajar"
                                            placeholder="masukan nominal gaji pengajar" />
                                        <div id="error-gaji_pengajar" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-form.input_number name="gaji_transport" label="Gaji Transport"
                                            placeholder="masukan nominal gaji transport" />
                                        <div id="error-gaji_transport" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-form.input_number name="harga_kelas" label="Harga Kelas"
                                            placeholder="masukan nominal Harga kelas" />
                                        <div id="error-harga_kelas" class="text-danger"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-form.input_tanggal name="jatuh_tempo" label="Tanggal Jatuh tempo"
                                            placeholder="Masukan Jatuh Tempo Pembayaran" />
                                        <div id="error-jatuh_tempo" class="text-danger"></div>
                                    </div>

                                    <input type="hidden" class="form-control" name="status_kelas" value="aktif" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-2">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="submit" class="btn btn-success">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .clockpicker-popover {
            z-index: 2050 !important;
        }

        /* Pastikan dropdown muncul di atas elemen lain */
        .ui-autocomplete {
            z-index: 9999;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .bg-secondary-dark {
            background-color: #888888 !important;
            color: white;
        }

        .is-invalid {
            border-color: red;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: `/kelas/{{ $id }}`,
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
                            return `<div class="text-tabel fw-bold text-start text-justify">${data}</div>`;
                        }
                    },
                    {
                        data: 'kode_kelas',
                        render: function(data, type, row) {
                            return `<div class="text-tabel fw-bold text-center text-justify">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="text-center">
                                    <span class="badge text-white px-3 py-2 rounded-pill fw-bold"
                                          style="background-color: ${data.kategori.color_bg};">
                                        ${data.kategori.kategori_kelas}
                                    </span>
                                </div>`;
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
                                color = 'success';
                            } else if (data == 'selesai') {
                                color = 'secondary-dark';
                            }
                            return `<div class="text-center level"><span class="level bg-${color}">${data}</span></div>`;
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            var date = new Date(data);
                            var day = String(date.getDate()).padStart(2, '0');
                            var month = String(date.getMonth() + 1).padStart(2, '0');
                            var year = date.getFullYear();
                            return `<div class="text-center text-tabel fw-bold">${day}-${month}-${year}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ url('/kelas/detail/${row.id}') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-arrow-right fa-lg"></i></a>
                                    <a href="{{ url('/kelas/edit/${row.id}') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                    {{-- <button class="btn btn-danger btn-sm" disabled title="Dimatikan untuk mencegah pengahapusan siswa">
                                        <i class="fa-solid fa-trash"></i>
                                    </button> --}}

                                    <form action="{{ url('/kelas/delete/${row.id}') }}" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="kelas" value="{{ $id }}">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                </form>
                            </div>
                            `;
                        }
                    }
                ]
            });

            // Jam Mulai
            $('#mulai').clockpicker({
                autoclose: true,
                placement: 'top',
            });

            // Jam Selesai
            $('#selesai').clockpicker({
                autoclose: true,
                placement: 'top',
            });

            // Auto Complate program Belajar
            $.ajax({
                url: "{{ route('form_programbelajar.json') }}",
                method: "GET",
                success: function(response) {
                    // Buat array objek dengan nama program dan ID
                    var programs = response.data.map(function(item) {
                        return {
                            label: item.nama_program,
                            value: item.nama_program,
                            id: item.id
                        };
                    });

                    $('#nama_program_autocomplete').autocomplete({
                        source: programs,
                        minLength: 1,
                        autoFocus: true,
                        select: function(event, ui) {
                            // Set nilai input teks dan ID
                            $('#nama_program_autocomplete').val(ui.item.label);
                            $('#nama_program').val(ui.item.id);
                            $('#nama_program_autocomplete').removeClass(
                                'is-invalid'); // Hilangkan merah
                            return false;
                        },
                        change: function(event, ui) {
                            // Jika tidak ada item yang dipilih (user ketik manual)
                            if (!ui.item) {
                                $('#nama_program_autocomplete').addClass('is-invalid');
                                $('#nama_program').val(''); // Kosongkan ID hidden
                            }
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });

            // Auto Complate pengajar
            $.ajax({
                url: "{{ route('pengajar.json') }}",
                method: "GET",
                success: function(response) {
                    var penanggungList = response.data.map(function(item) {
                        return {
                            label: item.nama,
                            value: item.nama,
                            id: item.id
                        };
                    });

                    $('#penanggung_jawab_autocomplete').autocomplete({
                        source: penanggungList,
                        minLength: 1,
                        autoFocus: true,
                        select: function(event, ui) {
                            $('#penanggung_jawab_autocomplete').val(ui.item.label);
                            $('#penanggung_jawab').val(ui.item.id);
                            $('#penanggung_jawab_autocomplete').removeClass('is-invalid');
                            return false;
                        },
                        change: function(event, ui) {
                            if (!ui.item) {
                                $('#penanggung_jawab_autocomplete').addClass('is-invalid');
                                $('#penanggung_jawab').val('');
                            }
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });

            // Menambahkan Data
            $('#submit').on('click', function() {
                let form = $('#data_form'); // Tangkap form
                let formData = form.serialize(); // Ambil data dari form
                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "{{ route('kelas.store') }}", // Pastikan rutenya sesuai
                    data: formData,
                    success: function(response) {
                        form.trigger('reset'); // Reset form setelah berhasil
                        $('#form_kelas').modal('hide'); // Tutup modal
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
