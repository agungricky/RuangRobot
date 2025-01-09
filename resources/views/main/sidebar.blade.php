<!-- Sidebar outter -->
<div class="main-sidebar">
    <!-- sidebar wrapper -->
    <aside id="sidebar-wrapper">
        <!-- sidebar brand -->
        <div class="sidebar-brand my-3">
            <a href=""><img src="{{ asset('images/ruangrobot.png') }}" alt=""
                    width="150px"></a>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu">
            <!-- menu header -->
            <li class="menu-header">Dashboard</li>
            <!-- menu item -->
            <li>
                <a href="{{ route('dashboard') }}"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <!-- menu header -->
            <li class="menu-header">Manage Pembelajaran</li>
            <!-- Dropdown Menu -->
            <li>
                <a href="{{ route('sekolah') }}"><i class="fa-solid fa-font-awesome"></i><span>Sekolah</span></a>
            </li>
            <li>
                <a href="#kelasMenu" class="nav-link" data-bs-toggle="collapse">
                    <i class="fa-solid fa-book-open"></i><span>Kelas</span>
                </a>
                <div class="collapse ps-4" id="kelasMenu">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('kelas_ekskul') }}" class="nav-link"><i class="fa-solid fa-hotel"></i>Kelas Ekskul</a></li>
                        <li><a href="{{ route('kelas_reguler')}}" class="nav-link"><i class="fa-solid fa-house"></i>Kelas Reguler</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('program_belajar') }}"><i class="fa-solid fa-layer-group"></i><span>Program Belajar</span></a>
            </li>
            <li>
                <a href="#pengguna" class="nav-link" data-bs-toggle="collapse">
                    <i class="fa-solid fa-users"></i><span>Pengguna</span>
                </a>
                <div class="collapse ps-4" id="pengguna">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('admin')}}" class="nav-link"><i class="fa-solid fa-user-tie"></i>Admin</a></li>
                        <li><a href="{{ route('pengajar')}}" class="nav-link"><i class="fa-solid fa-chalkboard-user"></i>Pengajar</a></li>
                        <li><a href="{{ route('siswa')}}" class="nav-link"><i class="fa-solid fa-user"></i>Siswa</a></li>
                    </ul>
                </div>
            </li>
            
            <!-- menu header -->
            <li class="menu-header">Keuangan</li>
            <li>
                <a href="{{ route('gaji')}} "><i class="fas fa-address-book"></i><span>Gaji</span></a>
            </li>
            <!-- menu header -->
            <li class="menu-header">Pembayaran</li>
            <li>
                <a href=""><i class="fas fa-money-bill-alt"></i><span>Pembayaran</span>
                    <div class="badge badge-pill badge-warning text-dark">
                    </div>
                </a>
            </li>
        </ul>
    </aside>
</div>
