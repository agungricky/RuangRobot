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
                                <form action="{{route('pengguna.update', ['id' => $data->id, 'role' => $role]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="nama" label="Nama"
                                                    :value="$data->nama" />
                                                <x-validation_form.error name="nama_program" />
                                            </div>
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="email" label="Email"
                                                    :value="$data->email" />
                                                <x-validation_form.error name="email" />
                                            </div>
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="alamat" label="Alamat"
                                                    :value="$data->alamat" />
                                                <x-validation_form.error name="alamat" />
                                            </div>
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="no_telp" label="No Telp"
                                                    :value="$data->no_telp" />
                                                <x-validation_form.error name="no_telp" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
