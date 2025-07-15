@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Admistrasi Pendaftaran" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <a href="{{ route('pendaftaran.create') }}">
                                        <button type="button" class="add btn btn-primary mb-3">
                                            <i class="fas fa-plus"></i> Create Form Pendaftaran
                                        </button>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 align-middle" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;" class="text-center">No.</th>
                                                <th style="width: 50%;">Judul Form</th>
                                                <th style="width: 15%;" class="text-center">Kategori</th>
                                                <th style="width: 10%;">Wa</th>
                                                <th style="width: 10%;">Form</th>
                                                <th style="width: 50%;">Tanggal</th>
                                                <th style="width: 15%;">Status</th>
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
        </section>
    </div>

    <script>
        $(document).ready(function() {

            // Menampilkan Data Tabel
            $('#example').DataTable({
                ajax: {
                    type: "GET",
                    url: "{{ route('pendaftaran.index') }}",
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">${meta.row + 1}</div>`;
                        }
                    },
                    {
                        data: 'title',
                        render: function(data, type, row) {
                            return `<div class="text-start fw-bold text-tabel">${data}</>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center">
                                <div class="badge text-white" style="
                                    background-color: ${data.kategori.color_bg};
                                    border-radius: 999px;
                                    padding: 6px 12px;
                                    font-size: 12px;
                                ">
                                    ${data.kategori.kategori_kelas}
                                </div>
                            </div>`
                        }
                    },
                    {
                        data: 'link_group',
                        render: function(data, type, row) {
                            return `
                            <div class="text-center fw-bold text-tabel">
                                <a href="${data}" target="_blank"><i class="fas fa-up-right-from-square"></i></a>
                            </div>`;
                        }
                    },
                    {
                        data: 'link_form',
                        render: function(data, type, row) {
                            return `
                                <div class="text-center fw-bold text-tabel">
                                    <a href="{{ url('${data}') }}" target="__blank"><i class="fas fa-up-right-from-square"></i></a>
                                </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            function formatTanggal(tanggal) {
                                if (!tanggal) return '-';
                                const [year, month, day] = tanggal.split('-');
                                return `${day}-${month}-${year}`;
                            }

                            return `
                                <div class="text-center fw-bold text-tabel">
                                    ${formatTanggal(row.tanggal_p_awal)} <br> - <br>
                                    <small class="text-muted">${formatTanggal(row.tanggal_p_akhir)}</small>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'status_pendaftaran',
                        render: function(data, type, row) {
                            return `<div class="text-center fw-bold text-tabel">${data}</>`;
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
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
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
