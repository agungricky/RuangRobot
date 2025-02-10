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
                            <img style="width: 100px;height: 100px;object-fit: cover;" alt="image"
                            src="{{ url('assets/img/avatar/avatar-1.png') }}"
                            class="rounded-circle author-box-picture">
                            <div class="clearfix"></div>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                <a href="" style="text-decoration: none;">
                                    <span>{{ $dataLogin->nama }}</span>
                                    <div class="badge badge-pill badge-success">PENGAJAR</div>
                                </a>
                                
                            </div>
                            <div class="author-box-job mt-3"><i class="fas fa-map-marker"></i>{{ $dataLogin->alamat }}
                        </div>
                        <div class="author-box-job mt-3"><i class="fas fa-phone"></i>{{ $dataLogin->no_telp }}</div>
                        <div class="author-box-job mt-3 mb-3"><i class="fas fa-address-card"></i>
                        </div>
                        <h4 class="mb-3">LEVEL : </h4>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted"></div>
                            <div class="font-weight-bold mb-1">EXP</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" data-width="{{ $kelas->count() }}%"
                                    aria-valuenow="{{ $kelas->count() }}" aria-valuemin="0"
                                    aria-valuemax="{{ 99 }}" style="width: {{ $kelas->count() }}%;">
                                    {{ $kelas->count() }}</div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">MAX : 99</div>
                            <div class="font-weight-bold mb-1">MEKANIK</div>
                            <div class="progress">
                                <div class="progress-bar bg-success text-dark" role="progressbar"
                                data-width="{{ $mekanik > 0 ? ($mekanik / 99) * 100 : 0 }}%"
                                aria-valuenow="{{ $mekanik > 0 ? ($mekanik / 99) * 100 : 0 }}" aria-valuemin="0"
                                aria-valuemax="{{ 99 }}"
                                style="width: {{ $mekanik > 0 ? ($mekanik / 99) * 100 : 0 }}%;">{{ $mekanik }}
                            </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">MAX : 99</div>
                            <div class="font-weight-bold mb-1">ELEKTRONIK</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning text-dark" role="progressbar"
                                    data-width="{{ $elektronik > 0 ? ($elektronik / 99) * 100 : 0 }}%"
                                    aria-valuenow="{{ $elektronik > 0 ? ($elektronik / 99) * 100 : 0 }}" aria-valuemin="0"
                                    aria-valuemax="{{ 99 }}"
                                    style="width: {{ $elektronik > 0 ? ($elektronik / 99) * 100 : 0 }}%;">
                                    {{ $elektronik }}</div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">MAX : 99</div>
                            <div class="font-weight-bold mb-1">PEMROGRAMAN</div>
                            <div class="progress">
                                <div class="progress-bar bg-danger text-dark" role="progressbar"
                                    data-width="{{ $pemrograman > 0 ? ($pemrograman / 99) * 100 : 0 }}%"
                                    aria-valuenow="{{ $pemrograman > 0 ? ($pemrograman / 99) * 100 : 0 }}"
                                    aria-valuemin="0" aria-valuemax="{{ 99 }}"
                                    style="width: {{ $pemrograman > 0 ? ($pemrograman / 99) * 100 : 0 }}%;">
                                    {{ $pemrograman }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
