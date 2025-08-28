<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ruang Robot - Tempatnya Belajar Robotik</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="">

    <!-- all css here -->

    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/bootstrap.min.css') }}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('lopard-live/css/owl.transitions.css') }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/animate.css') }}">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/meanmenu.min.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lopard-live/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('lopard-live/css/flaticon.css') }}">
    <!-- venobox css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/venobox.css') }}">
    <!-- venobox css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/venobox.css') }}">
    <!-- magnific css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/magnific.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/style.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('lopard-live/css/responsive.css') }}">
    {{-- smooth scroll --}}
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <!-- modernizr css -->
    <script src="{{ asset('lopard-live/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <div id="preloader"></div>
    <header class="header-one">
        <!-- Start top bar -->
        <div class="topbar-area fix hidden-xs">
            <div class="container">
                <div class="row">
                    <div class=" col-md-9 col-sm-9">
                        <div class="topbar-left">
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope"></i> info@ruangrobot.com</a></li>
                                <li><a href="http://wa.me/+6281272455577" target="_blank"><i class="fa fa-phone-square"></i> +6281272455577</a></li>
                                <li><a href="#"><i class="fa fa-clock-o"></i> Senin - Jumat: 09:00 - 17:00</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="top-social">
                            <ul>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End top bar -->
        <!-- header-area start -->
        <div id="sticker" class="header-area hidden-xs">
            <div class="container">
                <div class="row">
                    <!-- logo start -->
                    <div class="col-md-3 col-sm-3">
                        <div class="logo">
                            <!-- Brand -->
                            <a class="navbar-brand " href="">
                                <img style="width:150px;" src="{{ asset('images/ruangrobot.png') }}" alt="">
                            </a>
                        </div>
                        <!-- logo end -->
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <!-- mainmenu start -->
                        <nav class="navbar navbar-default">
                            <div class="collapse navbar-collapse" id="navbar-example">
                                <div class="main-menu">
                                    {{-- <ul class="nav navbar-nav navbar-right">
                                            <li><a class="pagess" href="index.html">Home</a>
                                                <ul class="sub-menu">
                                                    <li><a href="index.html">Home 01</a></li>
                                                    <li><a href="index-2.html">Home 02</a></li>
                                                    <li><a href="index-3.html">Home 03</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="pagess" href="#">Pages</a>
                                                <ul class="sub-menu">
                                                   <li><a href="about.html">About</a></li>
                                                    <li><a href="team.html">team</a></li>
                                                    <li><a href="faq.html">FAQ</a></li>
                                                    <li><a href="review.html">Review</a></li>
                                                    <li><a href="pricing.html">Pricing</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="pagess" href="#">Services</a>
                                                <ul class="sub-menu">
                                                    <li><a href="service.html">All services</a></li>
                                                    <li><a href="single-service.html">Service-details</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="pagess" href="#">Works</a>
                                                <ul class="sub-menu">
                                                    <li><a href="project.html">Projects 01</a></li>
                                                    <li><a href="project-2.html">Projects 02</a></li>
                                                    <li><a href="single-project.html">Project details</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="pagess" href="#">Blog</a>
                                                <ul class="sub-menu">
                                                    <li><a href="blog.html">Blog grid</a></li>
                                                    <li><a href="blog-sidebar.html">Blog Sidebar</a></li>
                                                    <li><a href="blog-details.html">Blog Details</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact.html">contacts</a></li>
                                        </ul> --}}
                                </div>
                            </div>
                        </nav>
                        <!-- mainmenu end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- header-area end -->
        <!-- mobile-menu-area start -->
        <div class="mobile-menu-area hidden-lg hidden-md hidden-sm">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mobile-menu">
                            <div class="logo">
                                <a href=""><img src="{{ asset('images/ruangrobot.png') }}" alt="" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area end -->
    </header>
    <!-- header end -->
    <!-- Start Slider Area -->
    <div class="intro-area intro-home">
        <div class="bg-wrapper">
            <img src="{{ asset('lopard-live/img/background/bg.jpg') }}" alt="">
        </div>
        <div class="intro-content">
            <div class="slider-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="slide-all-text">
                                <!-- layer 1 -->
                                <div class="layer-1 wow fadeInUp" data-wow-delay="0.3s">
                                    <h2 class="title2">Selamat Datang di
                                        Ruang Robot</h2>
                                </div>
                                <!-- layer 2 -->
                                <div class="layer-2 wow fadeInUp" data-wow-delay="0.5s">
                                    <p>Kembangkan Skill Robotik dan Pemrograman Kamu, Mulai Buat Project Pertamamu
                                        Sekarang.</p>
                                </div>
                                <!-- layer 3 -->
                                <div class="layer-3 wow fadeInUp" data-wow-delay="0.7s">
                                    <a href="{{ route('login') }}" class="ready-btn" method="POST">Login</a>
                                    <a class="ready-btn" href="https://wa.me/+6281272455577?text=Hai%20min%2C%20saya%20ingin%20mendaftar%20kelas%20reguler."
                                        target="_blank">Register
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 hidden-xs">
                            <div class="slide-images-inner wow fadeInUp" data-wow-delay="0.5s">
                                <div class="slide-images">
                                    <img src="{{ asset('lopard-live/img/slider/s1.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery latest version -->
    <script src="{{ asset('lopard-live/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('lopard-live/js/bootstrap.min.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('lopard-live/js/owl.carousel.min.js') }}"></script>
    <!-- venobox js -->
    <script src="{{ asset('lopard-live/js/venobox.min.js') }}"></script>
    <!-- magnific js -->
    <script src="{{ asset('lopard-live/js/magnific.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('lopard-live/js/wow.min.js') }}"></script>
    <!-- meanmenu js -->
    <script src="{{ asset('lopard-live/js/jquery.meanmenu.js') }}"></script>
    <!-- Form validator js -->
    <script src="{{ asset('lopard-live/js/form-validator.min.js') }}"></script>
    <!-- plugins js -->
    <script src="{{ asset('lopard-live/js/plugins.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('lopard-live/js/main.js') }}"></script>
</body>

</html>
