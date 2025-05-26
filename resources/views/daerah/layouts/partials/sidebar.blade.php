<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item sidebar-category">
            <p>Navigasi</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Input Data</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/produksi') }}">
                <i class="mdi mdi-sprout menu-icon"></i>
                <span class="menu-title">Produksi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/cadangan') }}">
                <i class="mdi mdi-warehouse menu-icon"></i>
                <span class="menu-title">Cadangan Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/harga') }}">
                <i class="mdi mdi-currency-usd menu-icon"></i>
                <span class="menu-title">Harga Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/distribusi') }}">
                <i class="mdi mdi-truck menu-icon"></i>
                <span class="menu-title">Distribusi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/bantuan') }}">
                <i class="mdi mdi-hand-okay menu-icon"></i>
                <span class="menu-title">Bantuan/Subsidi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/penyuluhan') }}">
                <i class="mdi mdi-school menu-icon"></i>
                <span class="menu-title">Penyuluhan</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Manajemen</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/prediksi') }}">
                <i class="mdi mdi-chart-line menu-icon"></i>
                <span class="menu-title">Prediksi Produksi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/early-warning') }}">
                <i class="mdi mdi-alert menu-icon"></i>
                <span class="menu-title">Peringatan Dini</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('daerah/laporan') }}">
                <i class="mdi mdi-message-text menu-icon"></i>
                <span class="menu-title">Laporan Masyarakat</span>
            </a>
        </li>
    </ul>
</nav>
