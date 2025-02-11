@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Dashboard Pengajar" />

            <div class="section-body">
                <div class="card author-box card-primary">
                    <div class="card-body">
                        <div class="container">
                            <div class="main-body">

                                <div class="row gutters-sm">
                                    <div class="col-md-4">
                                        <div class="card-body pb-0 mb-0">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                                    class="rounded-circle" width="150">
                                                <div class="mt-3">
                                                    {{-- {{dd($dataLogin)}} --}}
                                                    <h4>{{ isset($dataLogin->username) ? ucfirst($dataLogin->username) : '' }}
                                                    </h4>
                                                    <p class="text-dark mb-1">
                                                        {{ isset($dataLogin->role) ? $dataLogin->role : '' }} Ruang Robot
                                                    </p>
                                                    <p class="text-dark font-size-sm">
                                                        {{ isset($dataLogin->alamat) ? $dataLogin->alamat : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Nama Lengkap</h6>
                                                </div>
                                                <div class="col-sm-9 text-dark">
                                                    {{ isset($dataLogin->nama) ? $dataLogin->nama : '' }}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Email</h6>
                                                </div>
                                                <div class="col-sm-9 text-dark">
                                                    {{ isset($dataLogin->email) ? $dataLogin->email : '' }}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">No Telp</h6>
                                                </div>
                                                <div class="col-sm-9 text-dark">
                                                    {{ isset($dataLogin->no_telp) ? $dataLogin->no_telp : '' }}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Alamat</h6>
                                                </div>
                                                <div class="col-sm-9 text-dark">
                                                    {{ isset($dataLogin->alamat) ? $dataLogin->alamat : '' }}
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="row gutters-sm">
                                            <div class="col-sm-12 mb-3">
                                                <div class="card-body">
                                                    <h6 class="d-flex align-items-center mb-3">
                                                        <i class="material-icons text-info mr-2">Level</i>Penanganan Pembelajaran</h6>
                                                    <small>Elektronik ({{ $dataLogin->elektronik }}/100)</small>
                                                    <div class="progress mb-3" style="height: 15px">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{ $dataLogin->elektronik }}%"
                                                            aria-valuenow="{{ $dataLogin->elektronik }}" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <small>Mekanik ({{ $dataLogin->mekanik }}/100)</small>
                                                    <div class="progress mb-3" style="height: 15px">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: {{ $dataLogin->mekanik }}%" aria-valuenow="{{ $dataLogin->mekanik }}" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <small>Pemrograman ({{ $dataLogin->pemrograman }}/100)</small>
                                                    <div class="progress mb-3" style="height: 15px">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $dataLogin->pemrograman }}%" aria-valuenow="{{ $dataLogin->pemrograman }}" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
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
@endsection
