@extends('main.layout')
@section('content')
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
                                    <x-button.button_add_modal message="Tambah Program Belajar" id="#form_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;" class="text-center">Program belajar</th>
                                                <th style="width: 10%;" class="text-center">Harga</th>
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
    <div class="modal fade" id="form_kelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Program Belajar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="inputForm">
                    <div class="modal-body">
                        <x-form.input_text label="Nama Program Belajar" placeholder="Program Belajar"
                            name="program_belajar" />

                        <x-form.input_number label="Harga" placeholder="Harga" name="harga" />

                        <x-form.input_textArea label="Deskripsi" name="deskripsi" />

                        @php
                            $option = [
                                'Meker' => 'meker',
                                'Coding' => 'coding',
                                'Game Programing' => 'gameprograming',
                                'Lainya' => 'lainya',
                            ];
                        @endphp
                        <x-form.input_dropdown label="Jenis Kelas" name="jenis_kelas" :option="$option" />

                        <x-form.input_radiopoin label="Bobot Nilai Mekanik" name="mekanik" />

                        <x-form.input_radiopoin label="Bobot Nilai Elektronik" name="elektronik" />

                        <x-form.input_radiopoin label="Bobot Nilai Pemrograman" name="pemrograman" />

                        @php
                            $option = [
                                'Beginner (Pemula)' => 'mudah',
                                'Intermediate (Menengah)' => 'sedang',
                                'Advanced (Lanjutan)' => 'sulit',
                            ];
                        @endphp
                        <x-form.input_dropdown label="Level" name="level" :option="$option" />

                    </div>
                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success">Kirim</button>
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
                        data: 'harga',
                        render: function(data, type, row) {
                            const formattedCurrency = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                currencyDisplay: 'narrowSymbol',
                                minimumFractionDigits: 0
                            }).format(data);

                            return `<div class="text-success fw-bold">${formattedCurrency}</div>`;
                        }
                    }, {
                        data: 'deskripsi',
                        render: function(data, type, row) {
                            return `<div class="text-tabel text-start">${data}</div>`;
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
                        data: 'jenis_kelas',
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
                                    <a href="" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
