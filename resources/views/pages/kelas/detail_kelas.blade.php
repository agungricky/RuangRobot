@extends('main.layout')
@section('content')
    <a href="" class="btn btn-primary btn-lg mb-4">
        <i class="fa fa-arrow-left"></i> Kembali</a>

    <div class="row">
        <div class="col">
            <div class="hero text-white hero-bg-image"
                style="background-image: url('{{ $kelas->banner != '' ? url('/banner/' . $kelas->banner) : url('/img_videogaming.jpg') }}');padding:35px;">
                <div class="hero-inner">
                    <h5>{{ ucwords($kelas->nama_kelas) }}</h5>
                    @if ($kelas->jenis_kelas == 'Kelas Privat')
                        <span class="badge badge-danger">{{ $kelas->jenis_kelas }}</span>
                    @elseif ($kelas->jenis_kelas == 'Kelas Regular')
                        <span class="badge badge-primary">{{ $kelas->jenis_kelas }}</span>
                    @elseif ($kelas->jenis_kelas == 'Kelas Ekskul')
                        <span class="badge badge-warning text-dark">{{ $kelas->jenis_kelas }}</span>
                    @elseif ($kelas->jenis_kelas == 'Kelas Lomba')
                        <span class="badge badge-info">{{ $kelas->jenis_kelas }}</span>
                    @elseif ($kelas->jenis_kelas == 'Kelas Online')
                        <span class="badge badge-success">{{ $kelas->jenis_kelas }}</span>
                    @elseif ($kelas->jenis_kelas == 'Kelas Mandiri')
                        <span class="badge text-light" style="background:#9b59b6;">{{ $kelas->jenis_kelas }}</span>
                    @endif
                    <p class="lead">{{ $kelas->program_belajar->nama_program_belajar }}</p>
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
                                <h4><i class="fas fa-play-circle mr-3"></i> {{ $slot_kelas->count() }} Pertemuan</h4>
                            </div>
                        </a>
                        <a href="{{ route('profileall', ['pengajar', $kelas->pengajar->id]) }}" class="ticket-item">
                            <div class="ticket-title">
                                <h4><i class="	fas fa-chalkboard-teacher mr-3"></i> {{ $kelas->pengajar->nama_pengajar }}
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
                                <li>Mekanik : <span style="font-weight:bold"
                                        class="text-info">+{{ $kelas->program_belajar->mekanik }}</span></li>
                                <li>Elektronik : <span style="font-weight:bold"
                                        class="text-success">+{{ $kelas->program_belajar->elektronik }}</span></li>
                                <li>Pemrograman : <span style="font-weight:bold"
                                        class="text-danger">+{{ $kelas->program_belajar->pemrograman }}</span></li>
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
                @foreach ($slot_kelas as $pertemuan)
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

                    {{-- @if (Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pertemuan->tanggal)), $pertemuan->materi) == 'Silahkan Absen Sekarang') --}}

                    @if (Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pertemuan->tanggal)), $pertemuan->materi) == 'Sudah Absen' ||
                            Ceksiswa::isdate_terlewat(date('d-m-Y', strtotime($pertemuan->tanggal)), $pertemuan->materi) ==
                                'Sudah Absen hi')
                        <div class="activity">
                            <div class="activity-icon bg-success text-light shadow-primary">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-detail w-100">
                                <div class="mb-2">
                                    <span class="text-job text-success">{{ $daftar_hari[$namahari] }},
                                        {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }} /
                                        {{ $pertemuan->jamm . ' - ' . $pertemuan->jams }}</span>
                                    <span class="bullet"></span>
                                    <button
                                        style="border: 0px;border-radius: 5px;background: #6777ef;color: #fff;padding: 3px 10px;"
                                        class="text-job"
                                        onclick="detailkelas({{ $pertemuan->id }},'{{ $pertemuan->materi }}','{{ $daftar_hari[$namahari] }}, {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }}')">Detail</button>
                                </div>
                                <p class="mb-2" style="font-size: 15px;">
                                    {{ $pertemuan->materi != '' ? $pertemuan->materi : '-' }}</p>
                                {{-- <hr> --}}
                                <span class="font-weight-bold text-small"># Pertemuan Ke {{ $no++ }}</span>
                                {{-- <br><br> --}}
                                {{-- <a class="btn btn-primary btn-sm detailbutton btn-block" href="javascript:void(0)" data-materi="{{$pertemuan->materi}}" data-hari="{{ $daftar_hari[$namahari] }}" data-id="{{ $pertemuan->id }}" data-tanggal="{{ date('d-m-Y',strtotime($pertemuan->tanggal)) }}"><i class="fas fa-clipboard-check"></i> Detail</a> --}}
                                {{-- <button class="btn btn-primary btn-block"><i class="fas fa-clipboard-check"></i> Detail</button> --}}
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
                                {{-- <a data-id="{{ $pertemuan->id }}" data-uuid="{{ $pertemuan->id_kelas }}" href="javascript:void(0)" class="mt-3 btn btn-success tambahsiswakelas btn-block"><i class="fas fa-clipboard-check"></i> Absen</a> --}}
                            </div>
                        </div>
                        {{-- <div class="activity w-100">
                            <div class="activity-icon bg-warning text-dark shadow-primary">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="activity-detail w-100">
                                <div class="mb-2">
                                    <span class="text-job text-warning">{{ $daftar_hari[$namahari] }},
                                        {{ date('d-m-Y', strtotime($pertemuan->tanggal)) }} /
                                        {{ $pertemuan->jamm . ' - ' . $pertemuan->jams }}</span>
                                </div>
                                <span class="font-weight-bold text-small"># Pertemuan Ke {{ $no++ }}</span>
                            </div>
                        </div> --}}
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <h2 class="section-title">Daftar Siswa</h2>
    <div class="row">
        @foreach ($siswa as $siswas)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-primary"><a
                                href="{{ route('profileall', ['siswa', $siswas->id]) }}">{{ $siswas->nama_siswa }}</a>
                        </h6>
                        <hr>
                        <p class="text-small"><i class="fa fa-school mr-2"></i> {{ $siswas->sekolah }}</p>
                        <p class="text-small"><i class="fa fa-signal mr-2"></i> Presentase Kehadiran</p>
                        <div class="budget-price">
                            <div class="budget-price-square bg-{{ str_replace('%', '', Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count())) <= 50 ? 'danger' : 'primary' }}"
                                data-width="{{ Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count()) }}"
                                style="width: {{ Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count()) }};">
                            </div>
                            <div class="budget-price-label">
                                {{ Ceksiswa::cek_percentage($siswas->id, $slot_kelas->first()->id_kelas, $slot_kelas->count()) }}
                            </div>
                        </div>
                        <hr>
                        @if (Ceksiswa::get_status($siswas->id, $id) == 'false')
                            <button data-id="{{ $siswas->id }}" data-nama="{{ $siswas->nama_siswa }}"
                                data-idgen="{{ $id }}" onclick="selesaikankelas(this)"
                                class="btn btn-block btn-success"><i class="fas fa-check"></i> Selesaikan</button>
                            {{-- <a href="#" onclick="selesaikankelas({{ $siswas->id }},{{ $siswas->nama_siswa }},{{ $id }})" class="btn btn-block btn-success selesait" data-id="{{ $siswas->id }}" data-nama="{{ $siswas->nama_siswa }}" data-kelas="{{ $id }}"><i class="fas fa-check"></i> Selesaikan</a> --}}
                        @else
                            @if (Ceksiswa::cek_score($siswas->id, $id) == 'C')
                                <p class="font-weight-bold text-danger"><i class="fas fa-times"></i> GAGAL</p>
                            @else
                                <p class="font-weight-bold text-primary"><i class="fas fa-check"></i> SKOR AKHIR :
                                    {{ Ceksiswa::cek_score($siswas->id, $id) }}</p>
                            @endif
                            <p class="text-small"><i class="fas fa-star mr-2"></i> {!! Ceksiswa::get_poin($siswas->id, $id) !!}</p>
                            <p></p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="section-title">Status Kelas</h2>
    @if ($kelas->status == '0')
        <form id="submitselesaifix" method="post" action="{{ route('pengajar.selesaikelasnyaaa') }}">
            @csrf
            <input type="hidden" name="id_kelas" value="{{ $id }}">
            <button onclick="event.preventDefault();fixselesaikelas()" class="btn btn-primary"><i
                    class="fas fa-check"></i> Selesaikan Kelas</button>
        </form>
    @else
        <h2>Kelas Telah Selesai</h2>
    @endif
@endsection

@section('modal')
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
                    <form action="{{ route('pengajar.saveabsen') }}" method="post">
                        @csrf
                        <h6>Siswa Yang Hadir :</h6>
                        @foreach ($siswa as $siswas)
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
                        @endforeach
                        <input type="hidden" name="id_kelas" value="{{ $id }}">
                        <input type="hidden" id="uuid" name="uuid" placeholder="uuid" class="form-control">
                        <input type="hidden" id="idsesi" name="idsesi" placeholder="idsesi" class="form-control">
                        <h6>Materi :</h6>
                        <input type="text" id="materi" name="materi" placeholder="Materi"
                            class="form-control mb-4" value="{{ $materi != '' ? $materi : '' }}">
                        <button type="submit" name="opsi_simpan" value="simpan_sementara" class="btn btn-primary"><i
                                class="fas fa-clipboard-check"></i> Simpan Sementara</button>
                        <button type="submit" name="opsi_simpan" value="submit_final" class="btn btn-success"><i
                                class="fas fa-clipboard-check"></i> Final Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                                {{ $kelas->pengajar->nama_pengajar }}
                            </div>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-clock"></i> Waktu Pertemuan </b>
                            <div class="profile-desc-item pull-right">
                                <span id="gettanggalnya"></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-book"></i> Materi </b>
                            <div class="profile-desc-item pull-right">
                                <b class="isimateri"></b>
                            </div>
                        </li>
                    </ul>
                    <h6 class="mt-3 mb-3">Siswa Yang Hadir :</h6>
                    <div class="inimasuksiswahadir"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .labela {
            width: 100%;
        }

        .card-input-element+.card {
            -webkit-box-shadow: none;
            box-shadow: none;
            border-left: 4px solid #f8f8f8;
            /* border-radius: 4px; */
        }

        .card-input-element+.card:hover {
            cursor: pointer;
        }

        .card-input-element:checked+.card {
            border-left: 4px solid #28a745 !important;
            -webkit-transition: border .3s;
            -o-transition: border .3s;
            transition: border .3s;
        }

        .card-input-element+.card i {
            color: #f8f8f8;
        }

        .card-input-element:checked+.card i {
            color: #28a745 !important;
        }

        @-webkit-keyframes fadeInCheckbox {
            from {
                opacity: 0;
                -webkit-transform: rotateZ(-20deg);
            }

            to {
                opacity: 1;
                -webkit-transform: rotateZ(0deg);
            }
        }

        @keyframes fadeInCheckbox {
            from {
                opacity: 0;
                transform: rotateZ(-20deg);
            }

            to {
                opacity: 1;
                transform: rotateZ(0deg);
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function fixselesaikelas(asd) {
            swal.fire({
                title: 'Apakah Anda Yakin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.value) {
                    // var form = asd.parents('form');
                    $('#submitselesaifix').submit();
                }
            });
        }

        function selesaikankelas(component) {
            // id, nama, id_kelas
            Swal.fire({
                title: 'Selesaikan ' + component.dataset.nama + '?',
                text: "Dengan Klik YA Siswa Dianggap Menyelesaikan Kelas",
                icon: 'warning',
                html: '<div class="form-group row d-flex justify-content-center align-items-center"><h4 class="col-md-12">Nilai :</h4><div class="col-md-2"><div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="poinsiswa" id="radionilai1" value="A" checked=""> A <i class="input-helper"></i></label></div></div><div class="col-md-2"><div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="poinsiswa" id="radionilai2" value="B"> B <i class="input-helper"></i></label></div></div><div class="col-md-2"><div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="poinsiswa" id="radionilai2" value="C"> GAGAL <i class="input-helper"></i></label></div></div></div>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pengajar.selesaisiswa') }}",
                        data: {
                            id_siswa: component.dataset.id,
                            id_kelas: component.dataset.idgen,
                            nilai: $('input[name=poinsiswa]:checked').val(),
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data telah diupdate',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            window.location.reload();
                        },
                        error: function(data) {
                            console.log('Error: ', data);
                        }
                    })
                }
            })
        }

        function detailkelas(id_sesi, materi, hari) {
            $('#detailmodal').modal('show');
            $('#gettanggalnya').html(hari);
            $('.isimateri').html(materi);
            $.ajax({
                url: '{{ route('pengajar.getdetailsesi') }}',
                type: 'GET',
                data: {
                    id: id_sesi,
                    id_kelas: {{ $id }}
                },
                success: function(data) {
                    $('.inimasuksiswahadir').html(data);
                }
            })
        }

        function absen(idsesi, idkelas) {
            $('#ajaxModall').modal('show');
            $('#uuid').val(idkelas);
            $('#idsesi').val(idsesi);
        }
    </script>
@endpush
