@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Edit Pengguna" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('pengguna.update', ['id' => $data->id, 'role' => $role]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="field">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="username">UserName</label>
                                                <input type="text" class="form-control" id="username"
                                                    placeholder="Masukan Username" name="username"
                                                    value="{{ old('username', $data->akun->username) }}">
                                                @error('username')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-4">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control" id="password" name="password"
                                                    placeholder="Kosongkan jika tidak ingin merubah">
                                                @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <input type="hidden" name="role" value="{{ $role }}">

                                            @if ($role == 'Admin' || $role == 'Pengajar')
                                                <div class="col-4">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Masukan email"
                                                        value="{{ old('email', $data->email) }}">
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if ($role == 'Siswa')
                                                <div class="col-4">
                                                    <label for="sekolah_id">Sekolah</label> <br>
                                                    <select name="sekolah_id" class="form-control select2">
                                                        @foreach ($sekolah as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('sekolah_id', $data->sekolah_id ?? '') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->nama_sekolah }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sekolah_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif

                                            <div class="col-8 mt-3">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" name="nama" id="nama"
                                                    placeholder="Masukan nama" value="{{ old('nama', $data->nama) }}">
                                                @error('nama')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-4 mt-3">
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                                    placeholder="Masukan Tanggal Lahir"
                                                    value="{{ old('tgl_lahir', $data->tgl_lahir) }}">
                                                @error('tgl_lahir')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            @if ($role == 'Siswa')
                                                <div class="col-8 mt-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="Masukan email"
                                                        value="{{ old('email', $data->email) }}">
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-4 mt-3">
                                                    <label for="kelas">Kelas</label>
                                                    <input type="text" class="form-control" name="kelas" id="kelas"
                                                        placeholder="Masukan kelas di sekolah"
                                                        value="{{ old('kelas', $data->kelas) }}">
                                                    @error('kelas')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif

                                            <div class="col-8 mt-3">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" name="alamat" id="alamat"
                                                    placeholder="Masukan alamat"
                                                    value="{{ old('alamat', $data->alamat) }}">
                                                @error('alamat')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-4 mt-3">
                                                <label for="no_telp">No HP</label>
                                                <input type="text" class="form-control" name="no_telp" id="no_telp"
                                                    placeholder="Masukan nomor hp"
                                                    value="{{ old('no_telp', $data->no_telp) }}">
                                                @error('no_telp')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <input type="hidden" name="mekanik"
                                                value="{{ old('mekanik', $data->mekanik) }}">
                                            <input type="hidden" name="elektronik"
                                                value="{{ old('elektronik', $data->elektronik) }}">
                                            <input type="hidden" name="pemrograman"
                                                value="{{ old('pemrograman', $data->pemrograman) }}">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih Sekolah --",
                allowClear: true
            });
        });
    </script>

@endsection
