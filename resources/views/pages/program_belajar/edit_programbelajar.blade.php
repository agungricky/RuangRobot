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
                                <form action="{{ route('program_belajar.update', ['id' => $data->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <x-form_edit.edit_text name="nama_program" label="Nama Program"
                                                    :value="$data->nama_program" />
                                                <x-validation_form.error name="nama_program" />
                                            </div>
                                            <div class="col-3">
                                                @php
                                                    $option = [
                                                        'mudah' => 'Beginner (Pemula)',
                                                        'sedang' => 'Intermediate (Menengah)',
                                                        'sulit' => 'Advanced (Lanjutan)',
                                                    ];
                                                @endphp
                                                <x-form_edit.edit_dropdown label="Level" name="level" :option="$option" :data="$data->level" />
                                            </div>
                                            <div class="col-3">
                                                <label for="">Tipe Kelas</label>
                                                <select class="form-control" name="tipe_kelas_id">
                                                    @foreach ($tipe_kelas as $value)
                                                    <option value="{{ $value->id }}" {{$data->tipe_kelas == $value->tipe_kelas ? 'selected' : ''}}>{{ $value->tipe_kelas}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 my-3">
                                                <x-form_edit.edit_textArea name="deskripsi" label="Deskripsi"
                                                    :value="$data->deskripsi" />
                                                <x-validation_form.error name="deskripsi" />
                                            </div>
                                            <div class="col-4">
                                                <x-form_edit.edit_text name="mekanik" label="mekanik" :value="$data->mekanik" />
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
