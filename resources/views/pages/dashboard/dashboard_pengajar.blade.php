@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Dashboard User" />

            <div class="section-body">
                <div class="card author-box card-primary">
                    <div class="card-body">
                        <div class="author-box-left">
                            <img style="width: 100px;height: 100px;object-fit: cover;" alt="image" src=""
                                class="rounded-circle author-box-picture">
                            <div class="clearfix"></div>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                <a href="">
                                    <span>{{ $dataLogin->nama }}</span>

                                    <div class="badge badge-pill badge-success">PENGAJAR</div>
                                </a>
                            </div>
                            <div class="author-box-job mt-3"><i class="fas fa-map-marker">{{ $dataLogin->alamat }}</i>
                        </div>
                        <div class="author-box-job mt-3"><i class="fas fa-phone"></i>{{ $dataLogin->no_telp }}</div>
                        <div class="author-box-job mt-3 mb-3"><i class="fas fa-address-card"></i>
                        </div>
                        <h4 class="mb-3">LEVEL : </h4>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted"></div>
                            <div class="font-weight-bold mb-1">EXP</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" data-width="" aria-valuenow=""
                                    aria-valuemin="0" aria-valuemax="" style="width: %;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">MAX : 99</div>
                            <div class="font-weight-bold mb-1">MEKANIK</div>
                            <div class="progress">
                                <div class="progress-bar bg-success text-dark" role="progressbar" data-width=""
                                    aria-valuenow="" aria-valuemin="0" aria-valuemax="" style="width: %;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">MAX : 99</div>
                            <div class="font-weight-bold mb-1">ELEKTRONIK</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning text-dark" role="progressbar" data-width="%"
                                    aria-valuenow="" aria-valuemin="0" aria-valuemax="" style="width: %;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">MAX : 99</div>
                            <div class="font-weight-bold mb-1">PEMROGRAMAN</div>
                            <div class="progress">
                                <div class="progress-bar bg-danger text-dark" role="progressbar" data-width="%"
                                    aria-valuenow="" aria-valuemin="0" aria-valuemax="" style="width: %;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
