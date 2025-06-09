<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ketahanan Pangan</title>

    <!-- Favicon -->
    <link href="{{ asset('/assetslp/img/logo1.png') }}" rel="icon">
    <link href="{{ asset('/assetslp/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Marcellus&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('/assetslp/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assetslp/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/assetslp/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('/assetslp/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assetslp/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous">

    <!-- Main CSS -->
    <link href="{{ asset('/assetslp/css/main.css') }}" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="index-page">
    @include('user.layouts.partials.navbar')

    <main class="main">
        @yield('content')
    </main>

    @include('user.layouts.partials.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('/assetslp/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assetslp/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('/assetslp/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('/assetslp/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('/assetslp/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('/assetslp/js/main.js') }}"></script>

    <!-- AOS Initialization -->
    <script>
        AOS.init();
    </script>
</body>

</html>
