@extends('main.layout')
@section('content')
<div class="main-content">
    <section class="section">
        <x-title_halaman title="Profil Saya" />
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img style="width: 100px;height: 100px;object-fit: cover;" alt="image"
                            src="{{  url('assets/img/avatar/avatar-1.png') }}"
                            class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <button type="button" class="btn btn-primary btn-sm m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-pencil-alt"></i> Ganti Foto Profil
                            </button>
                            
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">{{ $data->nama }} <div
                                class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> Pengajar
                            </div>
                        </div>
                        <p><i class="fas fa-user-lock"></i> {{ $data->email}}</p>
                        <p><i class="fas fa-map-marker"></i> {{ $data->alamat }}</p>
                        <p><i class="fas fa-phone"></i> {{ $data->no_telp }}</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                    <form class="needs-validation" novalidate="" action="{{ route('update_profile',['id' => $data->id])}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-5 col-12">
                                    <label>Nama</label>
                                    <input name="nama" type="text" class="form-control"
                                        value="{{ $data->nama }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>

                                <div class="form-group col-md-7 col-12">
                                    <label>Alamat</label>
                                    <input name="alamat" type="text" class="form-control" value="{{ $data->alamat }}"
                                        required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5 col-12">
                                    <label>Nomor Telpon</label>
                                    <input name="no_telp" type="text" class="form-control" value="{{ $data->no_telp }}"
                                        required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                                <div class="form-group col-md-7 col-12">
                                    <label>Password (kosongkan jika tidak ingin merubah password)</label>
                                    <input type="password" class="form-control" name="password">
                                    <div class="invalid-feedback">
                                        Please fill in the username
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Foto Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <label class="btn btn-primary">
                            Pilih Gambar... <input type="file" accept="image/*" style="display: none;"
                                name="profil_pict">
                        </label>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
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