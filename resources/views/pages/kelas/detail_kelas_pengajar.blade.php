@extends('main.layout')
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <x-title_halaman title="Daftar Kelas Saya" />
        <a href="{{ route('kelas_saya') }}" class="btn btn-primary btn-lg mb-4">
            <i class="fa fa-arrow-left"></i> Kembali</a>

        <div class="row">
            <div class="col">
                <div class="hero text-white hero-bg-image"
                    style="background-image: url('{{ $kelas->banner != '' ? url('/banner/' . $kelas->banner) : url('/img_videogaming.jpg') }}');padding:35px;">
                    <div class="hero-inner">
                        <h5 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                            {{ ucwords($kelas->nama_kelas) }}</h5>
                        @if ($kelas->kategori_kelas->kategori_kelas == 'Kelas Ekskul')
                        <span class="badge badge-danger">{{ $kelas->kategori_kelas->kategori_kelas
                            }}</span>
                        @elseif ($kelas->kategori_kelas->kategori_kelas == 'Kelas Lomba')
                        <span class="badge badge-primary">{{ $kelas->kategori_kelas->kategori_kelas
                            }}</span>
                        @elseif ($kelas->kategori_kelas->kategori_kelas == 'Kelas Project')
                        <span class="badge badge-warning text-dark">{{
                            $kelas->kategori_kelas->kategori_kelas }}</span>
                        @elseif ($kelas->kategori_kelas->kategori_kelas == 'Kelas Reguler')
                        <span class="badge badge-info">{{ $kelas->kategori_kelas->kategori_kelas }}</span>
                        @elseif ($kelas->kategori_kelas->kategori_kelas == 'Kelas Trial')
                        <span class="badge badge-info">{{ $kelas->kategori_kelas->kategori_kelas }}</span>
                        @endif
                        <p class="lead">{{ $kelas->program_belajar->nama_program }}</p>
                    </div>
                </div>
                <div class="card card-hero">
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            <a href="#" class="ticket-item">
                                <div class="ticket-info">
                                    <div>{{ $kelas->program_belajar->deskripsi }}</div>
                                </div>
                            </a>
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4><i class="fas fa-play-circle mr-3"></i> Pertemuan</h4>
                                </div>
                            </a>
                            <a href="" class="ticket-item">
                                <div class="ticket-title">
                                    <h4><i class="fas fa-chalkboard-teacher mr-3"></i>{{ $kelas->penanggung_jawab }}
                                    </h4>
                                </div>
                            </a>
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4><i class="	fas fa-layer-group mr-3"></i>
                                        @if ($kelas->program_belajar->level == 'mudah')
                                        <span style="font-size:10px !important"
                                            class="badge badge-success"><b>Mudah</b></span>
                                        @elseif ($kelas->program_belajar->level == 'sedang')
                                        <span style="font-size:10px !important"
                                            class="badge badge-warning"><b>Sedang</b></span>
                                        @elseif ($kelas->program_belajar->level == 'sulit')
                                        <span style="font-size:10px !important"
                                            class="badge badge-danger"><b>Sulit</b></span>
                                        @endif
                                    </h4>
                                </div>
                            </a>
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4><i class="	fas fa-star mr-3"></i> Poin Max</h4>
                                </div>
                                <ul class="list-star">
                                    <li>Mekanik : <span style="font-weight:bold" class="text-info">+{{
                                            $kelas->program_belajar->mekanik }}</span></li>
                                    <li>Elektronik : <span style="font-weight:bold" class="text-success">+{{
                                            $kelas->program_belajar->elektronik }}</span></li>
                                    <li>Pemrograman : <span style="font-weight:bold" class="text-danger">+{{
                                            $kelas->program_belajar->pemrograman }}</span></li>
                                </ul>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="section-title">Aktifitas</h2>


        <div class="row">
            <div class="col-12">
                <div class="activities">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($kelas ->pembelajaran as $pembelajaran)
                        @php
                            $daftar_hari = [
                                'Sunday' => 'Minggu',
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                            ];
                            $namahari = date('l', strtotime($pembelajaran->tanggal));
                        @endphp
    
                        {{-- @if (Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pertemuan->tanggal)), $pertemuan->materi) == 'Silahkan Absen Sekarang') --}}
    
                        @if (Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pembelajaran->tanggal)), $pembelajaran->materi) == 'Sudah Absen' ||
                                Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pembelajaran->tanggal)), $pembelajaran->materi) ==
                                    'Sudah Absen hi')
                            <div class="activity">
                                <div class="activity-icon bg-success text-light shadow-primary">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-detail w-100">
                                    <div class="mb-2">
                                        <span class="text-job text-success">{{ $daftar_hari[$namahari] }},
                                            {{ date('d-m-Y', strtotime($$pembelajaran->tanggal)) }} /
                                            {{ $pertemuan->jamm . ' - ' . $$pembelajaran->jams }}</span>
                                        <span class="bullet"></span>
                                        <button
                                            style="border: 0px;border-radius: 5px;background: #6777ef;color: #fff;padding: 3px 10px;"
                                            class="text-job"
                                            onclick="detailkelas({{ $$pembelajaran->id }},'{{ $$pembelajaran->materi }}','{{ $daftar_hari[$namahari] }}, {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }}')">Detail</button>
                                    </div>
                                    <p class="mb-2" style="font-size: 15px;">
                                        {{ $$pembelajaran->materi != '' ? $$pembelajaran->materi : '-' }}</p>
                                    <span class="font-weight-bold text-small"># Pertemuan Ke {{ $no++ }}</span>
                                </div>
                            </div>
                        @else
                            <div class="activity">
                                <div class="activity-icon bg-primary text-light shadow-primary">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="activity-detail w-100">
                                    <div class="mb-2">
                                        <span class="text-job text-primary">{{ $daftar_hari[$namahari] }},
                                            {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }} /
                                            {{ $pertemuan->jamm . ' - ' . $pertemuan->jams }}</span>
                                        <span class="bullet"></span>
                                        <a class="text-job text-success" href="#">Hari Ini</a>
                                    </div>
                                    <button class="btn btn-block btn-primary btn-lg mb-2"
                                        onclick="absen({{ $pertemuan->id }},'{{ $pertemuan->id_kelas }}')"><i
                                            class="fas fa-clipboard-check"></i> Absen</button>
                                    <span class="font-weight-bold text-small"># Pertemuan Ke {{ $no++ }}</span>
                                </div>
                            </div>
                           
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
        @endsection