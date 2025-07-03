<!-- Sidebar outter -->
<div class="main-sidebar">
    <aside id="sidebar-wrapper" class="h-100 overflow-auto pb-3">
        <!-- sidebar brand -->
        <div class="sidebar-brand my-3">
            <a href=""><img src="{{ asset('images/ruangrobot.png') }}" alt="" width="150px"></a>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu">
            <!-- menu header -->
            @if ($dataLogin->role == 'Admin')
                <li class="menu-header">Dashboard</li>
                <!-- menu item -->
                <li>
                    <a href="{{ route('dashboard') }}"><i class="fa-solid fa-fire"></i><span>Dashboard</span></a>
                </li>

                <li class="menu-header">Administrasi</li>
                <li>
                    <a href="{{ route('pendaftaran.index') }}">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Pendaftaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('validasi.index') }}">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi</span>
                    </a>
                </li>

                <!-- menu header -->
                <li class="menu-header">Manage Pembelajaran</li>

                <!-- Dropdown Menu -->
                <li>
                    <a href="#kategori_menu" class="nav-link" data-bs-toggle="collapse">
                        <i class="fa-solid fa-list"></i><span>Kategori</span>
                    </a>
                    <div class="collapse ps-4" id="kategori_menu">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('tipe_kelas') }}" class="nav-link"><i
                                        class="fa-solid fa-minus"></i>Tipe Kelas</a></li>
                            <li><a href="{{ route('kategori_kelas') }}" class="nav-link"><i
                                        class="fa-solid fa-minus"></i>Kategory Kelas</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('sekolah') }}"><i class="fa-solid fa-font-awesome"></i><span>Sekolah</span></a>
                </li>
                <li>
                    <a href="#kelas" class="nav-link" data-bs-toggle="collapse">
                        <i class="fa-solid fa-book-open"></i><span>Kelas</span>
                    </a>
                    <div class="collapse ps-4" id="kelas">
                        <ul class="list-unstyled">
                            @foreach ($kategori as $item)
                                <li><a href="{{ route('kelas', ['id' => $item->id]) }}" class="nav-link"><i
                                            class="fa-solid fa-minus"></i>{{ $item->kategori_kelas }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('program_belajar') }}"><i class="fa-solid fa-layer-group"></i><span>Program
                            Belajar</span></a>
                </li>
                <li>
                    <a href="{{ route('generate.show') }}"><i class="fa-solid fa-note-sticky"></i><span>Sertif
                            Custom</span></a>
                </li>
                <li>
                    <a href="#pengguna" class="nav-link" data-bs-toggle="collapse">
                        <i class="fa-solid fa-users"></i><span>Pengguna</span>
                    </a>
                    <div class="collapse ps-4" id="pengguna">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('pengguna', ['id' => 'Admin']) }}" class="nav-link"><i
                                        class="fa-solid fa-user-tie"></i>Admin</a></li>
                            <li><a href="{{ route('pengguna', ['id' => 'Pengajar']) }}" class="nav-link"><i
                                        class="fa-solid fa-chalkboard-user"></i>Pengajar</a></li>
                            <li><a href="{{ route('pengguna', ['id' => 'Siswa']) }}" class="nav-link"><i
                                        class="fa-solid fa-user"></i>Siswa</a></li>
                        </ul>
                    </div>
                </li>

                <!-- menu header -->
                <li class="menu-header">Keuangan</li>
                <li>
                    <a href="#gaji-riwayat" class="nav-link" data-bs-toggle="collapse">
                        <i class="fa-solid fa-money-bill-wave"></i> <span>Gaji & Riwayat</span>
                    </a>
                    <div class="collapse ps-4" id="gaji-riwayat">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('gaji') }}" class="nav-link">
                                    <i class="fa-solid fa-wallet"></i> Gaji</a>
                            </li>
                            <li>
                                <a href="{{ route('histori_gaji') }}" class="nav-link">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Gaji</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- menu header -->
                <li class="menu-header">Pembayaran</li>
                <li>
                    <a href="{{ route('pembayaran') }}"><i
                            class="fa-solid fa-money-bill-alt"></i><span>Pembayaran</span>
                        {{-- <div class="badge badge-pill badge-warning text-dark">
                        </div> --}}
                    </a>
                </li>
            @endif


            {{-- ===================================================== --}}
            <!------------------ menu dashboard Pengajar ----------------->
            {{-- ===================================================== --}}

            @if ($dataLogin->role == 'Pengajar')
                <li class="menu-header">Dashboard</li>
                <li>
                    <a href="{{ url('/dashboard/pengajar') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Manage Kelas</li>
                {{-- <li>
                    <a href="{{ url('/kelas_pengajar') }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Kelas Aktif</span>
                    </a>
                </li> --}}
                <li>
                    <a href="#kelas" class="nav-link" data-bs-toggle="collapse">
                        <i class="fas fa-chalkboard-teacher"></i><span>Kelas Aktif</span>
                    </a>
                    <div class="collapse ps-4" id="kelas">
                        <ul class="list-unstyled">
                            @foreach ($kategori as $item)
                                <li><a href="{{ route('kelas_aktif.pengajar', ['id' => $item->id]) }}"
                                        class="nav-link"><i
                                            class="fa-solid fa-minus"></i>{{ $item->kategori_kelas }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('kelas_selesai.pengajar') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Kelas Selesai</span>
                    </a>
                </li>

                <li class="menu-header">Gaji</li>
                <li>
                    <a href="{{ route('gaji.pengajar', ['id' => $dataLogin->id]) }}"><i class="fas fa-wallet"></i>
                        <span>Gaji</span></a>
                </li>
                <li>
                    <a href="{{ route('riwayatgaji.pengajar', ['id' => $dataLogin->id]) }}"><i
                            class="fas fa-file-invoice-dollar"></i> <span>Riwayat
                            Gaji</span></a>
                </li>
            @endif

            {{-- ===================================================== --}}
            <!------------------ menu dashboard Siswa----- --------------->
            {{-- ===================================================== --}}

            @if ($dataLogin->role == 'Siswa')
                <li class="menu-header">Dashboard</li>
                <li>
                    <a href="{{ url('/dashboard/siswa') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Manage Kelas</li>
                <li>
                    <a href="{{ route('siswa.kelas.json', ['id' => $dataLogin->id]) }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Kelas Saya</span>
                    </a>
                </li>
                <li class="menu-header">Pembayaran Kelas</li>
                <li>
                    <a href="{{ route('pembayaran.siswa', ['id' => $dataLogin->id]) }}">
                        <i class="fas fa-receipt"></i>
                        <span>Pembayaran</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>
