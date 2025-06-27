@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Daftar Kelas Saya" />
            <div class="section-body">
                <div class="card author-box card-primary">
                    <div class="card-body">
                        <h2 class="section-title">On Going </h2>
                        <div class="row">
                            <div class="container mt-3">
                                <input type="text" id="search" class="form-control mb-3" placeholder="Cari kelas...">
                                <div class="row" id="kelas-container">
                                </div>
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
                    url: "{{ route('kelas_aktif.pengajar', ['id' => $id]) }}",
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
                                // let randomColors = ['primary', 'success', 'danger',
                                //     'warning',
                                // ];
                                // let randomColor = randomColors[Math.floor(Math.random() *
                                //     randomColors.length)];

                                kelasHtml += `
                                    <div class="col-md-4 mb-4">
                                        <a href="{{ url('/detail_kelas/${item.id}') }}" class="text-decoration-none">
                                            <div class="hero text-white hero-bg-image h-100" 
                                                style="background-image: url('{{ asset('img_videogaming.jpg') }}'); padding: 20px; height: 200px !important;">
                                                <div class="hero-inner">
                                                    <h5 class="text-wrap w-100">
                                                        ${item.nama_kelas}
                                                    </h5>
                                                    <span class="badge badge-success text-light">
                                                        ${item.kategori_kelas}
                                                    </span>
                                                    <span class="badge badge-secondary text-dark">
                                                        ${item.tipe_kelas}
                                                    </span>
                                                    <p class="lead">${item.nama_program || "Program tidak tersedia"}</p>
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
