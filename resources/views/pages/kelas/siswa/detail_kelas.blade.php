@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Detail Kelas" />

            {{-- Informasi Pertemuan --}}
            @php
                $hex = $kelas->kategori->color_bg;
                $r = hexdec(substr($hex, 1, 2));
                $g = hexdec(substr($hex, 3, 2));
                $b = hexdec(substr($hex, 5, 2));
                $bb = hexdec(substr($hex, 9, 5));
                $rgba = "rgba($r, $g, $b, 1)";
                $rgbb = "rgba($r, $g, $bb, 0.4)";
            @endphp
            <div class="row">
                <div class="col">
                    <div class="hero text-white hero-bg-image"
                        style="background-image: url({{ asset('img_videogaming1.png') }});
                                                        background-color: {{ $rgba }};
                                                        padding:35px;">
                        <div class="hero-inner">
                            <h6 class="text-wrap w-100">
                                {{ ucwords($kelas->nama_kelas) }}
                            </h6>
                            <span class="badge text-light"
                                style="width: 100px; background-color: blue;">{{ $kelas->kategori->kategori_kelas }}</span>
                            <span class="badge text-light"
                                style="width: 100px; background-color: red;">{{ $kelas->program_belajar->tipe_kelas->tipe_kelas }}
                            </span>
                            <p class="lead">{{ $kelas->program_belajar->nama_program }}</p>
                        </div>
                    </div>

                    <div class="card card-hero">
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <div class="ticket-title">
                                        <h4 class="text-primary">
                                            <i class="fas fa-play-circle mr-3 text-primary"></i> Jumlah Pertemuan :
                                        </h4>
                                        <span class="text-black italic font-light ms-3">{{ $jumlah_pertemuan }}
                                            Pertemuan</span>
                                    </div>
                                </div>
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <div class="ticket-title">
                                        <h4 class="text-primary"> <i class="fas fa-layer-group mr-3 text-danger"></i>
                                            Level
                                            : </h4>
                                        @if ($kelas->program_belajar->level == 'mudah')
                                            <span class="badge badge-success px-3 py-2 ms-3"
                                                style="font-size: 0.8rem;">Beginner</span>
                                        @elseif ($kelas->program_belajar->level == 'sedang')
                                            <span class="badge badge-warning px-3 py-2 ms-3"
                                                style="font-size: 0.8rem;">Intermediate</span>
                                        @elseif ($kelas->program_belajar->level == 'sulit')
                                            <span class="badge badge-danger px-3 py-2 ms-3"
                                                style="font-size: 0.8rem;">Advanced</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <div class="ticket-title w-100">
                                        <h4 class="text-primary">
                                            <i class="fas fa-award mr-3 text-warning"></i> Poin didapat :
                                        </h4>

                                        <ul class="list-unstyled mb-0">
                                            <table class="ms-3">
                                                <tr>
                                                    <td style="width: 160px">
                                                        <span><i class="fas fa-cogs text-warning"></i> Mekanik</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-danger">+{{ $kelas->program_belajar->mekanik }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span><i class="fas fa-bolt text-success"></i> Elektronik</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-success">+{{ $kelas->program_belajar->elektronik }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span><i class="fas fa-code text-primary"></i>
                                                            Pemrograman</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-primary">+{{ $kelas->program_belajar->pemrograman }}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aktifitas Siswa --}}
            <h2 class="section-title">Aktifitas</h2>
            <div class="row">
                <div class="col-12">
                    <div class="activities">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($pembelajaran as $pertemuan)
                            <div class="activity">
                                <div class="activity-icon bg-success text-light shadow-primary">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="card shadow-sm border-0 p-3 mb-3">
                                                <div class="card-body">
                                                    <div class="header">
                                                        <h6 class="text-primary mb-1"># Pertemuan Ke
                                                            {{ $no++ }}
                                                        </h6>
                                                        @if ($pertemuan->tanggal != null)
                                                            <p class="text-success small mb-2">
                                                                <i class="fas fa-calendar-alt"></i>
                                                                {{ ucfirst(\Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d-m-Y')) }}
                                                            </p>
                                                        @endif

                                                        <hr class="my-2">
                                                    </div>

                                                    @if ($pertemuan->tanggal != null)
                                                        <div class="row d-flex flex-column flex-md-row mt-3">
                                                            <div class="col-md-3 col-sm-12 mb-2 border-desktop">
                                                                <h6 class="text-dark mb-1 text-tengah">
                                                                    <i class="fas fa-user-tie"></i> Pengajar
                                                                </h6>
                                                                <p class="mb-0 text-tengah">
                                                                    {{ $pertemuan->kelas->pengajar->nama }}</p>
                                                            </div>

                                                            <div class="col-md-3 col-sm-12 mb-2 border-desktop">
                                                                <h6 class="text-dark mb-1 text-tengah"><i
                                                                        class="fas fa-book-open"></i>
                                                                    Materi</h6>
                                                                <p class="mb-0 text-tengah">{!! Str::words($pertemuan->materi ?? '-', 10, '...') !!}</p>
                                                            </div>

                                                            <div class="col-md-3 col-sm-12 mb-2">
                                                                <h6 class="text-dark mb-1 text-tengah"><i
                                                                        class="fas fa-user-check"></i>
                                                                    Kehadiran</h6>
                                                                <p class="mb-0 text-tengah">
                                                                    @if (!empty($pertemuan->absensi_siswa))
                                                                        {{ $pertemuan->absensi_siswa[0]['nama'] }} <br>
                                                                        @if ($pertemuan->absensi_siswa[0]['presensi'] == 'H')
                                                                            <span
                                                                                class="badge bg-success px-2 py-2 w-100 w-ukuran-leptop">
                                                                                Hadir
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-danger px-2 py-2 w-100 w-ukuran-leptop">
                                                                                Tidak Hadir
                                                                            </span>
                                                                        @endif
                                                                    @else
                                                                        <span
                                                                            class="badge bg-danger px-2 py-2 w-100 w-ukuran-leptop">
                                                                            Tidak Hadir
                                                                        </span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p>Pembelajaran Belum di lakukan</p>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <h2 class="section-title">Total Presensi Siswa</h2>
                <div class="row">
                    @foreach ($daftar_siswa as $siswa)
                        @if ($siswa->id == $dataLogin->id)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">{{ $siswa->nama }}</h6>
                                        <hr>
                                        <p class="text-small"><i class="fa fa-school mr-2"></i> {{ $siswa->sekolah }}</p>
                                        <p class="text-small"><i class="fa fa-signal mr-2"></i> Presentase Kehadiran</p>
                                        <div class="budget-price">
                                            <div class="budget-price d-flex align-items-center w-100">
                                                <div class="position-relative w-100"
                                                    style="height: 5px; background-color: #e0e0e0;">
                                                    <div class="position-absolute top-0 left-0 bg-{{ $siswa->persentase <= 50 ? 'danger' : 'primary' }}"
                                                        style="width: {{ $siswa->persentase }}%; height: 5px;">
                                                    </div>
                                                </div>
                                                {{-- Teks persentase --}}
                                                <span class="ms-2">
                                                    {{ number_format($siswa->persentase, 0, ',', '.') }}%
                                                </span>
                                            </div>
                                        </div>
                                        @if ($siswa->nilai != null)
                                            <hr>
                                            <div class="p-3 text-center">
                                                <h4 class="text-primary">Nilai Siswa</h4>
                                                @php
                                                    $nilaiColor = [
                                                        'A' => 'text-success',
                                                        'B' => 'text-success',
                                                        'Gagal' => 'text-danger',
                                                    ];
                                                @endphp

                                                <h2 class="fw-bold {{ $nilaiColor[$siswa->nilai] ?? 'text-dark' }}">
                                                    {{ $siswa->nilai }}
                                                </h2>
                                                <p class="text-muted">Nilai sudah diberikan</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach

                </div>

                <h2 class="section-title">Status Kelas</h2>
                <div class="col-12">
                    <div class="card shadow-sm py-4 text-center">
                        @if ($kelas->status_kelas == 'aktif')
                            <h2 class="text-danger">Kelas Belum Selesai</h2>
                            <p class="text-muted">Proses Pembelajaran Sedang Berlangsung.</p>
                        @elseif ($kelas->status_kelas == 'selesai' && $status_pembayaran == 'Belum Lunas')
                            <h2 class="text-success">Kelas Telah Selesai</h2>
                            <p class="text-muted m-auto" style="width: 80%">
                                Kelas telah selesai. Masih terdapat kekurangan pembayaran sebesar
                                <span class="text-dark fw-bold text-nowrap">Rp.
                                    {{ number_format($kekurangan, 0, ',', '.') }}</span>.
                                Silakan lunasi untuk dapat mengunduh sertifikat. Terima kasih 🙏
                            </p>

                            <button type="button" class="btn btn-success btn-lg mt-3  mx-5 disabled">
                                <i class="fas fa-check"></i> Lihat Sertifikat
                            </button>
                        @else
                            <h2 class="text-success">Kelas Telah Selesai</h2>
                            <p class="text-muted m-auto" style="width: 80%">
                                Selamat! Kamu telah menyelesaikan kelas ini.
                                Terima kasih atas partisipasinya. Semoga ilmunya bermanfaat dan tetap semangat 👍
                            </p>

                            @foreach ($daftar_siswa as $item)
                                @if ($item->id == $dataLogin->id)
                                    <form method="post" action="{{ route('sertiv.siswa') }}">
                                        @csrf
                                        <input type="hidden" name="no_sertiv" value="{{ $kelas->id }}">
                                        <input type="hidden" name="nama" value="{{ $item->nama }}">
                                        <input type="hidden" name="nilai" value="{{ $item->nilai }}">
                                        <input type="hidden" name="sekolah" value="{{ $item->sekolah }}">
                                        <input type="hidden" name="tanggal_mulai" value="{{$awal->tanggal}}">
                                        <input type="hidden" name="tanggal_selesai" value="{{$akhir->tanggal}}">
                                        <input type="hidden" name="keterangan" value=" Telah menyelesaikan pelatihan {{ strtoupper($kelas->program_belajar->nama_program) }}">

                                        <button type="submit" class="btn btn-success btn-lg mt-3">
                                            <i class="fas fa-check"></i> Lihat Sertifikat
                                        </button>
                                    </form>
                                @endif
                            @endforeach
                        @endif

                    </div>
                </div>

            </div>
        </section>
    </div>

    <style>
        .ticket-item:hover {
            background-color: #e2e1e1;
            cursor: pointer;
            transition: 0.3s;
        }

        .bg-putih {
            background-color: #f8f8f8
        }

        @media (min-width: 768px) {
            .border-desktop {
                border-right: 1px solid #dee2e6;
            }

            .w-ukuran-leptop {
                width: 70% !important;
            }

            .text-tengah {
                text-align: center;
            }
        }
    </style>
@endsection
