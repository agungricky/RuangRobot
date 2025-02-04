@extends('main.layout')
@section('content')

<div class="main-content">
    <section class="section">
        <x-title_halaman title="Jadwal Kelas" />

        <div class="col-md-12">
            <ul class="cbp_tmtimeline">
                @foreach ($perhari as $key => $item)
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
                        $namahari = date('l', strtotime($key));
                    @endphp
                    <li>
                        <time class="cbp_tmtime"
                            datetime="2017-10-22T12:13"><span>{{ $daftar_hari[$namahari] }}</span><span>{{ date('d-m-Y', strtotime($key)) }}</span></time>
                        <div class="cbp_tmicon bg-blush"><i class="fas fa-calendar-alt"></i></div>
                        @foreach ($item as $items)
                            <div class="cbp_tmlabel">
                                <h2><a class="font-weight-bold" href="javascript:void(0);">{{ $items->nama_kelas }}</a></h2>
                                <p class="font-weight-bold" style="margin: 0 !important">{{ $items->jamm }} -
                                    {{ $items->jams }}</p>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>

@endsection