@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

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
                                    <p class="text-muted">Jika sudah melakukan pembayaran, harap konfirmasi kepada pihak administrasi kami dinomor <a href="wa.me/085655770506"> +6285655770506 </a> atas nama <span class="text-primary">Julian Sahertian</span>.</p>

                                <h6 class="mt-4">Belum Terbayar</h6>

                                    <div class="border p-3 rounded mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                                        <div class="d-flex flex-column flex-md-row align-items-center mb-3 mb-md-0 text-center text-md-start">
                                            <img src="{{ asset('kapal.png') }}" class="rounded mb-2 mb-md-0 me-md-3" width="60" style="max-width: 100%; height: auto;">
                                            <div>
                                                <span class="fw-bold">Coding Web SMPIT BINA INSANI PHP GENAP 2026/2024 #Kelas A</span><br>
                                                <a href="#" class="text-decoration-none text-primary">Belum Lunas</a>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <span class="position-absolute top-0 text-dark">Harga Kelas</span>
                                            <div class="d-flex align-items-center mt-4">
                                                <span class="fw-bold fs-5">Rp.</span>
                                                <span class="fs-3 fw-bold mx-2">1.000.000</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    

                                    <h6 class="mt-4">Pembayaran Selesai</h6>
                                    <div class="border rounded p-3 mt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                                        <div class="d-flex flex-column flex-md-row align-items-center mb-3 mb-md-0">
                                            <img src="https://i.imgur.com/qHX7vY1.png" class="rounded mb-2 mb-md-0 me-md-3" width="50">
                                            <div>
                                                <span class="fw-bold">Coding Web SMPIT BINA INSANI PHP GENAP 2026/2024 #KelasA</span><br>
                                                <span class="text-muted">Lihat detail pembayaran</span>
                                                <a href="">Selengkapnya</a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center justify-content-md-start">
                                            <div class="form-control text-dark text-center fw-bold bg-light px-3 py-2 w-100 w-md-50 w-lg-25 h-100"
                                                 style="pointer-events: none; user-select: none; overflow-wrap: break-word; word-break: break-word; min-width: 0; max-width: 100%; padding: 15px 15px !important;">
                                                Pembayaran Telah di Terima & berstatus LUNAS
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function () {
            let id = '{{$dataLogin->id}}';
            $.ajax({
                type: "GET",
                url: `{{ url('/pembayaran/{id}') }}`,
                data: "data",
                dataType: "dataType",
                success: function (response) {
                    
                }
            });
        });
    </script>
@endsection
