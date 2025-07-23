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
                                    <table class="table table-bordered border-dark mt-2 mb-3 align-middle" id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No.</th>
                                                <th style="width: 15%;" class="text-center">Nama</th>
                                                <th style="width: 30%;" class="text-center">Kelas di ikuti</th>
                                                <th style="width: 15%;" class="text-center">Status Kelas</th>
                                                <th style="width: 20%;" class="text-center">Program Belajar</th>
                                                <th style="width: 10%;" class="text-center">Bergabung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $item->pengguna->nama }}</td>
                                                    <td>{{ $item->kelas->nama_kelas }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $status = $item->kelas->status_kelas;
                                                            $color =
                                                                $status === 'aktif'
                                                                    ? 'success'
                                                                    : ($status === 'selesai'
                                                                        ? 'danger'
                                                                        : 'secondary');
                                                        @endphp

                                                        <span
                                                            class="badge bg-{{ $color }} px-3 py-1 rounded-pill text-white text-capitalize">
                                                            {{ $status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $item->kelas->program_belajar->nama_program }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>

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
