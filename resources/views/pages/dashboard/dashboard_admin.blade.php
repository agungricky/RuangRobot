@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Dashboard Admin" />

            <div class="section-body">
                <div class="row">
                    <x-card_dashboard style="card-icon bg-success" icon="fas fa-users" titlecard="Siswa"
                        value="{{ $total['siswa'] }}" />
                    <x-card_dashboard style="card-icon bg-primary" icon="far fa-user" titlecard="Pengajar"
                        value="{{ $total['pengajar'] }}" />
                    <x-card_dashboard style="card-icon bg-danger" icon="far fa-newspaper" titlecard="Kelas"
                        value="{{ $total['kelas'] }}" />
                    <x-card_dashboard style="card-icon bg-warning" icon="fas fa-money-bill-alt" titlecard="Income"
                        value="0" />
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pembayaran Terbaru</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('pembayaran_terbaru') }}" class="btn btn-danger">Selengkapnya <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="card-body ps-3">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="wrapper wrapper-content animated fadeInRight">

                                                @foreach ($pembayaran_terbaru as $item)
                                                    <div class="faq-item">
                                                        <div class="row mb-2">
                                                            <div class="col-md-7">
                                                                <a data-toggle="collapse" href=""
                                                                    class="faq-question">{{ $item->kelas->nama_kelas }}</a>
                                                                <br>
                                                                <small>
                                                                    Added by <strong>{{ $item->pengguna->nama }}</strong>
                                                                    <i class="fa fa-clock-o"></i>
                                                                    Tanggal
                                                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                                                </small>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <span class="small font-bold">Perihal</span>
                                                                <div class="tag-list">
                                                                    <span
                                                                        class="tag-item">{{ $item->jenis_pembayaran }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-right">
                                                                <span class="small font-bold">Nominal </span><br>
                                                                Rp. {{ number_format($item->nominal, 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Laporan Keuangan</h4>
                            </div>
                            <div class="card-body">
                                <div id="content" class="container">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <h6 class="nomargin">
                                                    Terdapat {{ $indexKeuangan_count }} Laporan Keuangan <br>
                                                    <small class="text-success">(1 Sedang Berlangsung)</small>
                                                </h6>

                                                <h6 class="nomargin mb-0">
                                                    Total Saldo Saat ini: <br>
                                                    <span class="fs-3">
                                                        Rp.
                                                        {{ $total_saldo->saldo_akhir ? number_format($total_saldo->saldo_akhir, 0, ',', '.') : 0 }}
                                                    </span>
                                                </h6>

                                            </div>

                                            <hr class="nomargin-bottom margin-top-10">

                                            <div class="clearfix search-result">
                                                <span class="fs-6"><a href="{{ route('sedang_berlangsung') }}">Sedang
                                                        Berlangsung</a></span> <br>
                                                <small class="text-success">Belum dapat disimpulkan</small>
                                            </div>
                                            <hr>

                                            {{-- @foreach ($indexKeuangan as $item)
                                                <div class="clearfix search-result">
                                                    <span class="fs-6">
                                                        <a href="#">
                                                            Periode
                                                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}
                                                            s/d
                                                            {{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->translatedFormat('d F Y') }}
                                                        </a>
                                                    </span> <br>
                                                    @if ($item->kesimpulan == 'Pemasukan')
                                                        <small class="text-success">{{ $item->kesimpulan }}</small>
                                                        <p>Pada periode ini Ruang Robot lebih banyak Pemasukan</p>
                                                    @else
                                                        <small class="text-danger">{{ $item->kesimpulan }}</small>
                                                        <p>Pada periode ini Ruang Robot lebih banyak Pengeluaran</p>
                                                    @endif
                                                    </p>
                                                </div>
                                                <hr>
                                            @endforeach --}}

                                            <div id="keuangan-list">
                                                {{-- data akan ditampilkan oleh jQuery --}}
                                            </div>

                                            <div class="text-center mt-4">
                                                <nav>
                                                    <ul class="pagination justify-content-center" id="custom-pagination">
                                                        <li class="page-item disabled" id="prev-btn">
                                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                                        </li>
                                                        <!-- Page numbers will be injected here by JS -->
                                                        <li class="page-item" id="next-btn">
                                                            <a class="page-link" href="#">Next</a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-hero">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="far fa-question-circle"></i>
                                </div>
                                <h4>Absen Terbaru</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="tickets-list">
                                    @foreach ($absenTerbaru as $item)
                                        <div class="ticket-item">
                                            <div class="ticket-title">
                                                <h4 class="text-primary">{{ $item->kelas->nama_kelas }}</h4>
                                            </div>
                                            <div class="ticket-info">
                                                <div>{{ $item->nama }}</div>
                                                <div class="bullet"></div>
                                                <div>
                                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d,m,Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .page-item.active .page-link {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
    </style>

    <script>
        $(document).ready(function() {
            let data = @json($indexKeuangan); // Ambil semua data dari controller
            let perPage = 12;
            let currentPage = 1;
            let totalPages = Math.ceil(data.length / perPage);

            function renderPage(page) {
                $('#keuangan-list').empty();
                let start = (page - 1) * perPage;
                let end = start + perPage;
                let paginatedItems = data.slice(start, end);

                paginatedItems.forEach(function(item) {
                    console.log(item)
                    $('#keuangan-list').append(`
                    <div class="clearfix search-result">
                    <span class="fs-6">
                        <a href="/riwayat_periode/${item.id}">Periode ${formatTanggal(item.created_at)} s/d ${formatTanggal(item.updated_at)}</a>
                    </span><br>
                    ${item.kesimpulan === 'Pemasukan' ? `
                                            <small class="text-success">${item.kesimpulan}</small>
                                            <p>Pada periode ini Ruang Robot lebih banyak Pemasukan</p>
                                        ` : `
                                            <small class="text-danger">${item.kesimpulan}</small>
                                            <p>Pada periode ini Ruang Robot lebih banyak Pengeluaran</p>
                                        `}
                        </div>
                        <hr>
                    `);
                });

                updatePagination(page);
            }

            function updatePagination(page) {
                let pagination = $('#custom-pagination');
                pagination.find('.page-number').remove(); // hapus halaman sebelumnya

                // Tambah nomor halaman
                for (let i = 1; i <= totalPages; i++) {
                    let activeClass = (i === page) ? 'active' : '';
                    $(`<li class="page-item page-number ${activeClass}">
                <a class="page-link" href="#">${i}</a>
            </li>`).insertBefore('#next-btn');
                }

                // Atur tombol prev/next aktif/nonaktif
                $('#prev-btn').toggleClass('disabled', page === 1);
                $('#next-btn').toggleClass('disabled', page === totalPages);

                // Perbarui currentPage
                currentPage = page;
            }

            function formatTanggal(tanggal) {
                let date = new Date(tanggal);
                let options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                return date.toLocaleDateString('id-ID', options);
            }

            // Event: klik nomor halaman
            $(document).on('click', '.page-number', function(e) {
                e.preventDefault();
                let page = parseInt($(this).text());
                renderPage(page);
            });

            // Event: tombol prev
            $('#prev-btn').click(function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    renderPage(currentPage - 1);
                }
            });

            // Event: tombol next
            $('#next-btn').click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    renderPage(currentPage + 1);
                }
            });

            renderPage(currentPage);
        });
    </script>
@endsection
