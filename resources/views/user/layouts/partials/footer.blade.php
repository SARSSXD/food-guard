<footer id="footer" class="footer bg-dark text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center">
                <a href="{{ route('landingpage') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('assetslp/img/logo1.png') }}" alt="Logo Ketahanan Pangan" class="me-2"
                        style="height: 60px;">
                    <div class="d-flex flex-column lh-sm">
                        <span class="fw-bold">Ketahanan</span>
                        <span>Pangan</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 text-center">
                <p class="mb-0">&copy; 2025 Ketahanan Pangan. All Rights Reserved.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <ul class="list-unstyled d-flex justify-content-md-end mb-0">
                    <li><a href="{{ route('landingpage') }}" class="text-white mx-2">Dashboard</a></li>
                    <li><a href="{{ route('register') }}" class="text-white mx-2">Register</a></li>
                    <li><a href="{{ route('login') }}" class="text-white mx-2">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
