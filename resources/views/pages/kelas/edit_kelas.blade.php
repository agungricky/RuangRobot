@extends('main.layout')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-title_halaman title="Update Kelas" />

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('kelas.update', ['id' => $data->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div id="inputFieldsContainer">
                                        <div class="field">
                                            <div class="row">
                                                <div class="col-8 mb-3">
                                                    <x-form_edit.edit_text name="nama_kelas" label="Nama Kelas"
                                                        :value="$data->nama_kelas" />
                                                    <x-validation_form.error name="nama_kelas" />
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <label for="kode_kelas">Kode Kelas</label>
                                                    <input type="text" id="kode_kelas" name="kode_kelas"
                                                        class="form-control" placeholder="Masukan kode kelas"
                                                        value="{{ $data->kode_kelas }}" />
                                                    <div id="error-kode_kelas" class="text-danger"></div>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <label for="penanggung_jawab">Penanggung Jawab Kelas</label>
                                                    <select id="penanggung_jawab" name="penanggung_jawab"
                                                        class="form-control select2">
                                                        <option value="">-- Pilih Pengajar --</option>
                                                        @foreach ($pengajarList as $pengajar)
                                                            <option value="{{ $pengajar->id }}"
                                                                {{ $pengajar->id == $data->pengajar->id ? 'selected' : '' }}>
                                                                {{ $pengajar->pengguna->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-validation_form.error name="penanggung_jawab" />
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <x-form_edit.edit_text name="durasi_belajar" id="durasi_belajar"
                                                        label="Durasi Belajar Selesai" :value="$data->durasi_belajar" />
                                                    <x-validation_form.error name="durasi_belajar" />
                                                </div>
                                                <div class="col-5 mb-3">
                                                    <label for="autocomplete_program_belajar">Program Belajar</label>
                                                    <select id="programId" name="programId" class="form-control select2">
                                                        <option value="">-- Pilih Program Belajar --</option>
                                                        @foreach ($programBelajar as $program)
                                                            <option value="{{ $program->id }}"
                                                                {{ $program->id == $data->program_belajar_id ? 'selected' : '' }}>
                                                                {{ $program->nama_program }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-validation_form.error name="programId" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="">Jenis Kelas</label>
                                                    <select class="form-control" name="kategori_kelas">
                                                        @foreach ($kategori as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $data->kategori_kelas_id ? 'selected' : '' }}>
                                                                {{ $item->kategori_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-validation_form.error name="kategori_kelas" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    @php
                                                        $option = [
                                                            'aktif' => 'Aktif',
                                                            'pending' => 'Pending',
                                                            'selesai' => 'Selesai',
                                                        ];
                                                    @endphp
                                                    <label for="">Status Kelas</label>
                                                    <x-form_edit.edit_dropdown name="status_kelas" label="Status Kelas"
                                                        :option="$option" :data="$data->status_kelas" />
                                                    <x-validation_form.error name="status_kelas" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <x-form_edit.edit_number name="gaji_pengajar" label="Gaji Pengajar"
                                                        :value="$data->gaji_pengajar" />
                                                    <x-validation_form.error name="gaji_pengajar" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <x-form_edit.edit_number name="gaji_transport" label="Gaji Transport"
                                                        :value="$data->gaji_transport" />
                                                    <x-validation_form.error name="gaji_transport" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <x-form_edit.edit_number name="harga_kelas" label="Harga Kelas"
                                                        :value="$data->harga" />
                                                    <x-validation_form.error name="harga_kelas" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="jatuh_tempo">Tanggal Jatuh Tempo</label>
                                                    <input type="date" name="jatuh_tempo" id="jatuh_tempo"
                                                        class="form-control" value="{{ $data->jatuh_tempo }}">
                                                    <x-validation_form.error name="jatuh_tempo" />
                                                </div>

                                                <input type="hidden" name="kategoriKelas"
                                                    value="{{ $data->kategori_kelas_id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success px-5 py-2">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #d6e7ff;
            padding: 7px 0px 0px 9px !important;
            border-radius: 0.375rem;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih Pengajar --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
