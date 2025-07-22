@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    @if ($jumlah_pertemuan > 0)

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
                                                        padding:35px";>
                            <div class="hero-inner">
                                <h6 class="text-wrap w-100">
                                    {{ucwords($kelas->nama_kelas)}}
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
                                    <div class="d-flex flex-column flex-md-row">
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
                                                    <i class="fas fa-chalkboard-teacher mr-3 text-success"></i> Penanggung
                                                    Jawab
                                                    Kelas :
                                                </h4>
                                                <span class="ms-4">{{ $kelas->pengajar->nama }}</span>
                                            </div>
                                        </div>
                                        <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                            <div class="ticket-title">
                                                <h4 class="text-primary"> <i
                                                        class="fas fa-layer-group mr-3 text-danger"></i>
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
                                @if ($pertemuan->tanggal != null)
                                    <div class="activity">
                                        <div class="activity-icon bg-success text-light shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail w-100">
                                            <div class="mb-2">
                                                <span class="font-weight-bold text-small"># Pertemuan Ke
                                                    {{ $no++ }}</span> <br>
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
                                @else
                                    @if ($kelas->status_kelas == 'aktif')
                                        <div class="activity">
                                            <div class="activity-icon bg-primary text-light shadow-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="activity-detail w-100">
                                                <div class="mb-2">
                                                    <span class="font-weight-bold text-small"># Pertemuan Ke
                                                        {{ $no++ }}</span>
                                                </div>
                                                <button class="btn btn-block btn-primary btn-lg mb-2 absen"
                                                    data-id="{{ $pertemuan->id }}"
                                                    data-idkelas="{{ $pertemuan->kelas->id }}">
                                                    <i class="fas fa-clipboard-check"></i> Absen
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if ($kelas->status_kelas == 'aktif')
                        <h2 class="section-title">Daftar Siswa</h2>
                        <div class="row">
                            @foreach ($dataFix as $siswa)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">{{ $siswa->nama }}</h6>
                                            <hr>
                                            <p class="text-small"><i class="fa fa-school mr-2"></i> {{ $siswa->sekolah }}
                                            </p>
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
                                            @if ($siswa->nilai == null)
                                                <button data-idsiswa="{{ $siswa->id }}"
                                                    data-id_kelas="{{ $kelas->id }}"
                                                    class="btn btn-block btn-success btn_selesai_siswa">
                                                    <i class="fas fa-check"></i> Selesaikan</button>
                                            @else
                                                <div class="p-3 text-center">
                                                    <h4 class="text-primary">Nilai Siswa</h4>
                                                    @php
                                                        $nilaiColor = [
                                                            'A' => 'text-success',
                                                            'B' => 'text-success', // 'Warning' harus huruf kecil
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
                            @endforeach
                        </div>
                    @endif

                    <h2 class="section-title">Status Kelas</h2>
                    <div class="col-12">
                        <div class="card shadow-sm py-5 text-center">
                            @if ($kelas->status_kelas == 'aktif')
                                <h2 class="text-danger">Kelas Belum Selesai</h2>
                                <p class="text-muted">Pastikan semua tugas telah diselesaikan sebelum menyelesaikan kelas.
                                </p>

                                <form method="post" action="{{ route('kelas.selesai', ['id' => $kelas->id]) }}">
                                    @csrf
                                    <input type="hidden" name="status_kelas" value="selesai">
                                    <button type="submit" class="btn btn-success btn-lg">
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
        {{-- ============= MODAL ABSEN SISWA ============ --}}
        {{-- ============================================ --}}
        <div class="modal fade" id="absen_siswa" tabindex="-1" role="dialog" aria-labelledby="ajaxModallLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajaxModallLabel">Absen Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form_absen">
                            <div id="siswa_hadir"></div>

                            <h6 class="mt-4">Tanggal Pertemuan :</h6>
                            <span class="error-tanggal text-danger"></span>
                            <input type="date" name="tanggal" placeholder="Tanggal" class="form-control mb-4">

                            <h6>Materi :</h6>
                            <span class="error-materi text-danger"></span>
                            <input type="text" name="materi" placeholder="Materi" class="form-control mb-4">

                            <h6>Catatan Pengajar :</h6>
                            <textarea id="editor" name="catatan_pengajar"></textarea>

                            <input type="hidden" name="pengajar" value="{{ $dataLogin->nama }}">
                            <input type="hidden" name="pengajar_id" value="{{ $dataLogin->id }}">
                        </form>
                        <div class="m-4 d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-primary" id="simpan_sementara"><i
                                    class="fas fa-clipboard-check"></i>
                                Simpan Sementara
                            </button>
                            <button type="button" id="final-submit" class="btn btn-success"
                                data-id="{{ $pertemuan->id }}" data-idkelas="{{ $kelas->id }}">
                                <i class="fas fa-clipboard-check"></i> Final Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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

                            <div class="checking_pengajar_bantu d-none">
                                <span style="border-bottom: 0.0px solid #343a40;"></span>
                                <li class="list-group-item">
                                    <b><i class="fas fa-user-check"></i> Absen Sebagai Pengajar Bantu </b>
                                    <form id="absen_pengajar_bantu" class="mt-2">
                                        <input type="hidden" name="pengajar" value="{{ $dataLogin->id }}" />
                                        <input type="hidden" name="gaji_pengajar"
                                            value="{{ $kelas->gaji_pengajar }}" />
                                        <input type="hidden" name="gaji_transport"
                                            value="{{ $kelas->gaji_transport }}" />
                                        <input type="hidden" name="status_pembayaran" value="pending" />
                                        <input type="hidden" name="status_pengajar" value="Pengajar Bantu" />
                                    </form>
                                    <button class="btn btn-block btn-warning btn-lg mb-2" id="pengajar_bantu"
                                        data-id="{{ $pertemuan->id }}" data-id_kelas="{{ $kelas->id }}">
                                        <i class="fas fa-clipboard-check"></i>
                                        Absen
                                    </button>
                                </li>
                            </div>

                        </ul>
                        <h6 class="mt-3 mb-3">Siswa Yang Hadir :</h6>
                        <div id="list_siswa"></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main-content">
            <section class="section">
                <x-title_halaman title="Daftar Kelas Saya" />

                <div class="row">
                    <div class="col">
                        <div class="col-lg-6 offset-lg-3 col-12">
                            <!-- Error Inner -->
                            <div class="error-inner d-flex flex-column justify-content-center align-items-center text-center"
                                style="min-height: 50vh;">
                                <h1>404 Oop's</h1>
                                <span class="fs-5">Pertemuan Kelas belum diatur!</span>
                                <p>Hubungi Admin dan minta tambahkan Pertemuan.</p>
                            </div>
                            <!--/ End Error Inner -->
                        </div>
                    </div>
                </div>
            </section>
        </div>

    @endif


    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/trumbowyg.min.css') }}">
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js') }}"></script>
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

            $('#editor').trumbowyg();

            // Detail Pertemuan Selesai
            $(".btn-detail").on("click", function() {
                id = $(this).data("id");

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

                        $.ajax({
                            type: "GET",
                            url: `/search_pengajarbantu/${id}/json`,
                            dataType: "json",
                            success: function(response) {
                                if (response.data == false) {
                                    $('.checking_pengajar_bantu').removeClass(
                                        'd-none');
                                } else {
                                    $('.checking_pengajar_bantu').addClass(
                                        'd-none');
                                }
                            }
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

            // Absen Pengajar Bantu
            $("#pengajar_bantu").on("click", function() {
                id_kelas = $(this).data("id_kelas");
                let dataLogin = "{{ $dataLogin->nama }}";

                let result = confirm(
                    `${dataLogin}, Apakah yakin ingin melakukan absen sebagai pengajar bantu?`);

                let formdata = $("#absen_pengajar_bantu").serialize();
                formdata += "&_token=" + $('meta[name="csrf-token"]').attr("content");
                formdata += "&idpembelajaran=" + id;
                formdata += "&id_kelas=" + id_kelas;

                $.ajax({
                    type: "POST",
                    url: `{{ url('/pengajar/bantu/absen/${id}') }}`,
                    data: formdata,
                    dataType: "json",
                    success: function(response) {
                        if (result == true) {
                            Swal.fire("Berhasil!", response.message, "success");
                            $("#detailmodal").modal("hide");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Terjadi kesalahan", "error");
                    }
                });
            });


            // 🔹 Simpan data absen ke Local Storage berdasarkan ID Kelas
            function simpanKeStorage(id_kelas) {
                let storageKey = `dataAbsen_Kelas_${id_kelas}`;
                localStorage.setItem(storageKey, JSON.stringify(dataAbsen));
            }

            // 🔹 Ambil data dari Local Storage berdasarkan ID Kelas
            function ambilDariStorage(id_kelas) {
                let storageKey = `dataAbsen_Kelas_${id_kelas}`;
                return JSON.parse(localStorage.getItem(storageKey)) || [];
            }

            // 🔹 Saat tombol absen diklik (ambil data dari API jika LocalStorage kosong)
            let dataAbsen = [];
            $(".absen").on("click", function() {
                let id_kelas = $(this).data("idkelas");

                // Ambil data dari localStorage
                let savedData = ambilDariStorage(id_kelas);

                // Ambil data terbaru dari API
                $.ajax({
                    type: "GET",
                    url: `{{ url('/absen/siswa/${id_kelas}') }}`,
                    dataType: "json",
                    success: function(response) {
                        let apiData = response.data.map(siswa => ({
                            id: siswa.id,
                            nama: siswa.nama,
                            presensi: siswa.presensi || "I" // Default "I"
                        }));

                        // Gabungkan data baru dengan data di localStorage tanpa menghapus data lama
                        apiData.forEach(siswaBaru => {
                            let existingSiswa = savedData.find(siswa => siswa.id ===
                                siswaBaru.id);
                            if (!existingSiswa) {
                                savedData.push(siswaBaru);
                            }
                        });

                        // Simpan kembali ke localStorage
                        simpanKeStorage(id_kelas, savedData);

                        // Render data absen
                        dataAbsen = savedData;
                        renderAbsen();
                    }
                });

                $("#absen_siswa").modal("show");
            });

            // 🔹 Toggle Hadir/Izin saat klik siswa
            $(document).on("click", ".siswa-item", function() {
                let siswaId = $(this).data("id");
                let id_kelas = $(".absen").data("idkelas"); // Ambil ID kelas aktif
                let checkbox = $(this).find(".checkbox-presensi");
                checkbox.prop("checked", !checkbox.prop("checked"));

                let isChecked = checkbox.prop("checked");
                let icon = $(this).find("i");
                let statusDiv = $(this);

                // Ubah tampilan ikon & warna
                if (isChecked) {
                    icon.removeClass("text-danger fas fa-times-circle").addClass(
                        "text-success fas fa-check-circle");
                    statusDiv.removeClass("border-danger").addClass("border-success");
                } else {
                    icon.removeClass("text-success fas fa-check-circle").addClass(
                        "text-danger fas fa-times-circle");
                    statusDiv.removeClass("border-success").addClass("border-danger");
                }

                // Perbarui data dalam array
                let siswaIndex = dataAbsen.findIndex(s => s.id == siswaId);
                if (siswaIndex !== -1) {
                    dataAbsen[siswaIndex].presensi = isChecked ? "H" : "I";
                }

                // Simpan perubahan ke LocalStorage berdasarkan ID kelas
                simpanKeStorage(id_kelas);
            });

            // 🔹 Fungsi untuk merender ulang daftar siswa hadir
            function renderAbsen() {
                $("#siswa_hadir").html("");

                $.each(dataAbsen, function(index, siswa) {
                    let isHadir = siswa.presensi === "H";
                    let statusClass = isHadir ? "border-success" : "border-danger";
                    let icon = isHadir ? '<i class="fas fa-check-circle text-success"></i>' :
                        '<i class="fas fa-times-circle text-danger"></i>';

                    let listItem = `
                        <div class="d-flex align-items-center p-3 mb-2 bg-putih border-start border-4 ${statusClass} rounded siswa-item" 
                            data-id="${siswa.id}">
                            <input type="checkbox" class="form-check-input d-none checkbox-presensi" ${isHadir ? 'checked' : ''}> 
                            <div class="me-3 fs-4">${icon}</div> 
                            <div class="fw-bold">${siswa.nama}</div>
                        </div>
                    `;

                    $("#siswa_hadir").append(listItem);
                });
            }

            // 🔹 Saat modal dibuka kembali, tampilkan data dari LocalStorage sesuai ID Kelas
            $("#absen_siswa").on("show.bs.modal", function() {
                let id_kelas = $(".absen").data("idkelas"); // Ambil ID kelas aktif
                let savedData = ambilDariStorage(id_kelas);

                if (savedData.length > 0) {
                    dataAbsen = savedData;
                    renderAbsen();
                }
            });

            // 🔹 Simpan Sementara
            $("#simpan_sementara").on("click", function() {
                let id_kelas = $(".absen").data("idkelas");
                simpanKeStorage(id_kelas);
                Swal.fire("Berhasil!", "Data berhasil di simpan", "success");
                $("#absen_siswa").modal("hide");
            });

            // 🔹 Simpan Permanen (Final Submit)
            $("#final-submit").on("click", function() {
                let id_kelas = $(".absen").data("idkelas");
                let id = $(".absen").data("id");
                let gaji_transport = '{{ $kelas->gaji_transport }}'

                simpanKeStorage(id_kelas);

                let savedData = ambilDariStorage(id_kelas);
                let formData = $("#form_absen").serializeArray();

                // 🔹 Ubah FormData menjadi Object
                let formObject = {};
                $.each(formData, function(_, field) {
                    formObject[field.name] = field.value;
                });

                // 🔹 Tambahkan tanggal dan absensi ke form
                formObject.absensi = savedData;
                formObject.status_tersimpan = "permanen";
                formObject.id_kelas = id_kelas;
                formObject.gaji_transport = gaji_transport;

                $.ajax({
                    type: "POST",
                    url: `{{ url('/absen/siswa/store/${id}') }}`,
                    data: JSON.stringify(formObject),
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        Swal.fire("Berhasil!", response.message, "success");
                        localStorage.removeItem(`dataAbsen_Kelas_${id_kelas}`);
                        $("#form_absen")[0].reset();
                        $("#detailmodal").modal("hide");
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $(".error-tanggal").text(errors.tanggal ? errors.tanggal[0] : "");
                            $(".error-materi").text(errors.materi ? errors.materi[0] : "");
                        }
                        Swal.fire("Gagal!", response.message, "error");
                    }
                });
            });


            // =========================================================//
            // ===============  PRESENTASE DATA SISWA ==================//
            // =========================================================//
            let id_siswa;

            function pilihNilai() {
                return Swal.fire({
                    title: "📜 Konfirmasi Nilai",
                    html: `
                            <p>Pilih nilai untuk siswa:</p>
                            <div style="display: flex; gap: 30px; justify-content: center;">
                                <label><input type="radio" name="nilai" value="A"> A</label>
                                <label><input type="radio" name="nilai" value="B"> B</label>
                                <label><input type="radio" name="nilai" value="Gagal"> Gagal</label>
                            </div>
                        `,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "✅ Simpan",
                    cancelButtonText: "❌ Batal",
                    preConfirm: () => {
                        let nilai = document.querySelector('input[name="nilai"]:checked');
                        if (!nilai) {
                            Swal.showValidationMessage("⚠️ Pilih salah satu nilai!");
                            return false;
                        }
                        return nilai.value;
                    }
                });
            }

            $(".btn_selesai_siswa").on("click", function() {
                let id_siswa = $(this).data("idsiswa");
                let id_kelas = $(this).data("id_kelas");

                let now = new Date();
                let tanggal = now.getDate();
                let bulan = now.getMonth() + 1;
                let tahun = now.getFullYear();

                let bulanRomawi = {
                    1: 'I',
                    2: 'II',
                    3: 'III',
                    4: 'IV',
                    5: 'V',
                    6: 'VI',
                    7: 'VII',
                    8: 'VIII',
                    9: 'IX',
                    10: 'X',
                    11: 'XI',
                    12: 'XII'
                };

                let no_sertiv = `${id_kelas}/RUANGROBOT/${bulanRomawi[bulan]}/${tahun}`;

                pilihNilai().then((nilai) => {
                    // console.log("Nilai yang dipilih:", nilai);
                    $.ajax({
                        type: "POST",
                        url: `{{ url('/siswa/selesai/${id_kelas}/${id_siswa}') }}`,
                        data: {
                            _method: "PATCH",
                            nilai: nilai.value,
                            no_sertiv: no_sertiv,
                            status_sertiv: "Terbit",
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(response) {
                            // console.log("Sukses:", response);
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Data berhasil diperbarui.",
                                timer: 2000,
                                showConfirmButton: false
                            });

                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat memperbarui data.",
                                footer: `<pre>${xhr.responseText}</pre>`
                            });
                        }
                    });
                });
            });

        });
    </script>
@endsection
