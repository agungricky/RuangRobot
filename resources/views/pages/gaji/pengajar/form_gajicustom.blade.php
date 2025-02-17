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
                                        <div class="col-12 mb-3">
                                            <label for="nominal">Nominal</label>
                                            <input type="text" class="form-control" placeholder="Masukan Nominal Gaji"
                                                oninput="formatToRupiah(this)"
                                                value="{{ old('nominal') ? 'Rp ' . number_format(old('nominal'), 0, ',', '.') : '' }}">
                                            <input type="hidden" id="hidden_nominal" name="nominal"
                                                value="{{ old('nominal') }}">
                                            <x-validation_form.error name="nominal" />
                                        </div>

                                        <div class="col-12 mb-3">
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

    <script>
        function formatToRupiah(element) {
            // Hapus semua karakter kecuali angka
            let rawValue = element.value.replace(/[^0-9]/g, "");

            // Format angka ke Rupiah dengan menambahkan titik setiap 3 digit
            let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Update nilai input utama dengan format "Rp"
            element.value = rawValue ? "Rp " + formattedValue : "";

            // Update nilai input hidden dengan angka asli tanpa format
            document.getElementById("hidden_nominal").value = rawValue;
        }
    </script>
@endsection
