<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nasional User</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}">
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
    <script src="{{ asset('/assets/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('/assets/js/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('/assets/js/template.js') }}"></script>
    <script src="{{ asset('/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('/assets/js/navbar-scroll.js') }}"></script>
</body>
</html>