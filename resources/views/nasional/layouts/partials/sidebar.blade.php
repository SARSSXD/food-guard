<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item sidebar-category">
            <p>Navigasi</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Manajemen</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.produksi.index') }}">
                <i class="mdi mdi-sprout menu-icon"></i>
                <span class="menu-title">Produksi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.cadangan.index') }}">
                <i class="mdi mdi-warehouse menu-icon"></i>
                <span class="menu-title">Cadangan Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.harga.index') }}">
                <i class="mdi mdi-currency-usd menu-icon"></i>
                <span class="menu-title">Harga Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.distribusi.index') }}">
                <i class="mdi mdi-truck menu-icon"></i>
                <span class="menu-title">Distribusi Pangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.prediksi.index') }}">
                <i class="mdi mdi-chart-line menu-icon"></i>
                <span class="menu-title">Prediksi & Stok</span>
                @if($pendingPrediksiPangan > 0 || $pendingProduksiCount > 0)
                    <span class="badge badge-warning">
                        {{ $pendingPrediksiPangan + $pendingProduksiCount }}
                    </span>
                @endif
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('nasional.artikel.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Artikel Gizi</span>
            </a>
        </li> --}}
    </ul>
</nav>