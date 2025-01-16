@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Update Program Belajar" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('program_belajar.update',['id'=>$data->id])}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="nama_program" label="Nama Program"
                                                    :value="$data->nama_program" />
                                                <x-validation_form.error name="nama_program" />
                                            </div>
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="harga" label="Harga"
                                                    :value="$data->harga" />
                                                <x-validation_form.error name="harga" />
                                            </div>
                                            <div class="col-12">
                                                <x-form_edit.edit_text name="deskripsi" label="Deskripsi"
                                                    :value="$data->deskripsi" />
                                                <x-validation_form.error name="deskripsi" />
                                            </div>
                                            <div class="col-6">
                                                <label for="">Level</label>
                                                <select class="form-control" name="level">
                                                    @foreach ($level as $value)
                                                    <option value="{{ $value->level }}">{{ $value->level }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-6">
                                                <label for="">Jenis Kelas</label>
                                                <select class="form-control" name="jenis_kelas_id">
                                                    @foreach ($options as $value)
                                                    <option value="{{ $value->id }}">{{ $value->jenis_kelas}}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="mekanik" label="mekanik"
                                                    :value="$data->mekanik" />
                                                <x-validation_form.error name="mekanik" />
                                            </div>
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="elektronik" label="elektronik"
                                                    :value="$data->elektronik" />
                                                <x-validation_form.error name="elektronik" />
                                            </div>
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="pemrograman" label="pemrograman"
                                                    :value="$data->pemrograman" />
                                                <x-validation_form.error name="pemrograman" />
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
