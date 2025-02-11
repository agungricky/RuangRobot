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
                            <div class="container mt-3">
                                <input type="text" id="search" class="form-control mb-3" placeholder="Cari kelas...">
                                <div class="row" id="kelas-container">
                                </div>
                            </div>
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
                                        <a href="" class="text-decoration-none">
                                            <div class="hero text-white hero-bg-image"
                                                style="background-image: url('{{ $kls->banner != '' ? url('/banner/' . $kls->banner) : url('/img_videogaming.jpg') }}');padding:20px;">
                                                <div class="hero-inner">
                                                    <h5
                                                        style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                        {{ ucwords($kls->nama_kelas) }}</h5>
                                                    @php
                                                        $colors = [
                                                            'primary',
                                                            'secondary',
                                                            'success',
                                                            'danger',
                                                            'warning',
                                                            'info',
                                                            'dark',
                                                        ];
                                                        $randomColor = $colors[array_rand($colors)];
                                                    @endphp

                                                    <span class="badge badge-{{ $randomColor }}">
                                                        {{ $kls->kategori_kelas->kategori_kelas }}
                                                    </span>

                                                    {{-- @if ($kls->kategori_kelas->kategori_kelas == 'Kelas Ekskul')
                                                        <span
                                                            class="badge badge-danger">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                    @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Lomba')
                                                        <span
                                                            class="badge badge-primary">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                    @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Project')
                                                        <span
                                                            class="badge badge-warning text-dark">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                    @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Reguler')
                                                        <span
                                                            class="badge badge-info">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                    @elseif ($kls->kategori_kelas->kategori_kelas == 'Kelas Trial')
                                                        <span
                                                            class="badge badge-info">{{ $kls->kategori_kelas->kategori_kelas }}</span>
                                                    @endif --}}
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

    <script>
        $(document).ready(function() {
            function loadKelas(searchTerm = '') {
                $.ajax({
                    url: "{{ route('kelas_pengajar') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        let kelasHtml = "";
                        let data = response.data || [];

                        if (searchTerm) {
                            data = data.filter(item => item.nama_kelas.toLowerCase().includes(searchTerm
                                .toLowerCase()));
                        }

                        if (data.length === 0) {
                            kelasHtml =
                                "<p class='text-center text-muted'>Tidak ada kelas ditemukan.</p>";
                        } else {
                            data.forEach(item => {
                                let badgeColor = getBadgeColor(item.kategori);
                                let randomColors = ['primary', 'success', 'danger',
                                    'warning',
                                ];
                                let randomColor = randomColors[Math.floor(Math.random() *
                                    randomColors.length)];

                                kelasHtml += `
                                    <div class="col-md-4 mb-4">
                                        <a href="#" class="text-decoration-none">
                                            <div class="hero text-white hero-bg-image" 
                                                style="background-image: url('{{ asset('img_videogaming.jpg') }}'); padding: 20px;">
                                                <div class="hero-inner">
                                                    <h5 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        ${item.nama_kelas}
                                                    </h5>
                                                    <span class="badge badge-${randomColor}">
                                                        ${item.kategori}
                                                    </span>
                                                    <p class="lead">${item.program_belajar || "Program tidak tersedia"}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                `;
                            });

                        }

                        $("#kelas-container").html(kelasHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        $("#kelas-container").html(
                            "<p class='text-danger'>Gagal mengambil data kelas.</p>");
                    }
                });
            }

            // Warna badge sesuai kategori
            function getBadgeColor(kategori) {
                const colors = {
                    "Trial": "warning",
                    "Reguler": "danger",
                    "Project": "primary"
                };
                return colors[kategori] || "secondary"; // Default: abu-abu
            }

            // Panggil data pertama kali
            loadKelas();

            // Fitur pencarian
            $("#search").on("input", function() {
                let searchTerm = $(this).val();
                loadKelas(searchTerm);
            });
        });
    </script>
@endsection
