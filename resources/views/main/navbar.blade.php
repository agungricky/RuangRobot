<div class="navbar-bg "></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav ms-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav ms-auto">
        <li class="dropdown">
            <a href="#" data-bs-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi,
                    @if ($dataLogin)
                        <span>{{ $dataLogin->nama }}</span>
                    @endif
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('edit_profile', ['id'=>$dataLogin->id]) }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Edit Profil Saya
                </a>
                <a href="{{ route('logout') }}"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
