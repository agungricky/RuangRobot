<div class="navbar-bg "></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav ms-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav ms-auto">
        <li class="dropdown">
            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi,
                    @if ($dataLogin)
                        <span>{{ $dataLogin->nama }}</span>
                    @endif
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right position-absolute"
                style="right: 10px; top: 40px; left: auto;">
                <a href="{{ route('edit_profile', ['id' => $dataLogin->id]) }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Edit Profil Saya
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger ps-4"
                        style="border: none; background: none; width: 100%; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>

            </div>

        </li>
    </ul>
</nav>
