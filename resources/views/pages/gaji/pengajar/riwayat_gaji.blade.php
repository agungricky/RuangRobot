@extends('main.layout')
@section('content')
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Riwayat Gaji" />

            <div class="container mt-4">
                <h4 class="mb-4 mt-5">📅 Tanggal Gajian</h4>
                <div class="list-group">
                    @foreach ($data as $list_gajian)
                        <div class="list-group-ite py-3 border-top border-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-3 text-primary fs-5"></i>
                                <div>
                                    <h6 class="mb-1">
                                        {{ \Carbon\Carbon::parse($list_gajian->tanggal_terbayar)->translatedFormat('l, d F Y') }}
                                    </h6>
                                    <small class="text-muted">Status: <span class="text-success">✅ Terbayar</span></small>
                                </div>
                            </div>
                            <!-- Button Selengkapnya di bawah status -->
                            <div class="mt-2">
                                <a href="{{ route('detail.riwayat.histori', ['id'=> $dataLogin->id, 'idtanggal'=>$list_gajian->id]) }}"
                                    class="text-primary">
                                    Selengkapnya
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
