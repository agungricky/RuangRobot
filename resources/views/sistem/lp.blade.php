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

    <!--[if lt IE 8]>
   <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

    <div id="preloader"></div>
    <header class="header-one">
        <!-- Start top bar -->
        <div class="topbar-area fix hidden-xs">
            <div class="container">
                <div class="row">
                    <div class=" col-md-9 col-sm-9">
                        <div class="topbar-left">
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope"></i> info@ruangrobot.id</a></li>
                                <li><a href="#"><i class="fa fa-phone-square"></i> +6285655770506</a></li>
                                <li><a href="#"><i class="fa fa-clock-o"></i> Senin - Jumat: 10:00 - 18:00</a>
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
                            {{-- <nav id="dropdown">
                                    <ul>
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
                                    </ul>
                                </nav> --}}
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
                                    <a href="{{ route('login')}}" class="ready-btn" method="POST">Login</a>
                                    <a href="https://wa.me/6285655770506?text={{ urlencode('Halo Ruang Robot.
                                    Saya Mau daftar.
                                    
                                    Nama Lengkap:
                                    Nomor Telfon:
                                    Sekolah:
                                    Tanggal Lahir:
                                    Alamat:
                                    
                                    Terimakasih.') }}"
                                        class="ready-btn">Register</a>
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
    <!-- End Slider Area -->
    <!-- Start Brand Area -->
    {{-- <div class="about-area area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="about-content">
                            <img src="{{ asset('lopard-live/img/about/ab.png') }}" alt="">
                        </div>
                    </div>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="about-text">
                            <h3>Tentang <span class="color">Ruang Robot</span>.</h3>
						    <p>Replacing a  maintains the amount of lines. When replacing a selection. help agencies to define their new business objectives and then create. maintains the amount of lines. When replacing a selection. help agencies to define their new business objectives and then create</p>
                            <ul class="hidden-sm">
                                <li><a href="#">Innovation idea latest business tecnology</a></li>
                                <li><a href="#">Digital content marketing online clients plateform</a></li>
                                <li><a href="#">Safe secure services for you online email account</a></li>
                                <li><a href="#">Innovation idea latest business tecnology</a></li>
                            </ul>
                            <a class="ab-btn" href="about.html">Learn more</a>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
       <!-- End Banner Area -->
        <!-- Service area start -->
        <div class="service-area bg-color area-padding">
            <div class="container">
               <div class="row">
					<div class="all-service">
					    <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-service text-service">
                                <h3>Digital agency <span class="color">services & Solutions</span></h3>
                                <p>Our consultants opt in to the projects they genuinely want to work on.</p>
                                <a class="service-btn" href="#">All solution</a>
                            </div>
                        </div>
                        <!-- single-service end-->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-service">
                                <div class="service-img">
                                    <img src="img/service/w1.png" alt="">
                                </div>
                                <div class="service-content">
                                    <h4><a href="#">Data Preparation</a></h4>
                                    <p>Dummy text is also used to demonstrate the appearance of different. consultants opt in to the projects.</p>
                                </div>
                            </div>
                        </div>
                        <!-- single-service end-->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-service text-service">
                                <div class="service-img">
                                    <img src="img/service/w2.png" alt="">
                                </div>
                                <div class="service-content">
                                    <h4><a href="#">AI development</a></h4>
                                    <p>Dummy text is also used to demonstrate the appearance of different. consultants opt in to the projects.</p>
                                </div>
                            </div>
                        </div>
                        <!-- single-service end-->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-service">
                                <div class="service-img">
                                    <img src="img/service/w3.png" alt="">
                                </div>
                                <div class="service-content">
                                    <h4><a href="#">Digital ecommerce</a></h4>
                                   <p>Dummy text is also used to demonstrate the appearance of different. consultants opt in to the projects.</p>
                                </div>
                            </div>
                        </div>
                        <!-- single-well end-->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-service text-service">
                                <div class="service-img">
                                    <img src="img/service/w4.png" alt="">
                                </div>
                                <div class="service-content">
                                    <h4><a href="#">Consumer technology</a></h4>
                                    <p>Dummy text is also used to demonstrate the appearance of different. consultants opt in to the projects.</p>
                                </div>
                            </div>
                        </div>
                       <!-- single-service end-->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-service">
                                <div class="service-img">
                                    <img src="img/service/w5.png" alt="">
                                </div>
                                <div class="service-content">
                                    <h4><a href="#">Big data Service</a></h4>
                                    <p>Dummy text is also used to demonstrate the appearance of different. consultants opt in to the projects.</p>
                                </div>
                            </div>
                        </div>
                        <!-- single-service end-->
					</div>
                </div>
            </div>
        </div>
        <!-- Service area End -->
        <!-- Start Challange Area -->
        <div class="tab-area fix area-padding">
            <div class="container">
                <div class="row">
					<!-- End single page -->
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="tab-menu">
							 <!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li class="active">
								    <a href="#p-view-1" role="tab" data-toggle="tab">
							            <span class="cha-icon"><i class="flaticon-017-automation"></i></span>
								        <span class="cha-title">Research & solution</span>
								    </a>
								</li>
								<li>
								    <a href="#p-view-2" role="tab" data-toggle="tab">
							            <span class="cha-icon"><i class="flaticon-036-chip"></i></span>
								        <span class="cha-title">Design & strategy</span>
								    </a>
								</li>
								<li>
							        <a href="#p-view-3" role="tab" data-toggle="tab">
							            <span class="cha-icon"><i class="flaticon-016-ai"></i></span>
								        <span class="cha-title">Artificial intelligence</span>
								    </a>
								</li>
								<li>
							        <a href="#p-view-4" role="tab" data-toggle="tab">
							           <span class="cha-icon"><i class="flaticon-091-ai"></i></span>
								        <span class="cha-title">Cloud deployment</span>
								    </a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="tab-content">
							<div class="tab-pane active" id="p-view-1" >
								<div class="tab-inner">
									<div class="single-machine row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="tabe-img">
                                                <img src="img/service/s1.png" alt="">
                                            </div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="machine-text">
                                                <h3>Enterprise AI and data platform solutions</h3>
                                                <p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical. used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical</p>
                                                <ul>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                    <li><a href="#">Digital content marketing online clients plateform</a></li>
                                                    <li><a href="#">Safe secure services for you online email account</a></li>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                </ul>
                                            </div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="p-view-2">
								<div class="tab-inner">
									<div class="single-machine row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="tabe-img">
                                                <img src="img/service/s2.png" alt="">
                                            </div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="machine-text">
                                                <h3>Design and development use latest technology</h3>
                                                <p>And in general the content of dummy text is nonsensical. used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical. Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>
                                                <ul>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                    <li><a href="#">Digital content marketing online clients plateform</a></li>
                                                    <li><a href="#">Safe secure services for you online email account</a></li>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                </ul>
                                            </div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="p-view-3">
								<div class="tab-inner">
									<div class="single-machine row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="tabe-img">
                                                <img src="img/service/s3.png" alt="">
                                            </div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="machine-text">
                                                <h3>Artificial intelligence use in automobile industry</h3>
                                                <p>Used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical. text is also used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical</p>
                                                <ul>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                    <li><a href="#">Digital content marketing online clients plateform</a></li>
                                                    <li><a href="#">Safe secure services for you online email account</a></li>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                </ul>
                                            </div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="p-view-4">
								<div class="tab-inner">
									<div class="single-machine row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="tabe-img">
                                                <img src="img/service/s4.png" alt="">
                                            </div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="machine-text">
                                                <h3>machine learning platform used cloud deployment</h3>
                                                <p>Dummy text is also used. used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensica to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical.</p>
                                                <ul>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                    <li><a href="#">Digital content marketing online clients plateform</a></li>
                                                    <li><a href="#">Safe secure services for you online email account</a></li>
                                                    <li><a href="#">Innovation idea latest business tecnology</a></li>
                                                </ul>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- end column -->
				</div>
				<!-- end Row -->
            </div>
        </div>
        <!-- End Tab end -->
        <!-- Start Subscribe area -->
        <div class="achivement-area bg-color area-padding">
            <div class="container">
                <!-- Start counter Area -->
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>Our achievement</h3>
							<p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>
						</div>
					</div>
				</div>
                 <div class="row">
                    <div class="achivement-content">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- fun_text  -->
                            <div class="single-achive">
                                <div class="achive-image">
                                    <img src="img/about/achive1.png" alt="">
                                </div>
                                <div class="achivement-text">
                                    <span class="achive-number">10+</span>
                                    <h4>Years expereince</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- fun_text  -->
                            <div class="single-achive">
                                <div class="achive-image">
                                    <img src="img/about/achive2.png" alt="">
                                </div>
                                <div class="achivement-text">
                                    <span class="achive-number">07</span>
                                    <h4>Offices worldwide</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- fun_text  -->
                            <div class="single-achive">
                                <div class="achive-image">
                                    <img src="img/about/achive3.png" alt="">
                                </div>
                                <div class="achivement-text">
                                    <span class="achive-number">400+</span>
                                    <h4>Experts team</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="we-services">
                    	    <!-- single-well end-->
						    <div class="digital-services">
						        <div class="digital-wel s1-item">
                                    <div class="digital-img">
                                        <a class="digital-icon" href="#"><img src="img/icon/lopard1.png" alt=""></a>
                                    </div>
									<div class="digital-content">
										<h4>Industries & manufacturing</h4>
									</div>
								</div>
							</div>
						    <!-- single-well end-->
							<div class="digital-services">
								<div class="digital-wel s2-item">
                                    <div class="digital-img">
                                        <a class="digital-icon" href="#"><img src="img/icon/lopard2.png" alt=""></a>
                                    </div>
									<div class="digital-content">
										<h4>Automobile & transportation</h4>
									</div>
								</div>
							</div>
							<!-- single-well end-->
							<div class="digital-services">
								<div class="digital-wel s4-item">
                                    <div class="digital-img">
                                        <a class="digital-icon" href="#"><img src="img/icon/lopard3.png" alt=""></a>
                                    </div>
									<div class="digital-content">
										<h4>Food & agriculture</h4>
									</div>
								</div>
							</div>
							<!-- single-well end-->
							<div class="digital-services">
								<div class="digital-wel s3-item">
                                    <div class="digital-img">
                                        <a class="digital-icon" href="#"><img src="img/icon/lopard4.png" alt=""></a>
                                    </div>
									<div class="digital-content">
										<h4>Health & humanbody</h4>
									</div>
								</div>
							</div>
							<!-- single-well end-->
							<div class="digital-services">
								<div class="digital-wel s5-item">
                                    <div class="digital-img">
                                        <a class="digital-icon" href="#"><img src="img/icon/lopard5.png" alt=""></a>
                                    </div>
									<div class="digital-content">
										<h4>Media & entertainment</h4>
									</div>
								</div>
							</div>
							<!-- single-well end-->
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Subscribe area -->
        <!-- Start project Area -->
        <div class="project-area area-padding">
            <div class="container">
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 ">
						<div class="section-headline text-center">
							<h3>Our successful goal</h3>
							<p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="project-carousel">
                        <!-- single-awesome-project start -->
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="single-awesome-project">
                                <div class="awesome-img">
                                    <a href="#">
                                        <img src="img/project/1.jpg" alt="" />
                                    </a>
                                    <div class="add-actions text-center">
                                        <a class="venobox" data-gall="myGallery" href="img/project/1.jpg">
                                            <i class="port-icon ti-zoom-in"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="project-dec">
                                    <h4>Data collection</h4>
                                    <p>Our development opt in to the projects they genuinely want to work on, committing wholeheartedly to delivering.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- single-awesome-project start -->
                            <div class="single-awesome-project">
                                <div class="awesome-img">
                                    <a href="#">
                                        <img src="img/project/2.jpg" alt="" />
                                    </a>
                                    <div class="add-actions text-center">
                                        <a class="venobox" data-gall="myGallery" href="img/project/2.jpg">
                                            <i class="port-icon ti-zoom-in"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="project-dec">
                                    <h4>Models development</h4>
                                    <p>Our development opt in to the projects they genuinely want to work on, committing wholeheartedly to delivering.</p>
                                </div>
                            </div>
                            <!-- single-awesome-project end -->
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- single-awesome-project start -->
                            <div class="single-awesome-project">
                                <div class="awesome-img">
                                    <a href="#">
                                        <img src="img/project/3.jpg" alt="" />
                                    </a>
                                    <div class="add-actions text-center">
                                        <a class="venobox" data-gall="myGallery" href="img/project/3.jpg">
                                            <i class="port-icon ti-zoom-in"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="project-dec">
                                    <h4>Service deployment</h4>
                                    <p>Our development opt in to the projects they genuinely want to work on, committing wholeheartedly to delivering.</p>
                                </div>
                            </div>
                            <!-- single-awesome-project end -->
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- single-awesome-project start -->
                            <div class="single-awesome-project">
                                <div class="awesome-img">
                                    <a href="#">
                                        <img src="img/project/4.jpg" alt="" />
                                    </a>
                                    <div class="add-actions text-center">
                                        <a class="venobox" data-gall="myGallery" href="img/project/4.jpg">
                                            <i class="port-icon ti-zoom-in"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="project-dec">
                                    <h4>Environment project</h4>
                                    <p>Our development opt in to the projects they genuinely want to work on, committing wholeheartedly to delivering.</p>
                                </div>
                            </div>
                            <!-- single-awesome-project end -->
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- single-awesome-project start -->
                            <div class="single-awesome-project">
                                <div class="awesome-img">
                                    <a href="#">
                                        <img src="img/project/5.jpg" alt="" />
                                    </a>
                                    <div class="add-actions text-center">
                                        <a class="venobox" data-gall="myGallery" href="img/project/5.jpg">
                                            <i class="port-icon ti-zoom-in"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="project-dec">
                                    <h4>Design solution</h4>
                                    <p>Our development opt in to the projects they genuinely want to work on, committing wholeheartedly to delivering.</p>
                                </div>
                            </div>
                            <!-- single-awesome-project end -->
                        </div>
                    </div>		
                </div>	
            </div>
            <!-- End main content -->
        </div>
        <!-- End project Area -->
        <!-- Start testimonials Area -->
        <div class="reviews-area bg-color fix area-padding">
            <div class="container">
                <div class="row">
                    <div class="reviews-top">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="testimonial-inner">
                                <div class="review-head">
                                    <h3>Our customer say <span class="color"> about our company</span> work</h3>
                                    <p>The phrasal sequence of the Lorem Ipsum text is now so widespread and commonplace that many DTP programmes can generate dummy. The phrasal sequence of the Lorem Ipsum text is now so widespread and commonplace that many DTP programmes can generate dummy</p>
                                    <a class="reviews-btn" href="review.html">More reviews</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="reviews-content">
                                <!-- start testimonial carousel -->
                                <div class="testimonial-carousel item-indicator">
                                    <div class="single-testi">
                                        <div class="testi-text">
                                            <div class="clients-text">
                                                <div class="client-rating">
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                </div>
                                                <p>When replacing a multi-lined selection of text, the generated dummy text maintains the amount of lines. When replacing a selection. help agencies.</p>
                                            </div>
                                            <div class="testi-img ">
                                                <img src="img/review/1.jpg" alt="">
                                                <div class="guest-details">
                                                    <h4>Hamilton</h4>
                                                    <span class="guest-rev">Clients - <a href="#">General customer</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End single item -->
                                    <div class="single-testi">
                                        <div class="testi-text">
                                            <div class="clients-text">
                                                <div class="client-rating">
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                </div>
                                                <p>When replacing a multi-lined selection of text, the generated dummy text maintains the amount of lines. When replacing a selection. help agencies.</p>
                                            </div>
                                            <div class="testi-img ">
                                                <img src="img/review/2.jpg" alt="">
                                                <div class="guest-details">
                                                    <h4>Angel lima</h4>
                                                    <span class="guest-rev">Clients - <a href="#">General customer</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End single item -->
                                    <div class="single-testi">
                                        <div class="testi-text">
                                            <div class="clients-text">
                                                <div class="client-rating">
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                </div>
                                                <p>When replacing a multi-lined selection of text, the generated dummy text maintains the amount of lines. When replacing a selection. help agencies.</p>
                                            </div>
                                            <div class="testi-img ">
                                                <img src="img/review/3.jpg" alt="">
                                                <div class="guest-details">
                                                    <h4>Arthur Doil</h4>
                                                    <span class="guest-rev">Clients - <a href="#">General customer</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End single item -->
                                    <div class="single-testi">
                                        <div class="testi-text">
                                            <div class="clients-text">
                                                <div class="client-rating">
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                    <a href="#"><i class="ti-star"></i></a>
                                                </div>
                                                <p>When replacing a multi-lined selection of text, the generated dummy text maintains the amount of lines. When replacing a selection. help agencies.</p>
                                            </div>
                                            <div class="testi-img ">
                                                <img src="img/review/4.jpg" alt="">
                                                <div class="guest-details">
                                                    <h4>Gabriel Hank</h4>
                                                    <span class="guest-rev">Clients - <a href="#">General customer</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End single item -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End testimonials end -->
        <!--Blog Area Start-->
        <div class="blog-area fix area-padding-2">
            <div class="container">
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline text-center">
							<h3>Machine Learning news</h3>
							<p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="blog-grid home-blog">
                        <!-- Start single blog -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-blog">
                               <div class="blog-image">
									<a class="image-scale" href="#">
										<img src="img/blog/b1.jpg" alt="">
									</a>
								</div>
                                <div class="blog-content">
                                   <div class="blog-meta">
                                        <span class="admin-type">
                                            <i class="fa fa-user"></i>
                                            Admin
                                        </span>
                                        <span class="date-type">
                                            <i class="fa fa-calendar"></i>
                                            20 july, 2019
                                        </span>
                                        <span class="comments-type">
                                            <i class="fa fa-comment-o"></i>
                                            13
                                        </span>
                                    </div>
                                    <a href="#">
                                        <h4>Creative design clients response is better</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-blog">
                               <div class="blog-image">
									<a class="image-scale" href="#">
										<img src="img/blog/b2.jpg" alt="">
									</a>
								</div>
                                <div class="blog-content">
                                   <div class="blog-meta">
                                       <span class="admin-type">
                                            <i class="fa fa-user"></i>
                                            Admin
                                        </span>
                                        <span class="date-type">
                                           <i class="fa fa-calendar"></i>
                                            13 may, 2018
                                        </span>
                                        <span class="comments-type">
                                            <i class="fa fa-comment-o"></i>
                                            16
                                        </span>
                                    </div>
                                    <a href="#">
                                        <h4>Web development is a best work in future world</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-blog">
                                <div class="blog-image">
									<a class="image-scale" href="#">
										<img src="img/blog/b3.jpg" alt="">
									</a>
								</div>
                                <div class="blog-content">
                                   <div class="blog-meta">
                                        <span class="admin-type">
                                            <i class="fa fa-user"></i>
                                            Admin
                                        </span>
                                        <span class="date-type">
                                           <i class="fa fa-calendar"></i>
                                            24 april, 2019
                                        </span>
                                        <span class="comments-type">
                                            <i class="fa fa-comment-o"></i>
                                            07
                                        </span>
                                    </div>
                                    <a href="#">
                                        <h4>You can trust me and business with together</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <div class="hidden-md hidden-lg col-sm-6 col-xs-12">
                            <div class="single-blog">
                                <div class="blog-image">
									<a class="image-scale" href="#">
										<img src="img/blog/b4.jpg" alt="">
									</a>
								</div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span class="admin-type">
                                            <i class="fa fa-user"></i>
                                            Admin
                                        </span>
                                        <span class="date-type">
                                           <i class="fa fa-calendar"></i>
                                            28 june, 2019
                                        </span>
                                        <span class="comments-type">
                                            <i class="fa fa-comment-o"></i>
                                            32
                                        </span>
                                    </div>
                                    <a href="#">
                                        <h4>business man want to be benifit any way</h4>
                                    </a>
                                </div> 
                            </div>
                        </div>
                        <!-- End single blog -->
                    </div>
                </div>
                <!-- End row -->
            </div>
        </div>
        <!--End of Blog Area-->
        <!-- Start Footer bottom Area -->
        <footer class="footer1">
            <div class="footer-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="footer-content logo-footer">
                                <div class="footer-head">
                                    <div class="footer-logo">
                                    	<a class="footer-black-logo" href="#"><img src="img/logo/logo2.png" alt=""></a>
                                    </div>
                                    <p>
                                        Are you looking for professional advice for your new business. Are you looking for professional advice for your new business. Are you looking for professional advice for your new business.
                                    </p>
                                    <div class="subs-feilds">
                                        <div class="suscribe-input">
                                            <input type="email" class="email form-control width-80" id="sus_email" placeholder="Type Email">
                                            <button type="submit" id="sus_submit" class="add-btn">Subscribe</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="col-md-4 col-sm-3 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <h4>Services Link</h4>
                                    <ul class="footer-list">
                                        <li><a href="#">Business</a></li>
                                        <li><a href="#">Agency </a></li>
                                        <li><a href="#">Social media</a></li>
                                        <li><a href="#">Branding</a></li>
                                        <li><a href="#">Design </a></li>
                                    </ul>
                                    <ul class="footer-list hidden-sm">
										<li><a href="#">Search engine</a></li>
                                        <li><a href="#">Online support</a></li>
                                        <li><a href="#">Development</a></li>
                                        <li><a href="#">Pay per click</a></li>
                                        <li><a href="#">Event activation</a></li>
									</ul>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="footer-content last-content">
                                <div class="footer-head">
                                    <h4>Information</h4> 
                                    <div class="footer-contacts">
										<p><span>Tel :</span> +0890-564-5644</p>
										<p><span>Email :</span> info@lopard3.com</p>
										<p><span>Location :</span> House- 65/4, London</p>
									</div> 
                                    <div class="footer-icons">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-google"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-pinterest"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="copyright">
                                <p>
                                    Copyright © 2019
                                    <a href="#">Lopard</a> All Rights Reserved
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer> --}}

    <!-- all js here -->

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
