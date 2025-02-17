@extends('main.layout')
@section('content')
@if (session('success'))
        <x-sweetalert.success />
    @endif
<div class="main-content">
    <section class="section">
        <x-title_halaman title="Profil Saya" />
        <div class="row mt-sm-4">

            <!-- Profil Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <img src="{{ url('assets/img/avatar/avatar-1.png') }}" alt="Profile Picture"
                            class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <h5 class="card-title">{{ $data->nama }}</h5>
                        <p class="text-muted">{{$data->role}}</p>
                        <button type="button" class="btn btn-outline-primary btn-sm disabled" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-pencil-alt"></i> Ganti Foto
                        </button>
                        <hr class="my-3 p-0">
                        <p><i class="fas fa-envelope"></i> {{ $data->email }}</p>
                        <hr class="my-3 p-0">
                        <p><i class="fas fa-map-marker-alt"></i> {{ $data->alamat }}</p>
                        <hr class="my-3 p-0">
                        <p><i class="fas fa-phone"></i> {{ $data->no_telp }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Edit Profil -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('update_profile', ['id' => $data->id]) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
                                <div class="invalid-feedback">Nama harus diisi</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}" required>
                                <div class="invalid-feedback">Alamat harus diisi</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="no_telp" class="form-control" value="{{ $data->no_telp }}" required>
                                <div class="invalid-feedback">Nomor Telepon harus diisi</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection


@push('scripts')
    @if (\Session::has('success'))
        <script>
            $(function() {
                swal.fire({
                    icon: 'success',
                    title: "Profil Berhasil Diubah",
                    timer: 1000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
@endpush
