@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Pembayaran Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="m-3">
                                    <h4 class="fw-bold">Selesaikan Pembayaran Kelas Siswa</h4>
                                    <p class="text-muted">Jika sudah melakukan pembayaran, harap konfirmasi kepada pihak
                                        administrasi kami dinomor <a href="wa.me/085655770506"> +6285655770506 </a> atas
                                        nama <span class="text-primary">Julian Sahertian</span>.</p>

                                    <h5 class="mt-4">
                                        <i class="fas fa-money-bill-wave text-warning me-1"></i> Belum Terbayar
                                    </h5>

                                    @foreach ($data_siswa as $item)
                                        @if ($item['status_pembayaran'] == 'Belum Lunas')
                                            <form action="{{ route('detail_pembayaran.siswa') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="no_invoice" value="{{ $item['no_invoice'] }}">
                                                <input type="hidden" name="nama" value="{{ $item['nama'] }}">
                                                <input type="hidden" name="sekolah" value="{{ $item['sekolah'] }}">
                                                <input type="hidden" name="updated_at" value="{{ $item['updated_at'] }}">
                                                <input type="hidden" name="nama_kelas" value="{{ $item['nama_kelas'] }}">
                                                <input type="hidden" name="nama_program"
                                                    value="{{ $item['nama_program'] }}">
                                                <input type="hidden" name="status_kelas"
                                                    value="{{ $item['status_kelas'] }}">
                                                <input type="hidden" name="tagihan" value="{{ $item['tagihan'] }}">
                                                <input type="hidden" name="pembayaran" value="{{ $item['pembayaran'] }}">
                                                <input type="hidden" name="kekurangan" value="{{ $item['kekurangan'] }}">
                                                <input type="hidden" name="status_pembayaran"
                                                    value="{{ $item['status_pembayaran'] }}">


                                                <div
                                                    class="border p-3 rounded mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                    <div
                                                        class="d-flex flex-column flex-md-row align-items-center mb-3 mb-md-0 text-center text-md-start">
                                                        <img src="{{ asset('kapal.png') }}"
                                                            class="rounded mb-2 mb-md-0 me-md-3" width="60"
                                                            style="max-width: 100%; height: auto;">
                                                        <div>
                                                            <span class="fw-bold">{{ $item['nama_kelas'] }}</span><br>
                                                            <span class="text-muted">Lihat detail pembayaran</span>
                                                            <button type="submit" class="btn-link">Selengkapnya</button>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative">
                                                        <span class="position-absolute top-0 text-dark">Kekurangan</span>
                                                        <div class="d-flex align-items-center mt-4">
                                                            <span class="fw-bold fs-5">Rp.
                                                                {{ number_format($item['kekurangan'], 0, ',', '.') }}</span>
                                                            <span class="fs-3 fw-bold mx-2"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endforeach

                                    <h5 class="mt-4 text-dark" id="toggle-pembayaran" style="cursor: pointer;">
                                        <i class="fas fa-check-circle text-success me-1"></i> Pembayaran Selesai
                                    </h5>
                                    <div id="pembayaran-detail" style="display: none;">
                                        @foreach ($data_siswa as $item)
                                            @if ($item['status_pembayaran'] == 'Lunas')
                                                <form action="{{ route('detail_pembayaran.siswa') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="no_invoice"
                                                        value="{{ $item['no_invoice'] }}">
                                                    <input type="hidden" name="nama" value="{{ $item['nama'] }}">
                                                    <input type="hidden" name="sekolah" value="{{ $item['sekolah'] }}">
                                                    <input type="hidden" name="updated_at"
                                                        value="{{ $item['updated_at'] }}">
                                                    <input type="hidden" name="nama_kelas"
                                                        value="{{ $item['nama_kelas'] }}">
                                                    <input type="hidden" name="nama_program"
                                                        value="{{ $item['nama_program'] }}">
                                                    <input type="hidden" name="status_kelas"
                                                        value="{{ $item['status_kelas'] }}">
                                                    <input type="hidden" name="tagihan" value="{{ $item['tagihan'] }}">
                                                    <input type="hidden" name="pembayaran"
                                                        value="{{ $item['pembayaran'] }}">
                                                    <input type="hidden" name="kekurangan"
                                                        value="{{ $item['kekurangan'] }}">
                                                    <input type="hidden" name="status_pembayaran"
                                                        value="{{ $item['status_pembayaran'] }}">

                                                    <div
                                                        class="border rounded p-3 mt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                        <div
                                                            class="d-flex flex-column flex-md-row align-items-center mb-3 mb-md-0">
                                                            <img src="{{ asset('atm.png') }}"
                                                                class="rounded mb-2 mb-md-0 me-md-3" width="50">
                                                            <div>
                                                                <span class="fw-bold">{{ $item['nama_kelas'] }}</span><br>
                                                                <span class="text-muted">Lihat detail pembayaran</span>
                                                                <button type="submit"
                                                                    class="btn-link">Selengkapnya</button>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-center justify-content-md-start">
                                                            <div class="form-control text-dark text-center fw-bold bg-light px-3 py-2 w-100 w-md-50 w-lg-25 h-100"
                                                                style="pointer-events: none; user-select: none; overflow-wrap: break-word; word-break: break-word; min-width: 0; max-width: 100%; padding: 15px 15px !important;">
                                                                Pembayaran Telah di Terima & berstatus LUNAS
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .btn-link {
            all: unset;
            color: #2680ff;
            /* Warna default link */
            text-decoration: underline;
            /* Garis bawah seperti <a> */
            cursor: pointer;
        }

        .btn-link:hover {
            color: darkblue;
            /* Efek hover seperti <a> */
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#toggle-pembayaran').on('click', function() {
                $('#pembayaran-detail').slideToggle();
            });
        });
    </script>
@endsection
