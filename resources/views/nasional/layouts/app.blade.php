<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Guard - Admin Nasional</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Hapus referensi ke vendor.bundle.base.css jika tidak ada -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" onerror="console.log('style.css not found')">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" onerror="console.log('custom.css not found')">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoFG.jpg') }}" onerror="console.log('logoFG.jpg not found')">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body>
    <div class="container-scroller d-flex">
        @include('nasional.layouts.partials.sidebar')
        <div class="container-fluid page-body-wrapper">
            @include('nasional.layouts.partials.navbar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                @include('nasional.layouts.partials.footer')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Tambahkan error handling untuk file yang tidak ada -->
    <script src="{{ asset('assets/js/off-canvas.js') }}" onerror="console.log('off-canvas.js not found')"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}" onerror="console.log('hoverable-collapse.js not found')"></script>
    <script src="{{ asset('assets/js/template.js') }}" onerror="console.log('template.js not found')"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}" onerror="console.log('dashboard.js not found')"></script>
    <script src="{{ asset('assets/js/navbar-scroll.js') }}" onerror="console.log('navbar-scroll.js not found')"></script>
    @yield('scripts')
</body>
</html>