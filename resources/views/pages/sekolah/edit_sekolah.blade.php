@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Update Sekolah" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('sekolah.update', ['id' => $data->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="nama_sekolah" label="Nama Sekolah"
                                                    :value="$data->nama_sekolah" />
                                                <x-validation_form.error name="nama_sekolah" />
                                            </div>
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="guru" label="Nama Guru"
                                                    :value="$data->guru" />
                                                <x-validation_form.error name="guru" />
                                            </div>
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="no_hp" label="Nomor Hp"
                                                    :value="$data->no_hp" />
                                                <x-validation_form.error name="no_hp" />
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
