@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Daftar Kelas Saya" />

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
                                                        padding:35px">
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
                                        <h4 class="text-primary">
                                            <i class="fas fa-chalkboard-teacher mr-3 text-success"></i>
                                            Penanggung Jawab Kelas :
                                        </h4>
                                        <span class="ms-4">{{ $kelas->pengajar->nama }}</span>
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
                            <div class="activity">
                                <div class="activity-icon bg-success text-light shadow-primary">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-detail w-100">
                                    <div class="mb-2">
                                        <span class="font-weight-bold text-small"># Pertemuan Ke {{ $no++ }}</span>
                                        <br>
                                        <span class="text-job text-success">{{ $daftar_hari[$namahari] }},
                                            {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }} /
                                            {{ $pertemuan->kelas->durasi_belajar }}</span>
                                        <span class="bullet"></span>
                                        <button
                                            style="border: 0px; border-radius: 5px; background: #6777ef; color: #fff; padding: 3px 10px;"
                                            class="text-job btn-detail" data-id="{{ $pertemuan->id }}">
                                            Detail
                                        </button>
                                    </div>
                                    <p class="mb-2" style="font-size: 15px;">
                                        <b>Catatan Pengajar :</b> <br>
                                        {!! Str::words($pertemuan->catatan_pengajar ?? '-', 10, '...') !!}

                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <h2 class="section-title">Daftar Siswa</h2>
                <div class="row">
                    @foreach ($dataFix as $siswa)
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
                                        @if ($siswa->nilai == null)
                                            <p class="text-muted">Nilai Belum diberikan</p>
                                        @else
                                            <p class="text-muted">Nilai sudah diberikan</p>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h2 class="section-title">Status Kelas</h2>
                <div class="col-12">
                    <div class="card shadow-sm py-5 text-center">
                        @if ($kelas->status_kelas == 'aktif')
                            <h2 class="text-danger">Kelas Belum Selesai</h2>
                            <p class="text-muted">Pastikan semua tugas telah diselesaikan sebelum menyelesaikan kelas.</p>

                            <form method="post" action="{{ route('kelas.selesai', ['id' => $kelas->id]) }}">
                                @csrf
                                <input type="hidden" name="status_kelas" value="selesai">
                                <button type="submit" class="btn btn-success btn-lg mt-3">
                                    <i class="fas fa-check"></i> Selesaikan Kelas
                                </button>
                            </form>
                        @else
                            <h2 class="text-success">Kelas Telah Selesai</h2>
                            <p class="text-muted">Terima kasih telah menyelesaikan kelas ini!</p>
                            <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                        @endif
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- ============================================ --}}
    {{-- ============= MODAL DETAIL ABSEN ============ --}}
    {{-- ============================================ --}}
    <div class="modal fade" id="detailmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <b><i class="fas fa-user"></i> Pengajar </b>
                            <div class="profile-desc-item pull-right">
                                <span id="getpengajar"></span>
                            </div>
                        </li>
                        <span style="border-bottom: 0.0px solid #343a40;"></span>
                        <li class="list-group-item">
                            <b><i class="fas fa-clock"></i> Waktu Pertemuan </b>
                            <div class="profile-desc-item pull-right">
                                <span id="gettanggal"></span>
                            </div>
                        </li>
                        <span style="border-bottom: 0.0px solid #343a40;"></span>
                        <li class="list-group-item">
                            <b><i class="fas fa-book"></i> Materi </b> <br>
                            <div class="profile-desc-item pull-righ ms-3">
                                <span id="getmateri"></span>
                            </div>
                        </li>
                        <span style="border-bottom: 0.0px solid #343a40;"></span>
                        <li class="list-group-item">
                            <b><i class="fas fa-file-alt"></i> Catatan Pengajar </b> <br>
                            <div class="profile-desc-item pull-righ ms-3">
                                <span id="getcatatan"></span>
                            </div>
                        </li>
                    </ul>
                    <h6 class="mt-3 mb-3">Siswa Yang Hadir :</h6>
                    <div id="list_siswa"></div>
                </div>
            </div>
        </div>
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
    </style>
    <script>
        $(document).ready(function() {
            let id; //id Pertemuan
            let id_kelas; //id Kelas

            // Detail Pertemuan Selesai
            $(".btn-detail").on("click", function() {
                let id = $(this).data("id");

                $.ajax({
                    type: "GET",
                    url: `{{ url('/detail/Absen/${id}/json') }}`,
                    dataType: "json",
                    success: function(response) {
                        $("#getpengajar").text(response.absen.pengajar.nama);

                        let tanggal = response.absen.tanggal;
                        let date = new Date(tanggal);
                        let pertemuan = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        let formattedDate = date.toLocaleDateString('id-ID', pertemuan);
                        $("#gettanggal").text(formattedDate);

                        $("#getmateri").text(response.absen.materi);
                        $("#getcatatan").html(response.absen.catatan_pengajar ? response.absen
                            .catatan_pengajar : "-");

                        // Bersihkan daftar sebelum menambahkan data baru
                        $("#list_siswa").empty();

                        $.each(response.data, function(index, siswa) {
                            let statusClass = siswa.presensi === "H" ?
                                "border-start border-4 border-success" :
                                "border-start border-4 border-danger";
                            let icon = siswa.presensi === "H" ?
                                '<i class="bi bi-check-circle-fill text-success"></i>' :
                                '<i class="bi bi-x-circle-fill text-danger"></i>';

                            let listItem = `
                    <div class="d-flex align-items-center p-3 mb-2 bg-putih ${statusClass} rounded">
                        <div class="me-3 fs-4">${icon}</div>
                        <div class="fw-bold">${siswa.nama}</div>
                    </div>
                `;

                            $("#list_siswa").append(listItem);
                        });

                        // Tampilkan modal
                        $("#detailmodal").modal("show");
                    },
                    error: function(xhr) {
                        console.log("salah Bos : " + xhr.responseJSON.message);
                        alert("Terjadi kesalahan saat mengambil data.");
                    }
                });
            });

        });
    </script>
@endsection
