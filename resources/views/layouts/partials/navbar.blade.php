<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between position-relative">
        <!-- Logo -->
        <a href="{{ route('welcome') }}" class="logo d-flex align-items-center text-decoration-none"
            style="margin-left: 30px;">
            <img src="{{ asset('assetslp/img/logo1.png') }}" alt="Logo Ketahanan Pangan" class="me-2"
                style="height: 80px;">
            <div class="d-flex flex-column lh-sm">
                <span class="fw-bold text-dark">Ketahanan</span>
                <span class="text-muted">Pangan</span>
            </div>
        </a>

        <!-- Nav -->
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('welcome') }}" class="active">Dashboard</a></li>

                <li class="dropdown">
                    <a onclick="toggleDropdown(event)">Data Pangan <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">Data Pangan Indonesia</a></li>
                        <li><a href="#">Data Monitoring Harga Pangan</a></li>
                        <li><a href="#">Data Distribusi Pangan</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a onclick="toggleDropdown(event)">Prediksi & Edukasi <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">Prediksi Pangan</a></li>
                        <li><a href="#">Edukasi Gizi & Resep</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a onclick="toggleDropdown(event)">Profil <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </li>
            </ul>
            <i class="mobile-nav-toggle bi bi-list" onclick="toggleMobileMenu()"></i>
        </nav>
    </div>
</header>

<style>
    /* Navbar Style */
    #header.header {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        padding: 10px 0;
        position: sticky;
        top: 0;
        z-index: 999;
    }

    .navmenu ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .navmenu a {
        font-weight: 600;
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }

    .navmenu a:hover,
    .navmenu a.active {
        color: #28a745;
    }

    .dropdown {
        position: relative;
    }

    .dropdown>a {
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .dropdown ul {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        padding: 10px 0;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        z-index: 1000;
        min-width: 220px;
        flex-direction: column;
    }

    .dropdown ul li {
        width: 100%;
    }

    .dropdown ul li a {
        padding: 8px 20px;
        color: #444;
        display: block;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .dropdown ul li a:hover {
        background-color: #f8f9fa;
    }

    .dropdown.show ul {
        display: flex;
    }

    .mobile-nav-toggle {
        display: none;
        font-size: 24px;
        cursor: pointer;
    }

    @media (max-width: 991px) {
        .navmenu ul {
            flex-direction: column;
            background-color: white;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            display: none;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navmenu ul.show {
            display: flex;
        }

        .mobile-nav-toggle {
            display: block;
            color: #333;
        }

        .dropdown ul {
            position: static;
            box-shadow: none;
            padding-left: 20px;
        }

        .dropdown.show ul {
            display: flex;
        }
    }
</style>

<script>
    function toggleMobileMenu() {
        const navList = document.querySelector('.navmenu ul');
        navList.classList.toggle('show');
    }

    function toggleDropdown(event) {
        event.preventDefault();
        const dropdown = event.currentTarget.parentElement;
        dropdown.classList.toggle('show');

        // Close other open dropdowns
        document.querySelectorAll('.dropdown').forEach(d => {
            if (d !== dropdown) d.classList.remove('show');
        });
    }

    // Close dropdowns when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('show'));
        }
    });
</script>
