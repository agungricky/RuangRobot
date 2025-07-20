@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Update Kategori Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('kategori_kelas.update', ['id' => $data->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <x-form_edit.edit_text name="kategori" label="Nama Kategori Kelas"
                                            :value="$data->kategori_kelas" />
                                        <x-validation_form.error name="kategori" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="color_bg" class="block text-sm font-semibold text-gray-700 mb-1">
                                            Warna Background
                                        </label>
                                        <div class="flex items-center space-x-3">
                                            <input type="color" name="color_bg" id="color_bg"
                                                class="rounded-lg border border-gray-400 shadow"
                                                value="{{ old('color_bg', $data->color_bg ) }}" style="width: 100%; height: 80px;">
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
