<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item sidebar-category">
            <p>Navigasi</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('welcome') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Informasi Pangan</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/produksi') }}">
                <i class="mdi mdi-sprout menu-icon"></i>
                <span class="menu-title">Produksi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/cadangan') }}">
                <i class="mdi mdi-warehouse menu-icon"></i>
                <span class="menu-title">Cadangan Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/harga') }}">
                <i class="mdi mdi-currency-usd menu-icon"></i>
                <span class="menu-title">Harga Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/distribusi') }}">
                <i class="mdi mdi-truck menu-icon"></i>
                <span class="menu-title">Distribusi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/bantuan') }}">
                <i class="mdi mdi-hand-okay menu-icon"></i>
                <span class="menu-title">Bantuan/Subsidi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/edukasi') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Edukasi Gizi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/penyuluhan') }}">
                <i class="mdi mdi-school menu-icon"></i>
                <span class="menu-title">Penyuluhan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/early-warning') }}">
                <i class="mdi mdi-alert menu-icon"></i>
                <span class="menu-title">Peringatan Dini</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/laporan') }}">
                <i class="mdi mdi-message-text menu-icon"></i>
                <span class="menu-title">Laporan</span>
            </a>
        </li>
    </ul>
</nav>
