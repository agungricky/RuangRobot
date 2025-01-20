@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Kelas" />

            {{-- Button --}}
            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-success mb-4 mr-3"><i class="fas fa-file"></i>
                        Generate Report</a>
                    <a href="" class="btn btn-info mb-4 mr-3"><i class="fas fa-check"></i> Tandai Kelas Selesai</a>
                    <a href="" class="btn btn-primary mb-4"><i class="fas fa-print"></i>
                        Generate Sertifikat</a>
                </div>
            </div>

            <div class="section-body">
                {{-- Informasi Kelas --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="hero text-white hero-bg-image"
                            style="background-image: url({{ asset('img_videogaming.jpg') }}); padding:35px;">
                            <div class="hero-inner">
                                <h5>{{ $data->nama_kelas }}</h5>
                                <span class="badge badge-danger">{{ $data->jenis_kelas }}</span>
                                <span
                                    class="ml-2 badge {{ $data->status_kelas == 'aktif' ? 'badge-warning' : 'badge-success' }}">{{ $data->status_kelas }}</span>
                                <p class="lead">{{ $data->nama_program }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <style>
                                    .border-bottom {
                                        border-bottom: 2px solid #dbdbdb !important;
                                    }
                                </style>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-play-circle"></i> Pertemuan Kelas</b>
                                                <div class="profile-desc-item pull-right">{{ $jp }} Pertemuan
                                                </div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-users"></i> Jumlah Siswa</b>
                                                <div class="profile-desc-item pull-right">31 Siswa</div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-user"></i> Penanggung Jawab Kelas </b>
                                                <div class="profile-desc-item pull-right">{{ $data->penanggung_jawab }}
                                                </div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-layer-group"></i> Level </b>
                                                <div class="profile-desc-item pull-right">
                                                    @if ($data->level == 'mudah')
                                                        <span class="badge badge-success"><b>Mudah</b></span>
                                                    @elseif ($data->level == 'sedang')
                                                        <span class="badge badge-warning"><b>Sedang</b></span>
                                                    @elseif ($data->level == 'sulit')
                                                        <span class="badge badge-danger"><b>Sulit</b></span>
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-dollar-sign"></i> Harga Kelas </b>
                                                <div class="profile-desc-item pull-right text-success">Rp. 200.000</div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-dollar-sign"></i> Gaji Pengajar </b>
                                                <div class="profile-desc-item pull-right">Rp. 25.000 / Pertemuan</div>
                                            </li>
                                            <li class="list-group-item border-bottom">
                                                <b><i class="fas fa-star"></i> Poin Yang Akan Didapatkan </b>
                                                <div class="profile-desc-item pull-right">
                                                    <ul class="list-star">
                                                        <li>Mekanik : <span style="font-weight:bold"
                                                                class="text-info">+1</span></li>
                                                        <li>Elektronik : <span style="font-weight:bold"
                                                                class="text-success">+1</span></li>
                                                        <li>Pemrograman : <span style="font-weight:bold"
                                                                class="text-danger">+1</span></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tambah pertemuan Kelas --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Pertemuan Kelas" id="#pertemuan_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 5%;" class="text-center">Pertemuan Ke</th>
                                                <th style="width: 10%;" class="text-center">Pengajar</th>
                                                <th style="width: 10%;" class="text-center">Taggal Pertemuan</th>
                                                <th style="width: 15%;" class="text-center">Materi Ajar</th>
                                                <th style="width: 20%;" class="text-center">Catatan Pengajar</th>
                                                <th style="width: 20%;" class="text-center">Status Pertemuan</th>
                                                <th style="width: 20%;" class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tambah Siswa Kelas --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="add-items d-flex">
                                    <x-button.button_add_modal message="Tambah Siswa" id="#form_kelas" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 25%;" class="text-center">Nama Kelas</th>
                                                <th style="width: 5%;" class="text-center">Jenis Kelas</th>
                                                <th style="width: 10%;" class="text-center">Gaji Pengajar</th>
                                                <th style="width: 10%;" class="text-center">Gaji Transport</th>
                                                <th style="width: 10%;" class="text-center">Status Kelas</th>
                                                <th style="width: 10%;" class="text-center">Dibuat Tanggal</th>
                                                <th style="width: 20%;" class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
