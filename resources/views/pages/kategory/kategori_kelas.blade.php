@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kategori Kelas" />
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Kategori Kelas" id="#kategori_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;" class="text-center">Jenis Kelas</th>
                                                <th style="width: 80%;" class="text-start">Opsi</th>
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
    <div class="modal fade" id="kategori_kelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0;">
                    <form id="kategoriForm" method="POST">
                        @csrf
                        <div id="inputFieldsContainer" class="mb-0">
                            <x-form.input_text label="Nama Kategori" name="kategori"
                                placeholder="Meker | Programing | dll ...." />
                            <div id="errorMessages" class="text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer mt-2 pt-0">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="submitKategori" class="btn btn-success">Kirim</button>
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
                    url: "{{ route('kategori_kelas.json') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'jenis_kelas',
                        render: function(data, type, row, meta) {
                            return `<div class="text-start fw-bold text-tabel">${data}</div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex gap-1">
                                    <a href="{{ url('/kategori_kelas/edit/${row.id}') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ url('/kategori_kelas/delete/${row.id}') }}" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Menambahkan Data
            $('#submitKategori').on('click', function() {
                let form = $('#kategoriForm'); // Tangkap form
                let formData = form.serialize(); // Ambil data dari form

                $.ajax({
                    type: "POST",
                    url: "{{ route('kategori_kelas.store') }}", // Pastikan rutenya sesuai
                    data: formData,
                    success: function(response) {
                        form.trigger('reset'); // Reset form setelah berhasil
                        $('#form_kelas').modal('hide'); // Tutup modal
                        location.reload();
                    },
                    error: function(xhr) {
                        // Menangkap error dari server dan menampilkan pesan error
                        let errors = xhr.responseJSON.errors; // Ambil error dari response JSON
                        let errorMessages = '';

                        // Loop melalui error dan tampilkan pesan kesalahan
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += '<p>' + errors[key].join(', ') + '</p>';
                            }
                        }

                        // Menampilkan pesan error
                        $('#errorMessages').html(
                            errorMessages); // Pastikan ada elemen untuk menampilkan error
                    }
                });
            });
        });
    </script>
@endsection
