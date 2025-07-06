@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

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
                                    <x-button.button_add_modal message="Tambah Sekolah" id="#form_sekolah" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 align-middle" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 20%;">Nama Sekolah</th>
                                                <th style="width: 18%;" class="text-start">Penanggung Jawab</th>
                                                <th style="width: 10%;" class="text-center">No-hp</th>
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
    <div class="modal fade" id="form_sekolah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Sekolah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-2">
                    <form id="sekolah_form" method="POST">
                        @csrf
                        <div class="field">
                            <div class="row">
                                <div class="col-4">
                                    <x-form.input_text name="nama_sekolah" label="Nama Sekolah"
                                        placeholder="masukan nama Sekolah" />
                                    <div id="error-nama_sekolah" class="text-danger"></div>
                                </div>
                                <div class="col-4">
                                    <x-form.input_text name="guru" label="Guru Penanggung Jawab"
                                        placeholder="Nama Guru penanggung jawab" />
                                    <div id="error-guru" class="text-danger"></div>
                                </div>
                                <div class="col-4">
                                    <label for="no_hp">No HP (Whatsapp)</label>
                                    <input type="text" id="no_telp" name="no_hp" class="form-control"
                                        placeholder="Gunakan +62....." value="+62" />
                                    <div id="error-no_hp" class="text-danger"></div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="submit_sekolah" class="btn btn-success"><i
                            class="fa-solid fa-floppy-disk fa-lg"></i> Kirim</button>
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
                        data: 'nama_sekolah',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: 'guru',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: 'no_hp',
                        render: function(data, type, row) {
                            return `<div class="text-start"><a href="https://wa.me/${data}" target="_blank">${data}</a></>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                <a href="{{ url('/sekolah/edit/${row.id}') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ url('/sekolah/delete/${row.id}') }}" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                    <input type="hidden" name="_method" value="DELETE">
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

            // Menambahkan Data
            $('#submit_sekolah').on('click', function() {
                let form = $('#sekolah_form');
                let formData = form.serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('sekolah.store') }}",
                    data: formData,
                    success: function(response) {
                        form.trigger('reset');
                        $('#form_sekolah').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;

                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                let errorMessage = errors[key].join(', ');
                                $('#error-' + key).text(errorMessage);
                            }
                        }
                    }
                });
            });

            // Validasi No Telp
            const $input = $('#no_telp');

            if (!$input.val()) {
                $input.val('+62');
            }

            $input.on('focus', function() {
                if (!$input.val().startsWith('+62')) {
                    $input.val('+62');
                }
            });

            $input.on('keydown', function(e) {
                const pos = this.selectionStart;

                // Cegah hapus bagian +62
                if (pos <= 3 && (e.key === 'Backspace' || e.key === 'Delete')) {
                    e.preventDefault();
                }

                // Cegah angka 0 langsung setelah +62
                if (pos === 3 && e.key === '0') {
                    e.preventDefault();
                }
            });

            $input.on('input', function() {
                let val = $input.val();

                // Pastikan selalu diawali +62
                if (!val.startsWith('+62')) {
                    val = '+62';
                }

                // Ambil angka setelah +62 dan hilangkan karakter selain angka
                const angka = val.substring(3).replace(/\D/g, '');
                $input.val('+62' + angka);
            });

        });
    </script>
@endsection
