@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Program Belajar" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Program Belajar" id="#program_belajar" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center align-middle"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;" class="text-center">Program belajar</th>
                                                <th style="width: 30%;" class="text-center">Deskripsi</th>
                                                <th style="width: 10%;" class="text-center">Level</th>
                                                <th style="width: 10%;" class="text-center">Jenis Kelas</th>
                                                <th style="width: 15%;" class="text-center">Poin</th>
                                                <th style="width: 10%;" class="text-center">Aksi</th>
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
    <div class="modal fade" id="program_belajar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Program Belajar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="programBelajar_Form" method="POST">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-12 my-2">
                                <x-form.input_text label="Nama Program Belajar" placeholder="Program Belajar"
                                    name="nama_program" />
                            </div>
                            <div class="col-12 my-2">
                                @php
                                    $option = [
                                        'mudah' => 'Beginner (Pemula)',
                                        'sedang' => 'Intermediate (Menengah)',
                                        'sulit' => 'Advanced (Lanjutan)',
                                    ];
                                @endphp
                                <x-form.input_dropdown label="Level" name="level" :option="$option" />
                            </div>
                            <div class="col-12 my-2">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control"></textarea>
                            </div>
                            <div class="col-12 my-2">
                                <label for="tipe_kelas">Tipe Kelas</label>
                                <select class="form-control" name="tipe_kelas" id="tipe_kelas">
                                    @foreach ($options_form as $value)
                                        <option value="{{ $value->id }}">{{ $value->tipe_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 my-2">
                                <x-form.input_radiopoin label="Bobot Nilai Mekanik" name="mekanik" />
                            </div>
                            <div class="col-12 my-2">
                                <x-form.input_radiopoin label="Bobot Nilai Elektronik" name="elektronik" />
                            </div>
                            <div class="col-12 my-2">
                                <x-form.input_radiopoin label="Bobot Nilai Pemrograman" name="pemrograman" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex pt-2">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="submitprogram_belajar" class="btn btn-success">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('program_belajar.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'nama_program',
                        render: function(data, type, row) {
                            return `<div class="text-tabel text-start fw-bold">${data}</div>`;
                        }
                    },
                    {
                        data: 'deskripsi',
                        render: function(data, type, row) {
                            if (!data) return '';

                            const words = data.split(' ');
                            const limited = words.slice(0, 10).join(' ');
                            const suffix = words.length > 10 ? ' .......' : '';

                            return `<div class="text-tabel text-start">${limited}${suffix}</div>`;
                        }
                    },
                    {
                        data: 'level',
                        render: function(data, type, row) {
                            if (data == 'mudah') {
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
                        data: 'tipe_kelas',
                        render: function(data, type, row) {
                            return `<div class="text-tabel text-center">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <div class="text-center text-nowrap text-success fw-bold">
                                        M${row.mekanik} &#8226; E${row.elektronik} &#8226; P${row.pemrograman}
                                    </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                <a href="{{ url('/program_belajar/edit/${row.id}') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ url('/program_belajar/delete/${row.id}') }}" method="POST" class="d-inline">
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
            $('#submitprogram_belajar').on('click', function() {
                let form = $('#programBelajar_Form'); // Tangkap form
                let formData = form.serialize(); // Ambil data dari form
                // alert(formData);

                $.ajax({
                    type: "POST",
                    url: "{{ route('program_belajar.store') }}", // Pastikan rutenya sesuai
                    data: formData,
                    success: function(response) {
                        form.trigger('reset'); // Reset form setelah berhasil
                        $('#program_belajar').modal('hide'); // Tutup modal
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

            // Sumernote Editor field
            $('#deskripsi').summernote({
                height: 100,
                placeholder: 'Tulis deskripsi program di sini...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endsection
