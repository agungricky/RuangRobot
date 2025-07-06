<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>RUANG ROBOT</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="" />

    <!-- General CSS Files -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    {{-- Boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Datatable --}}
    <link href="{{ url('https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css') }}" rel="stylesheet"
        integrity="sha384 iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/datatables/style.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    @stack('script-css')

    {{-- crsf For Ajax Call --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> --}}

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS Clock Picker -->
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/clockpicker/dist/jquery-clockpicker.min.css') }}">
    {{-- Css jquery ui untuk auto complate --}}
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">

    {{-- Style CSS Custom --}}
    <link rel="stylesheet" href="{{ asset('css_custom/style.css') }}">

    {{-- Iput Search --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Editor Fied Text Area --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet" />
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @include('main.navbar')

            @include('main.sidebar')

            @yield('content')

            @include('main.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/popper.min.js') }}"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    {{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script> --}}
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- datatable --}}
    <script src="{{ url('https://cdn.datatables.net/2.1.0/js/dataTables.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Clock Picker JS -->
    <script src="{{ url('https://cdn.jsdelivr.net/npm/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>

    {{-- jquery ui untuk auto complate --}}
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    {{-- Sweet Alert --}}
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- Editor Fied Text Area Sumernote --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

</body>

</html>
