<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>LOGIN &mdash; RUANG ROBOT</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body class="bg-white">
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="{{ asset('images/ruangrobot.png') }}" alt="logo" width="150">
                        </div>
                        <h4 class="text-center">Selamat Datang!</h4>
                        <p class="text-center">Silahkan login untuk melanjutkan.</p>
                        <div class="card" style="box-shadow: none;">
                            <div class="card-body">
                                @if (session('msg'))
                                    <div class="alert alert-danger text-sm">
                                        {{ session('msg') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('proses-Login') }}" class="needs-validation">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control" name="username"
                                            required>
                                        <x-validation_form.error name="username" />
                                    </div>


                                    <div class="form-group" style="position: relative;">
                                        <label for="password" class="control-label">Password</label>

                                        <input id="password" type="password" class="form-control" name="password"
                                            required style="padding-right: 40px;">

                                        <!-- Ikon Mata -->
                                        <i id="togglePassword" class="fas fa-eye-slash"
                                            style="position: absolute; right: 15px; top: 40%; transform: translateY(40%);
                                                   cursor: pointer; color: gray; font-size: 1.5rem;"></i>

                                        <x-validation_form.error name="password" />
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="remember"
                                                tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">
                                                {{ __('Ingat Saya') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                            tabindex="4">Login</button>
                                    </div>
                                </form>
                                <div class="text-muted text-center">
                                    Tidak mempunyai akun? <a
                                        href="https://wa.me/6285655770506?text={{ urlencode('Halo Ruang Robot.
                                                                                                                                                                                                                                                                                                                                                                        Saya Mau daftar.
                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                        Nama Lengkap:
                                                                                                                                                                                                                                                                                                                                                                        Nomor Telfon:
                                                                                                                                                                                                                                                                                                                                                                        Sekolah:
                                                                                                                                                                                                                                                                                                                                                                        Tanggal Lahir:
                                                                                                                                                                                                                                                                                                                                                                        Alamat:
                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                        Terimakasih.') }}">Daftar
                                        Disini</a>
                                </div>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Ruang Robot
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#togglePassword").on("click", function(event) {
                event.preventDefault(); // Mencegah fokus input
                let passwordField = $("#password");
                let type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);

                // Toggle ikon mata
                $(this).toggleClass("fa-eye fa-eye-slash");
            });
        });
    </script>
</body>

</html>
