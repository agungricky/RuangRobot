@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Daftar Kelas Saya" />
            <a href="{{ url('kelas_pengajar') }}" class="btn btn-primary btn-lg mb-4">
                <i class="fa fa-arrow-left"></i> Kembali</a>

            <div class="row">
                <div class="col">
                    <div class="hero text-white hero-bg-image"
                        style="background-image: url('{{ asset('img_videogaming.jpg') }}'); padding:35px;">
                        <div class="hero-inner">
                            @php
                                $bg = ['success', 'primary', 'warning', 'danger'];
                                $randomBg = $bg[array_rand($bg)];
                            @endphp

                            <h5 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ ucwords($kelas->nama_kelas) }}
                            </h5>
                            <span class="badge badge-{{ $randomBg }}">{{ $kelas->kategori_kelas }}</span>
                            <p class="lead">{{ $kelas->nama_program }}</p>
                        </div>
                    </div>

                    <div class="card card-hero">
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <div class="ticket-title">
                                        <h4 class="text-primary">
                                            <i class="fas fa-play-circle mr-3 text-primary"></i> Jumlah Pertemuan :
                                            {{ $jumlah_pertemuan }}
                                        </h4>
                                    </div>
                                </div>
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <div class="ticket-title">
                                        <h4 class="text-primary">
                                            <i
                                                class="fas fa-chalkboard-teacher mr-3 text-success"></i>{{ $kelas->penanggung_jawab }}
                                        </h4>
                                    </div>
                                </div>
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <i class="fas fa-layer-group mr-3 text-warning"></i>
                                    <div class="ticket-title">
                                        <h4 class="text-primary"> Level :
                                            @if ($kelas->level == 'mudah')
                                                <span class="badge badge-success px-3 py-2"
                                                    style="font-size: 0.8rem;">Mudah</span>
                                            @elseif ($kelas->level == 'sedang')
                                                <span class="badge badge-warning px-3 py-2"
                                                    style="font-size: 0.8rem;">Sedang</span>
                                            @elseif ($kelas->level == 'sulit')
                                                <span class="badge badge-danger px-3 py-2"
                                                    style="font-size: 0.8rem;">Sulit</span>
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                                <div class="ticket-item d-flex align-items-center p-3 border-bottom">
                                    <div class="ticket-title w-100">
                                        <h4>Poin didapat :</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex justify-content-between">
                                                <span><i class="fas fa-cogs text-warning mr-2"></i>Mekanik</span>
                                                <span class="badge badge-warning">+{{ $kelas->mekanik }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span><i class="fas fa-bolt text-success mr-2"></i>Elektronik</span>
                                                <span class="badge badge-success">+{{ $kelas->elektronik }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span><i class="fas fa-code text-primary mr-2"></i>Pemrograman</span>
                                                <span class="badge badge-primary">+{{ $kelas->pemrograman }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
                            @if ($pertemuan->tanggal != null)
                                <div class="activity">
                                    <div class="activity-icon bg-success text-light shadow-primary">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="activity-detail w-100">
                                        <div class="mb-2">
                                            <span class="font-weight-bold text-small"># Pertemuan Ke
                                                {{ $pertemuan->pertemuan }}</span> <br>
                                            <span class="text-job text-success">{{ $daftar_hari[$namahari] }},
                                                {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }} /
                                                {{ $pertemuan->durasi_belajar }}</span>
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
                                <div class="activity">
                                    <div class="activity-icon bg-primary text-light shadow-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="activity-detail w-100">
                                        <div class="mb-2">
                                            <span class="font-weight-bold text-small"># Pertemuan Ke
                                                {{ $pertemuan->pertemuan }}</span>
                                        </div>
                                        <button class="btn btn-block btn-primary btn-lg mb-2" onclick="absen()"><i
                                                class="fas fa-clipboard-check"></i> Absen</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <h2 class="section-title">Daftar Siswa</h2>
                <div class="row">
                    @foreach ($daftar_siswa as $siswa)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">{{ $siswa->nama }}</h6>
                                    <hr>
                                    <p class="text-small"><i class="fa fa-school mr-2"></i> {{ $siswa->sekolah }}</p>
                                    <p class="text-small"><i class="fa fa-signal mr-2"></i> Presentase Kehadiran</p>
                                    <div class="budget-price">
                                        <div class="budget-price d-flex align-items-center">
                                            <div class="budget-price-square bg-{{ $siswa->persentase <= 50 ? 'danger' : 'primary' }}"
                                                style="width: {{ $siswa->persentase }}%; height: 5px;">
                                            </div>
                                            <span
                                                class="ml-2">{{ number_format($siswa->persentase, 2, ',', '.') }}%</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <button data-id="" data-nama="Ricky Agung" data-idgen=""
                                        onclick="selesaikankelas(this)" class="btn btn-block btn-success"><i
                                            class="fas fa-check"></i> Selesaikan</button>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h2 class="section-title">Status Kelas</h2>
                @if ($kelas->status == '0')
                    <form id="submitselesaifix" method="post" action="">
                        @csrf
                        <input type="hidden" name="id_kelas" value="">
                        <button onclick="event.preventDefault();fixselesaikelas()" class="btn btn-primary"><i
                                class="fas fa-check"></i>
                            Selesaikan Kelas</button>
                    </form>
                @else
                    <h2>Kelas Telah Selesai</h2>
                @endif
            </div>
        </section>
    </div>

    {{-- ============================================ --}}
    {{-- ============= MODAL ABSEN SISWA ============ --}}
    {{-- ============================================ --}}

    <div class="modal fade" id="ajaxModall" tabindex="-1" role="dialog" aria-labelledby="ajaxModallLabel"
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
                    <form action="" method="post">
                        @csrf
                        <h6>Siswa Yang Hadir :</h6>
                        {{-- @foreach ($siswa as $siswas)
                            <label class="labela">
                                <input type="checkbox"
                                    {{ in_array($siswas->id, $id_siswa_yang_absen_sementara) ? 'checked="true"' : '' }}
                                    name="id[]" class="card-input-element d-none"
                                    value="{{ $siswas->id . ',' . $siswas->nama_siswa . ',' . $siswas->sekolah }}">
                                <div class="card mb-2" style="box-shadow:none !important;">
                                    <div class="card-body" style="background: #f8f8f8;padding:15px;">
                                        <span class="font-weight-bold"><i class="fas fa-check-circle mr-3"></i>
                                            {{ $siswas->nama_siswa }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach --}}
                        <input type="hidden" name="id_kelas" value="">
                        <input type="hidden" id="uuid" name="uuid" placeholder="uuid" class="form-control">
                        <input type="hidden" id="idsesi" name="idsesi" placeholder="idsesi" class="form-control">
                        <h6>Materi :</h6>
                        <input type="text" id="materi" name="materi" placeholder="Materi"
                            class="form-control mb-4" value="">
                        <button type="submit" name="opsi_simpan" value="simpan_sementara" class="btn btn-primary"><i
                                class="fas fa-clipboard-check"></i> Simpan Sementara</button>
                        <button type="submit" name="opsi_simpan" value="submit_final" class="btn btn-success"><i
                                class="fas fa-clipboard-check"></i> Final Submit</button>
                    </form>
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
                            <b><i class="fas fa-book"></i> Materi </b>
                            <div class="profile-desc-item pull-right">
                                <span id="getmateri"></span>
                            </div>
                        </li>
                        <span style="border-bottom: 0.0px solid #343a40;"></span>
                        <li class="list-group-item">
                            <b><i class="fas fa-file-alt"></i> Catatan Pengajar </b>
                            <div class="profile-desc-item pull-right">
                                <span id="getcatatan"></span>
                            </div>
                        </li>
                        <span style="border-bottom: 0.0px solid #343a40;"></span>
                        <li class="list-group-item">
                            <b><i class="fas fa-user-check"></i> Absen Sebagai Pengajar Bantu </b>
                            <form id="absen_pengajar_bantu">
                                <input type="hidden" name="pengajar" value="{{ $dataLogin->id }}" />
                                <input type="hidden" name="gaji_pengajar" value="{{ $kelas->gaji_pengajar }}" />
                                <input type="hidden" name="gaji_transport" value="{{ $kelas->gaji_transport }}" />
                                <input type="hidden" name="status_pembayaran" value="pending" />
                                <input type="hidden" name="status_pengajar" value="Pengajar Bantu" />
                            </form>
                            <button class="btn btn-block btn-warning btn-lg mb-2" id="pengajar_bantu"
                                data-idku="{{ $pertemuan->id }}"
                                onclick="return confirm('<?php echo $dataLogin->nama; ?>, Apakah yakin ingin melakukan absen sebagai pengajar bantu?')">
                                <i class="fas fa-clipboard-check"></i>
                                Absen
                            </button>
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
            let id;

            $(".btn-detail").on("click", function() {
                id = $(this).data("id");

                $.ajax({
                    type: "GET",
                    url: `{{ url('/detail/Absen/${id}/json') }}`,
                    dataType: "json",
                    success: function(response) {
                        $("#getpengajar").text(response.absen.pengajar);

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

            $("#pengajar_bantu").on("click", function() {
                let formdata = $("#absen_pengajar_bantu").serialize();
                formdata += "&_token=" + $('meta[name="csrf-token"]').attr("content");
                formdata += "&idpembelajaran=" + id;

                $.ajax({
                    type: "POST",
                    url: `{{ url('/pengajar/bantu/absen/${id}') }}`,
                    data: formdata,
                    dataType: "json",
                    success: function(response) {
                        Swal.fire("Berhasil!", response.message, "success");
                        $("#detailmodal").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Terjadi kesalahan", "error");
                    }
                });
            });
        });
    </script>
@endsection
