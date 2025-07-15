@extends('main.layout')
@section('content')
    @if (session('error'))
        <x-sweetalert.failed />
    @endif
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Generate Sertif Custom" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('sertiv.siswa') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label for="no_sertiv">No Sertifikat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Masukan No E-sertiv"
                                                name="no_sertiv" id="no_sertiv" value="{{ old('no_sertiv') }}" required>
                                            <x-validation_form.error name="no_sertiv" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="tanggal">Nama<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Masukan Nama"
                                                name="nama" value="{{ old('nama') }}" required>
                                            <x-validation_form.error name="nama" />
                                        </div>

                                        <div class="col-2">
                                            <label for="nilai">Nilai<span class="text-danger">*</span></label>
                                            <select name="nilai" id="nilai" class="form-control">
                                                <option value="A">Sangat Baik</option>
                                                <option value="B">Baik</option>
                                            </select>
                                            <x-validation_form.error name="nilai" />
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="sekolah">Sekolah</label>
                                            <input type="text" class="form-control" placeholder="Masukan Sekolah"
                                                name="sekolah" value="{{ old('sekolah') }}">
                                            <x-validation_form.error name="sekolah" />
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="tanggal_mulai">Tanggal Mulai<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Tanggal Mulai"
                                                name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                            <x-validation_form.error name="tanggal_mulai" />
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="tanggal_selesai">Tanggal Selesai<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Tanggal Selesai"
                                                name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                            <x-validation_form.error name="tanggal_selesai" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="keterangan">Keterangan<span class="text-danger">*</span></label>
                                            <textarea class="form-control summernote" name="keterangan" required>{{ old('keterangan') }}</textarea>
                                            <x-validation_form.error name="keterangan" />
                                        </div>

                                        <input type="hidden" name="tanggal_diterbitkan" id="tanggal_diterbitkan">

                                        <button class="btn btn-success btn-lg shadow-sm mt-2" type="submit">
                                            <i class="fas fa-save me-2" style="font-size: 1rem;"></i> Simpan
                                        </button>
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
            let tanggal = new Date();

            let hari = tanggal.getDate().toString().padStart(2, '0');
            let bulan = (tanggal.getMonth() + 1).toString().padStart(2, '0');
            let tahun = tanggal.getFullYear();
            let tanggal_diterbitkan = `${hari}-${bulan}-${tahun}`;

            $("#tanggal_diterbitkan").val(tanggal_diterbitkan);

            $('.summernote').summernote({
                height: 150, // tinggi editor
                placeholder: 'Masukkan Keterangan...'
            });
        });
    </script>
@endsection
