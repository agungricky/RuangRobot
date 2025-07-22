@extends('main.layout')
@section('content')
    @if (session('success'))
        <x-sweetalert.success />
    @endif

    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Detail gaji" />

            <div class="section-body mt-5">
                <h4 class="mb-3 text-primary">💰 Kalkulator Gaji</h4>

                <div class="card shadow-lg p-4">
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <span class="fw-bold">Gaji Mengajar</span>
                        <span class="text-success">Rp.
                            {{ number_format($gaji_pengajar['gaji_mengajar'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                        <span class="fw-bold">Gaji Transport</span>
                        <span class="text-success">Rp.
                            {{ number_format($gaji_pengajar['gaji_transport'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 pt-2">
                        <span class="fw-bold">Gaji Custom</span>
                        <span class="text-success">Rp.
                            {{ number_format($gaji_pengajar['gaji_custom'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-3 p-2 bg-warning rounded">
                        <span class="fw-bold text-dark">Total Gaji Diterima :</span>
                        <span class="fw-bold text-dark">Rp. {{ number_format($gaji_pengajar['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="alert alert-danger d-flex align-items-center p-2 mt-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <small>Gaji ini belum fix, belum diverifikasi, dan masih bersifat pending.</small>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="widget widget-reminder">
                            <div class="widget-reminder-header text-uppercase text-start fw-bold"
                                style="letter-spacing: 6px;">
                                #GAJI MENGAJAR
                            </div>
                            @foreach ($gaji as $item)
                                <div class="widget-reminder-container">
                                    <div class="widget-reminder-time pt-4 pt-md-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                    </div>
                                    <div class="widget-reminder-divider bg-secondary"></div>
                                    <div class="widget-reminder-content">
                                        <h4 class="widget-title">
                                            <i class="fa fa-map-pin"></i> {{ $item->pembelajaran->kelas->nama_kelas }}
                                        </h4>
                                        <div class="widget-desc">
                                            <i class="fa fa-user me-1 text-muted"></i> {{ $item->pengguna->nama }} |
                                            {{ $item->status_pengajar }}
                                        </div>
                                        <div class="widget-desc">
                                            <i class="fa fa-money me-1 text-muted"></i> Rp.
                                            {{ number_format($item->nominal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="widget widget-reminder">
                            <div class="widget-reminder-header text-uppercase text-start fw-bold"
                                style="letter-spacing: 6px;">
                                #GAJI TRANSPORT
                            </div>
                            @foreach ($transport as $item)
                                <div class="widget-reminder-container">
                                    <div class="widget-reminder-time pt-4 pt-md-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                    </div>
                                    <div class="widget-reminder-divider bg-secondary"></div>
                                    <div class="widget-reminder-content">
                                        <h4 class="widget-title">
                                            <i class="fa fa-map-pin"></i> {{ $item->pembelajaran->kelas->nama_kelas }}
                                        </h4>
                                        <div class="widget-desc">
                                            <i class="fa fa-user me-1 text-muted"></i> {{ $item->pengguna->nama }} |
                                            {{ $item->status_pengajar }}
                                        </div>
                                        <div class="widget-desc">
                                            <i class="fa fa-money me-1 text-muted"></i> Rp.
                                            {{ number_format($item->nominal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($custom->count() > 0)
                        <div class="col-12 col-md-6">
                            <div class="widget widget-reminder">
                                <div class="widget-reminder-header text-uppercase text-start fw-bold"
                                    style="letter-spacing: 6px;">
                                    #GAJI CUSTOM
                                </div>
                                @foreach ($custom as $item)
                                    <div class="widget-reminder-container">
                                        <div class="widget-reminder-time pt-4 pt-md-3">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}
                                        </div>
                                        <div class="widget-reminder-divider bg-secondary"></div>
                                        <div class="widget-reminder-content">
                                            <h4 class="widget-title">
                                                <i class="fa fa-map-pin"></i> {{ $item->keterangan }}
                                            </h4>
                                            <div class="widget-desc">
                                                <i class="fa fa-user me-1 text-muted"></i> {{ $item->pengguna->nama }}
                                            </div>
                                            <div class="widget-desc">
                                                <i class="fa fa-money me-1 text-muted"></i> Rp.
                                                {{ number_format($item->nominal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </section>
    </div>

    <style>
        .widget {
            background: #fff;
            margin-bottom: .75rem;
            display: block;
            position: relative;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .widget .widget-header,
        .widget-reminder-content,
        .widget-reminder-time,
        a.widget-header-title {
            padding: 0.625rem;
        }

        .widget-chat-message:after,
        .widget-chat-message:before,
        .widget-reminder-container:after,
        .widget-reminder-container:before {
            display: table;
            content: "";
            clear: both;
        }

        .widget-footer.with-border,
        .widget-reminder-container+.widget-reminder-container {
            border-top: 1px solid #efeff4;
        }

        .widget-footer.with-bg,
        .widget-header.with-bg {
            background: #efeff4;
        }

        .widget-header.with-border {
            border-bottom: 1px solid #efeff4;
        }

        .widget-reminder-header {
            background: #efeff4;
            padding: 0.625rem;
            font-size: 0.625rem;
            font-weight: 700;
            color: #8a8a8f;
        }

        .widget-reminder-container {
            position: relative;
        }

        .inverse-mode .widget-reminder-container+.widget-reminder-container {
            border-color: #333;
        }

        .inverse-mode .widget-reminder-header {
            background: #212121;
        }

        .widget-reminder-time {
            width: 5rem;
            float: left;
            text-align: right;
            font-size: 0.625rem;
        }

        .widget-reminder-divider {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 5rem;
            width: 0.125rem;
            background: #efeff4;
        }

        .widget-reminder-content {
            margin-left: 5.125rem;
        }

        .widget-header-title {
            margin: 0;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .widget .widget-title,
        .widget .widget-title a {
            font-size: .75rem;
            color: #000;
            line-height: 1rem;
        }

        .widget .widget-title {
            font-weight: 600;
            margin: 0;
        }

        .widget-desc,
        .widget-desc a {
            font-size: .6875rem;
            line-height: 1rem;
            color: #8A8A8F;
            font-weight: 500;
        }

        .img-circle {
            border-radius: 50%;
        }

        .pull-left {
            float: left !important;
        }

        .pull-right {
            float: right !important;
        }

        .m-t-15 {
            margin-top: 15px !important;
        }

        .m-r-5 {
            margin-right: 5px !important;
        }

        .widget .widget-header,
        .widget-reminder-content,
        .widget-reminder-time,
        a.widget-header-title {
            padding: .625rem;
        }
    </style>
@endsection
