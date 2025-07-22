@extends('main.layout')
@section('content')
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Daftar Kelas Saya" />
            <div class="section-body">
                <div class="card author-box card-primary">
                    <div class="card-body p-3">
                        <h2 class="section-title mb-3">Sedang Berlangsung</h2>
                        <div id="kelas-container" style="display: none;">
                            <div class="row" id="kelas-aktif"></div>
                        </div>

                        <h2 class="section-title my-3 p-0">
                            <span id="toggle-kelas-selesai" style="cursor: pointer;">
                                Kelas Selesai (<span id="total-kelas">0</span>)
                            </span>
                        </h2>
                        <div id="kelas-selesai-container" style="display: none;">
                            <div class="row" id="kelas-selesai-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            let id = "{{ $id }}";

            function loadKelas() {
                $.ajax({
                    url: "{{ url('/kelas/saya/' . $id) }}", 
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        let kelasHtml = "";
                        let data = response.kelas || [];

                        if (data.length === 0) {
                            kelasHtml =
                                "<p class='text-center text-muted'>Tidak ada kelas ditemukan.</p>";
                        } else {
                            data.forEach(item => {
                                let hex = item.kelas.kategori.color_bg;

                                // Ambil komponen RGB
                                let r = parseInt(hex.substr(1, 2), 16);
                                let g = parseInt(hex.substr(3, 2), 16);
                                let b = parseInt(hex.substr(5, 2), 16);

                                // Buat warna RGBA
                                let rgba = `rgba(${r}, ${g}, ${b}, 1)`;
                                let rgbb = `rgba(${r}, ${g}, ${b}, 0.4)`;

                                kelasHtml += `
                                    <div class="col-md-4 mb-4">
                                        <a href="{{ url('/detail/kelas/${item.kelas_id}/siswa') }}" class="text-decoration-none">
                                            <div class="hero text-white hero-bg-image h-100" 
                                                style="background-image: url({{ asset('img_videogaming1.png') }});
                                                        background-color: ${rgba};
                                                        padding:35px";>
                                                <div class="hero-inner">
                                                    <h6 class="text-wrap w-100">
                                                        ${item.kelas.nama_kelas}
                                                    </h6>
                                                    <span class="badge text-light" style="width: 100px; background-color: blue;">
                                                        ${item.kelas.status_kelas}
                                                    </span>
                                                    <span class="badge text-light" style="width: 100px; background-color: red;">
                                                        ${item.kelas.kategori.kategori_kelas}
                                                    </span> </br>
                                                    <span class="d-block mt-2">
                                                        ${item.kelas.status_kelas !== "selesai" ? `Jam Pembelajaran: ${item.kelas.durasi_belajar}` : `Status: Kelas Telah Selesai`} 
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                `;
                            });
                        }

                        $("#kelas-aktif").html(kelasHtml);
                        $("#kelas-container").slideDown();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        $("#kelas-aktif").html(
                            "<p class='text-danger'>Gagal mengambil data kelas.</p>");
                    }
                });
            }

            function loadKelasSelesai() {
                $.ajax({
                    url: "{{ url('/kelas/saya/' . $id) }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response); // Cek apakah data sudah diterima

                        let kelasHtml = "";
                        let data = response.kelas_selesai || [];

                        $("#total-kelas").text(data.length); // Set jumlah total kelas selesai

                        if (data.length === 0) {
                            kelasHtml =
                                "<p class='text-center text-muted'>Tidak ada kelas selesai.</p>";
                        } else {
                            data.forEach(item => {
                                let hex = item.kelas.kategori.color_bg;

                                // Ambil komponen RGB
                                let r = parseInt(hex.substr(1, 2), 16);
                                let g = parseInt(hex.substr(3, 2), 16);
                                let b = parseInt(hex.substr(5, 2), 16);

                                // Buat warna RGBA
                                let rgba = `rgba(${r}, ${g}, ${b}, 1)`;
                                let rgbb = `rgba(${r}, ${g}, ${b}, 0.4)`;
                                kelasHtml += `
                                    <div class="col-md-4 mb-4">
                                        <a href="{{ url('/detail/kelas/${item.kelas_id}/siswa') }}" class="text-decoration-none">
                                            <div class="hero text-white hero-bg-image h-100" 
                                                style="background-image: url({{ asset('img_videogaming1.png') }});
                                                        background-color: ${rgba};
                                                        padding:35px";>
                                                <div class="hero-inner">
                                                    <h6 class="text-wrap w-100">
                                                        ${item.kelas.nama_kelas}
                                                    </h6>
                                                    <span class="badge text-light" style="width: 100px; background-color: blue;">
                                                        ${item.kelas.status_kelas}
                                                    </span>
                                                    <span class="badge text-light" style="width: 100px; background-color: red;">
                                                        ${item.kelas.kategori.kategori_kelas}
                                                    </span> </br>
                                                    <span class="d-block mt-2">
                                                        ${item.kelas.status_kelas !== "selesai" ? `Jam Pembelajaran: ${item.kelas.durasi_belajar}` : `Kelas Telah Selesai`} 
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                `;
                            });
                        }

                        $("#kelas-selesai-list").html(kelasHtml);
                    },

                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        $("#kelas-selesai-list").html(
                            "<p class='text-danger'>Gagal mengambil data kelas selesai.</p>");
                    }
                });
            }

            $("#toggle-kelas-selesai").click(function() {
                let container = $("#kelas-selesai-container");
                if (container.is(":visible")) {
                    container.slideUp();
                } else {
                    loadKelasSelesai();
                    container.slideDown();
                }
            });


            loadKelas();
            loadKelasSelesai();
        });
    </script>
@endsection
