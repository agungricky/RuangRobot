@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Admistrasi Pendaftaran" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('pendaftaran.store') }}">
                                    @csrf
                                    <div class="field">
                                        <div class="row g-3">
                                            <div class="col-8">
                                                <x-form.input_text name="title" label="Judul Form" placeholder="" />
                                                <div id="error-title" class="text-danger"></div>
                                            </div>

                                            <div class="col-4">
                                                <label for="status_pendaftaran">Kategori</label>
                                                <select name="kategori_id" class="form-control" required>
                                                    @foreach ($kategori as $item)
                                                        <option value="{{ $item->id }}">{{ $item->kategori_kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div id="error-status_pendaftaran" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <x-form.input_text name="link_group" label="Link Grup WA" placeholder="" />
                                                <div id="error-link_group" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="tanggal_p_awal">Tanggal Pembukaan</label>
                                                <input type="date" name="tanggal_p_awal" class="form-control">
                                                <div id="error-tanggal_p_awal" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="tanggal_p_akhir">Tanggal Penutupan</label>
                                                <input type="date" name="tanggal_p_akhir" class="form-control">
                                                <div id="error-tanggal_p_akhir" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="status_pendaftaran">Status Pendaftaran</label>
                                                <select name="status_pendaftaran" class="form-control" required>
                                                    <option value="open">Open</option>
                                                    <option value="closed">Closed</option>
                                                </select>
                                                <div id="error-status_pendaftaran" class="text-danger"></div>
                                            </div>

                                            <div class="col-12 mb-4">
                                                <button class="btn btn-success btn-lg shadow-sm mt-2 w-100" type="submit">
                                                    <i class="fas fa-save me-2" style="font-size: 1rem;"></i> Simpan
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#kelas_id').select2({
                placeholder: "-- Pilih Kelas --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <style>
        .select2-container--default .select2-selection--single {
            padding: 5px 0px 0px 10px !important;
        }
    </style>
@endsection
