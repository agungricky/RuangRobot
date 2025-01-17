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
                                                <div class="col-12 mb-3">
                                                    <x-form_edit.edit_text name="nama_kelas" label="Nama Kelas"
                                                        :value="$data->nama_kelas" />
                                                    <x-validation_form.error name="nama_kelas" />
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <label for="penanggung_jawab">Penanggung Jawab Kelas</label>
                                                    <input type="text" id="penanggung_jawab" name="penanggung_jawab"
                                                        class="form-control" value="{{ $data->penanggung_jawab }}" />
                                                    <x-validation_form.error name="penanggung_jawab" />
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <x-form_edit.edit_text name="durasi_belajar" id="durasi_belajar"
                                                        label="Durasi Belajar Selesai" :value="$data->durasi_belajar" />
                                                    <x-validation_form.error name="durasi_belajar" />
                                                </div>
                                                <div class="col-5 mb-3">
                                                    <label for="autocomplete_program_belajar">Program Belajar</label>
                                                    <input type="text" id="programInput" name="program_belajar"
                                                        class="form-control" value="{{ $data->nama_program }}" />
                                                    <input type="hidden" id="programId" name="programId"
                                                        value="{{ $data->program_id }}" />
                                                    <x-validation_form.error name="programId" />
                                                    <x-validation_form.error name="program_belajar" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="">Jenis Kelas</label>
                                                    <select class="form-control" name="jenis_kelas">
                                                        @foreach ($kategori as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $data->jenis_kelas == $item->jenis_kelas ? 'selected' : '' }}>
                                                                {{ $item->jenis_kelas }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-validation_form.error name="jenis_kelas" />
                                                </div>
                                                <div class="col-6 mb-3">
                                                    @php
                                                        $option = [
                                                            'aktif' => 'Aktif',
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

    <script>
        $(document).ready(function() {
            // Auto Complate program Belajar
            $.ajax({
                url: "{{ route('form_programbelajar.json') }}",
                method: "GET",
                success: function(response) {
                    // Buat array objek dengan nama program dan ID
                    var programs = response.data.map(function(item) {
                        return {
                            label: item.nama_program, // Yang ditampilkan di autocomplete
                            value: item.nama_program, // Nilai input teks
                            id: item.id // ID yang disimpan
                        };
                    });

                    $('#programInput').autocomplete({
                        source: programs,
                        minLength: 1,
                        autoFocus: true,
                        select: function(event, ui) {
                            // Ketika item dipilih, simpan ID-nya di input hidden
                            $('#programId').val(ui.item.id);
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });

            // Auto Complate program Belajar
            $.ajax({
                url: "{{ route('form_programbelajar.json') }}",
                method: "GET",
                success: function(response) {
                    // Buat array objek dengan nama program dan ID
                    var programs = response.data.map(function(item) {
                        return {
                            label: item.nama_program, // Yang ditampilkan di autocomplete
                            value: item.nama_program, // Nilai input teks
                            id: item.id // ID yang disimpan
                        };
                    });

                    // Menginisialisasi autocomplete
                    $('#programInput').autocomplete({
                        source: programs,
                        minLength: 1,
                        autoFocus: true,
                        select: function(event, ui) {
                            // Ketika item dipilih, simpan ID-nya di input hidden
                            $('#programId').val(ui.item.id);
                        }
                    });

                    // Jika ada nilai program yang sudah terisi, set ID-nya otomatis
                    var initialProgram = programs.find(function(program) {
                        return program.value === "{{ $data->nama_program }}";
                    });

                    if (initialProgram) {
                        $('#programInput').val(initialProgram.value);
                        $('#programId').val(initialProgram.id);
                    }
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });


            // Auto Complate pengajar
            $.ajax({
                url: "{{ route('pengajar.json') }}",
                method: "GET",
                success: function(response) {
                    // alert(response);
                    var programs = response.data.map(function(item) {
                        return item.nama;
                    });

                    $('#penanggung_jawab').autocomplete({
                        source: programs,
                        minLength: 1,
                        autoFocus: true
                    });
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });
    </script>
@endsection
