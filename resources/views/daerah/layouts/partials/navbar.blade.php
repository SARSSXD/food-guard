<nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="navbar-brand-wrapper">
            <a class="navbar-brand brand-logo" href="{{ route('daerah.dashboard') }}"><img src="{{ asset('assets/images/foodguard-logo.svg') }}" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('daerah.dashboard') }}"><img src="{{ asset('assets/images/foodguard-logo-mini.svg') }}" alt="logo"/></a>
        </div>
        <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">Selamat datang, {{ auth()->user()->name }}</h4>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
                <h4 class="mb-0 font-weight-bold d-none d-xl-block">{{ now()->format('d M Y') }}</h4>
            </li>
            <li class="nav-item dropdown me-1">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="mdi mdi-bell mx-0"></i>
                    <span class="count bg-info">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Pemberitahuan</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="mdi mdi-alert mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Peringatan Dini</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">Stok beras menipis</p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center">
        <ul class="navbar-nav me-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Data..." aria-label="search" aria-describedby="search">
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                    <img src="{{ asset('assets/images/faces/face5.jpg') }}" alt="profile"/>
                    <span class="nav-profile-name">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-settings text-primary"></i>
                        Pengaturan
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>