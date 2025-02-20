@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Data Kelas Diikuti" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark mt-2 mb-3" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;">Nama</th>
                                                <th style="width: 35%;" class="text-start">Kelas di ikuti</th>
                                                <th style="width: 45%;" class="text-center">Pembelajaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$item->nama}}</td>
                                                    <td>{{$item->nama_kelas}}</td>
                                                    <td>{{$item->nama_program}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
