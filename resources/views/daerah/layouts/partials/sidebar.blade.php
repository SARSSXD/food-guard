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
            <p>Manajemen</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.produksi.index') }}">
                <i class="mdi mdi-sprout menu-icon"></i>
                <span class="menu-title">Produksi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.cadangan.index') }}">
                <i class="mdi mdi-warehouse menu-icon"></i>
                <span class="menu-title">Cadangan Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.harga.index') }}">
                <i class="mdi mdi-currency-usd menu-icon"></i>
                <span class="menu-title">Harga Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.distribusi.index') }}">
                <i class="mdi mdi-truck menu-icon"></i>
                <span class="menu-title">Distribusi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.prediksi.index') }}">
                <i class="mdi mdi-chart-line menu-icon"></i>
                <span class="menu-title">Prediksi Produksi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('daerah.artikel.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Artikel Gizi</span>
            </a>
        </li>
    </ul>
</nav>
