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
            <a class="nav-link" href="{{ route('nasional.prediksi.index') }}" data-bs-toggle="tooltip"
                data-bs-placement="right">
                <i class="mdi mdi-chart-line menu-icon"></i>
                <span class="menu-title">Prediksi & Stok</span>
                {{-- @if ($pendingProduksiCount > 0 || $pendingPrediksiPangan > 0)
                    <span class="badge badge-warning">
                        {{ $pendingProduksiCount + $pendingPrediksiPangan }}
                    </span>
                @endif --}}
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>