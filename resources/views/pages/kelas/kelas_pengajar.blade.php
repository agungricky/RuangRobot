@extends('main.layout')
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <x-title_halaman title="Daftar Kelas Saya" />

        <div class="section-body">
            <div class="card author-box card-primary">
                <div class="card-body">
                    <h2 class="section-title">On Going</h2>
                    <div class="row">
                        @foreach ($kelas as $key => $kls)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('pengajar.detail_kelas', $kls->id) }}" class="linklistkelas">
                                <div class="hero text-white hero-bg-image"
                                    style="background-image: url('{{ $kls->banner != '' ? url('/banner/' . $kls->banner) : url('/img_videogaming.jpg') }}');padding:20px;">
                                    <div class="hero-inner">
                                        <h5 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                            {{ ucwords($kls->nama_kelas) }}</h5>
                                        @if ($kls->kategori_kelas->kategori_kelas == 'Kelas Ekskul')
                                        <span class="badge badge-danger">{{ $kls->kategori_kelas->kategori_kelas
                                            }}</span>
                                        @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Lomba')
                                        <span class="badge badge-primary">{{ $kls->kategori_kelas->kategori_kelas
                                            }}</span>
                                        @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Project')
                                        <span class="badge badge-warning text-dark">{{
                                            $kls->kategori_kelas->kategori_kelas }}</span>
                                        @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Reguler')
                                        <span class="badge badge-info">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                        @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Trial')
                                        <span class="badge badge-info">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                        @endif
                                        <p class="lead">{{ $kls->program_belajar->nama_program }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <h2 class="section-title">Complete <button
                            style="font-size: 12px;border:0;padding: 8px 15px !important;" class="badge badge-primary"
                            type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample">
                            Lihat ({{ $kelas2->count() }})</button></h2>
                    <div class="collapse" id="collapseExample">
                        <div class="row">
                            @foreach ($kelas2 as $key => $kls)
                            <div class="col-md-4 mb-4">
                                <a href="" class="linklistkelas">
                                    <div class="hero text-white hero-bg-image"
                                        style="background-image: url('{{ $kls->banner != '' ? url('/banner/' . $kls->banner) : url('/img_videogaming.jpg') }}');padding:20px;">
                                        <div class="hero-inner">
                                            <h5 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                {{ ucwords($kls->nama_kelas) }}</h5>
                                                @if ($kls->kategori_kelas->kategori_kelas == 'Kelas Ekskul')
                                                <span class="badge badge-danger">{{ $kls->kategori_kelas->kategori_kelas
                                                    }}</span>
                                                @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Lomba')
                                                <span class="badge badge-primary">{{ $kls->kategori_kelas->kategori_kelas
                                                    }}</span>
                                                @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Project')
                                                <span class="badge badge-warning text-dark">{{
                                                    $kls->kategori_kelas->kategori_kelas }}</span>
                                                @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Reguler')
                                                <span class="badge badge-info">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Trial')
                                                <span class="badge badge-info">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                @endif
                                            <p class="lead">{{ $kls->program_belajar->nama_program }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection