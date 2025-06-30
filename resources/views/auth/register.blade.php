<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register &mdash; Ruang Robot</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/livecanvas-team/ninjabootstrap/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            font-weight: 300;
            font-size: 1rem;
            letter-spacing: 0.2px;
            height: 100%;
            overflow-x: hidden;
        }

        .fullscreen-wrapper {
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-color: #fff;
        }

        .card-container {
            width: 100%;
            max-width: 960px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            overflow: hidden;
        }

        .left-panel {
            background-color: #f8f9fa;
            padding: 2rem;
            text-align: center;
        }

        .left-panel img {
            max-height: 70px;
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
        }

        .form-control {
            font-size: 0.9rem !important;
            font-weight: 300 !important;
            padding: 0.4rem 0.6rem !important;
            border: 1px solid #cfe2ff !important;
            border-radius: 0.375rem !important;
        }

        .select2-container--default .select2-selection--single {
            font-size: 0.9rem !important;
            font-weight: 300 !important;
            padding: 0.4rem 0.6rem !important;
            border: 1px solid #cfe2ff !important;
            border-radius: 0.375rem !important;
            height: calc(1.5em + 0.8rem + 2px) !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;
            padding-right: 0 !important;
            color: #212529;
            line-height: normal !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
        }

        .select2-results__options {
            max-height: 140px !important;
            overflow-y: auto !important;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #72abff !important;
        }

        #agreeCheckbox {
            width: 23px;
            height: 23px;
        }

        @media (max-width: 767.98px) {
            .left-panel {
                background: none;
                padding: 1rem;
            }

            .left-panel img {
                max-height: 50px;
            }

            .card-container {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="fullscreen-wrapper">
        <div class="row card-container mx-0">

            <!-- Kiri -->
            <div class="col-lg-4 left-panel d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('images/ruangrobot.png') }}" alt="Logo Ruang Robot" class="img mb-4 mb-md-3">
                <h4 class="fw-bold mb-2 text-secondary">Selamat Datang!</h4>
                <p class="text-muted small mb-0">Silakan register untuk melakukan pendaftaran.</p>
            </div>

            <!-- Kanan -->
            <div class="col-lg-8 p-2 p-md-4 pt-md-5">
                <h3 class="fw-semibold mb-4 text-center text-secondary d-none d-md-block">Form Register Siswa</h3>

                <form action="{{ route('register.post') }}" id="pengguna_form" method="POST" class="mx-2">
                    @csrf
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan nama lengkap" value="{{ old('nama') }}">
                            @if ($errors->has('nama'))
                                <span class="error text-danger mb-2">
                                    {{ $errors->first('nama') }}
                                </span>
                            @endif

                        </div>

                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email aktif" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="error text-danger mb-2">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif

                        </div>

                        <div class="col-12 col-md-6">
                            <label for="no_telp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp"
                                placeholder="Masukkan nomor HP" value="{{ old('no_telp', '+62') }}">
                            @if ($errors->has('no_telp'))
                                <span class="error text-danger mb-2">
                                    {{ $errors->first('no_telp') }}
                                </span>
                            @endif

                        </div>

                        <div class="col-12 col-md-6">
                            <label for="sekolah_id" class="form-label">Pilih Sekolah</label>
                            <select class="form-control select2" id="sekolah_id" name="sekolah_id"
                                data-placeholder="-- Pilih Sekolah --">
                            </select>
                            @if ($errors->has('sekolah_id'))
                                <span class="error text-danger mb-2">
                                    {{ $errors->first('sekolah_id') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="Masukkan alamat tinggal" value="{{ old('alamat') }}">
                            @if ($errors->has('alamat'))
                                <span class="error text-danger mb-2">
                                    {{ $errors->first('alamat') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-12 p-3 rounded-2 mb-3">
                            <div class="form-check d-flex align-items-start mb-2">
                                <input class="form-check-input align-self-center mt-0 me-2" type="checkbox"
                                    id="agreeCheckbox">
                                <label class="form-check-label small" for="agreeCheckbox">
                                    <span class="text-danger fw-bold fs-5">*</span>
                                    Akan ada biaya pendaftaran Rp. 150.000, lanjutkan jika setuju.
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2" id="submitBtn" disabled>
                                Register Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <footer class="text-center">
                <div class="text-muted small d-block d-sm-none">
                    &copy; {{ date('Y') }} <span class="mx-1">•</span> Ruang Robot
                </div>
            </footer>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Chexbox untuk mengaktifkan tombol submit
        const checkbox = document.getElementById('agreeCheckbox');
        const submitBtn = document.getElementById('submitBtn');

        checkbox.addEventListener('change', function() {
            submitBtn.disabled = !this.checked;
        });

        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: "-- Pilih Sekolah --",
                allowClear: true
            });

            // Validasi No HP
            const $input = $('#no_telp');

            $input.on('focus', function() {
                if (!$input.val().startsWith('+62')) {
                    $input.val('+62');
                }
            });

            $input.on('keydown', function(e) {
                const pos = this.selectionStart;

                if (pos <= 3 && (e.key === 'Backspace' || e.key === 'Delete')) {
                    e.preventDefault();
                }

                if (pos === 3 && e.key === '0') {
                    e.preventDefault();
                }
            });

            $input.on('input', function() {
                let val = $input.val();

                if (!val.startsWith('+62')) {
                    val = '+62';
                }

                const angka = val.substring(3).replace(/\D/g, '');
                $input.val('+62' + angka);
            });

            // Data Sekolah
            let sekolahSelect = $('#sekolah_id');
            $.ajax({
                type: "GET",
                url: "{{ route('sekolah') }}",
                dataType: "json",
                success: function(response) {
                    sekolahSelect.empty();
                    sekolahSelect.append('<option value="">-- Pilih Sekolah --</option>');
                    response.data.forEach(function(sekolah) {
                        sekolahSelect.append(
                            `<option value="${sekolah.id}">${sekolah.nama_sekolah}</option>`
                        );
                    });
                    sekolahSelect.append('<option value="lainnya">Lainnya</option>');
                    sekolahSelect.trigger('change');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });


            $('#sekolah').select2({
                width: '100%',
                placeholder: "-- Pilih Sekolah --",
                allowClear: true,
                dropdownCssClass: "limit-height"
            });



        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
