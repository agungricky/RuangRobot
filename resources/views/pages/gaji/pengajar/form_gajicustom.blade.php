@extends('main.layout')
@section('content')
    @if (session('error'))
        <x-sweetalert.failed />
    @endif
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Abse Gaji Custom" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('gajicustom.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <select id="pekerjaan" class="form-control select2" name="pekerjaan">
                                                @foreach ($data as $item)
                                                    <option value={{ $item->id }}>{{ $item->nama_pekerjaan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control" placeholder="Masukan Tanggal"
                                                name="tanggal" value="{{ old('tanggal') }}">
                                            <x-validation_form.error name="tanggal" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea style="height: 150px;" class="form-control" name="keterangan" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                            <x-validation_form.error name="keterangan" />
                                        </div>

                                        <input type="hidden" name="idpengajar" value="{{ $dataLogin->id }}">
                                        <input type="hidden" name="status" value="pending">
                                    </div>

                                    <button class="btn btn-success btn-lg shadow-sm">
                                        <i class="fas fa-save me-2" style="font-size: 1rem;"></i> Simpan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .select2-container--default .select2-selection--single {
            padding-top: 6px !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Pekerjaan",
                allowClear: true
            });
        });
    </script>
@endsection
