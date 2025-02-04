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
                    @foreach ($pembelajaran as $pertemuan)
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
                    $namahari = date('l', strtotime($pertemuan->tanggal));
                    @endphp

                    {{-- @if (Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pertemuan->tanggal)), $pertemuan->materi) ==
                    'Sudah Absen' ||
                    Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pertemuan->tanggal)), $pertemuan->materi) ==
                    'Sudah Absen hi') --}}
                    <div class="activity">
                        <div class="activity-icon bg-success text-light shadow-primary">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="activity-detail w-100">
                            <div class="mb-2">
                                <span class="text-job text-success">{{ $daftar_hari[$namahari] }},
                                    {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }} /
                                    {{ $pertemuan->kelas->durasi_belajar}}</span>
                                <span class="bullet"></span>
                                <button
                                    style="border: 0px;border-radius: 5px;background: #6777ef;color: #fff;padding: 3px 10px;"
                                    class="text-job" onclick="">Detail</button>
                            </div>
                            <p class="mb-2" style="font-size: 15px;">
                                {{ $pertemuan->materi != '' ? $pertemuan->materi : '-' }}
                            </p>
                            {{--
                            <hr> --}}
                            <span class="font-weight-bold text-small"># Pertemuan Ke {{ $no++ }} </span>
                        </div>
                    </div>
                    {{-- @else
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
                    @endif --}}
                    @endforeach

                </div>
            </div>


            <h2 class="section-title">Daftar Siswa</h2>
            <div class="row">
                @foreach ($siswa as $siswas)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title text-primary"><a href="">{{ $siswas->nama_siswa }}</a>
                            </h6>
                            <hr>
                            <p class="text-small"><i class="fa fa-school mr-2"></i> {{ $siswas->sekolah }}</p>
                            <p class="text-small"><i class="fa fa-signal mr-2"></i> Presentase Kehadiran</p>
                            <div class="budget-price">
                                {{-- <div
                                    class="budget-price-square bg-{{ str_replace('%', '', Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count())) <= 50 ? 'danger' : 'primary' }}"
                                    data-width="{{ Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count()) }}"
                                    style="width: {{ Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count()) }};">
                                </div>
                                <div class="budget-price-label">
                                    {{ Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas,
                                    $slot_kelas->count()) }}
                                </div> --}}
                            </div>
                            <hr>
                            {{-- @if (Ceksiswa::get_status($siswas->id, $id) == 'false') --}}
                            <button data-id="" data-nama="{{ $siswas->nama_siswa }}" data-idgen=""
                                onclick="selesaikankelas(this)" class="btn btn-block btn-success"><i
                                    class="fas fa-check"></i> Selesaikan</button>
                            {{-- <a href="#"
                                onclick="selesaikankelas({{ $siswas->id }},{{ $siswas->nama_siswa }},{{ $id }})"
                                class="btn btn-block btn-success selesait" data-id="{{ $siswas->id }}"
                                data-nama="{{ $siswas->nama_siswa }}" data-kelas="{{ $id }}"><i
                                    class="fas fa-check"></i> Selesaikan</a> --}}
                            {{-- @else
                            @if (Ceksiswa::cek_score($siswas->id, $id) == 'C')
                            <p class="font-weight-bold text-danger"><i class="fas fa-times"></i> GAGAL</p>
                            @else
                            <p class="font-weight-bold text-primary"><i class="fas fa-check"></i> SKOR AKHIR :
                                {{ Ceksiswa::cek_score($siswas->id, $id) }}</p>
                            @endif
                            <p class="text-small"><i class="fas fa-star mr-2"></i> {!! Ceksiswa::get_poin($siswas->id,
                                $id) !!}</p>
                            <p></p>
                            @endif --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


            <h2 class="section-title">Status Kelas</h2>
            {{-- @if ($kelas->status == '0') --}}
            <form id="submitselesaifix" method="post" action="">
                @csrf
                <input type="hidden" name="id_kelas" value="">
                <button onclick="event.preventDefault();fixselesaikelas()" class="btn btn-primary"><i
                        class="fas fa-check"></i> Selesaikan Kelas</button>
            </form>
            {{-- @else
            <h2>Kelas Telah Selesai</h2>
            @endif --}}
        </div>
        @endsection