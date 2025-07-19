@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Update Kategori Pekerjaan" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form
                                    action="{{ route('kategori_pekerjaan.update', ['kategori_pekerjaan' => $kategori_pekerjaan->id]) }}"
                                    method="POST" class="d-flex flex-column gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <div id="inputFieldsContainer" class="mb-0">
                                        <label for="nama_pekerjaan">Nama Pekerjaan</label>
                                        <input type="text" class="form-control" id="nama_pekerjaan"
                                            placeholder="Menyolder || Mengkabeli || dll" name="nama_pekerjaan"
                                            value="{{ old('nama_pekerjaan', $kategori_pekerjaan->nama_pekerjaan) }}">
                                    </div>
                                    <div id="inputFieldsContainer" class="mb-0">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" class="form-control" id="keterangan"
                                            placeholder="Masukan Keterangan" name="keterangan"
                                            value="{{ old('keterangan', $kategori_pekerjaan->keterangan) }}">
                                        <div id="errorketerangan" class="text-danger"></div>
                                    </div>
                                    <div id="inputFieldsContainer" class="mb-0">
                                        <label for="gaji" class="form-label">Nominal Gaji</label>
                                        <input type="text" id="gaji_view" class="form-control"
                                            placeholder="Masukan Nominal Gaji"
                                            value="{{ old('gaji', $kategori_pekerjaan->gaji) }}">
                                        <input type="hidden" name="gaji" id="gaji">
                                        <div id="errornama_pekerjaan" class="text-danger"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
            // Format Rupiah saat diketik
            $('#gaji_view').on('input', function() {
                let angka = $(this).val().replace(/[^,\d]/g, '');
                let split = angka.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                if (split[1] !== undefined) {
                    rupiah += ',' + split[1];
                }

                $(this).val('Rp ' + rupiah);
                let angkaMurni = angka.replace(/\D/g, '');
                $('#gaji').val(angkaMurni);
            });
        });
    </script>
@endsection
