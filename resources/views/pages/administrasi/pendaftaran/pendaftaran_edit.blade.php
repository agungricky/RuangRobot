@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Edit Pendaftaran" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST"
                                    action="{{ route('pendaftaran.update', ['pendaftaran' => $indexPendaftaran->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="field">
                                        <div class="row g-3">
                                            <div class="col-8">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ old('title', $indexPendaftaran->title) }}">
                                                <div id="error-title" class="text-danger"></div>
                                            </div>

                                            <div class="col-4">
                                                <label for="status_pendaftaran">Kategori</label>
                                                <select name="kategori_id" class="form-control" required>
                                                    @foreach ($kategori as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('kategori_id', $indexPendaftaran->kategori_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->kategori_kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div id="error-status_pendaftaran" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="link_group">Link Grup WA</label>
                                                <input type="text" class="form-control" id="link_group" name="link_group"
                                                    value="{{ old('link_group', $indexPendaftaran->link_group) }}">
                                                <div id="error-link_group" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="tanggal_p_awal">Tanggal Pembukaan</label>
                                                <input type="date" name="tanggal_p_awal" class="form-control"
                                                    value="{{ old('tanggal_p_awal', $indexPendaftaran->tanggal_p_awal) }}">
                                                <div id="error-tanggal_p_awal" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="tanggal_p_akhir">Tanggal Penutupan</label>
                                                <input type="date" name="tanggal_p_akhir" class="form-control"
                                                    value="{{ old('tanggal_p_akhir', $indexPendaftaran->tanggal_p_akhir) }}">
                                                <div id="error-tanggal_p_akhir" class="text-danger"></div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="status_pendaftaran">Status Pendaftaran</label>
                                                <select name="status_pendaftaran" class="form-control" required>
                                                    <option value="open"
                                                        {{ old('status_pendaftaran', $indexPendaftaran->status_pendaftaran ?? '') == 'open' ? 'selected' : '' }}>
                                                        Open
                                                    </option>
                                                    <option value="closed"
                                                        {{ old('status_pendaftaran', $indexPendaftaran->status_pendaftaran ?? '') == 'closed' ? 'selected' : '' }}>
                                                        Closed
                                                    </option>
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
