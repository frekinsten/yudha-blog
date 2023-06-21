<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Web Blog">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Dwi Robbi">
    <meta name="generator" content="Blog v1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front-src/images/favicon.png') }}" />

    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('assets/front-src/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- Ionic Icon Css -->
    <link rel="stylesheet" href="{{ asset('assets/front-src/plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset('assets/front-src/plugins/animate-css/animate.css') }}">
    <!-- Magnify Popup -->
    <link rel="stylesheet" href="{{ asset('assets/front-src/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front-src/plugins/slick/slick.css') }}">
    <!-- Sweet Alert 2 -->
    <link rel="stylesheet"
        href="{{ asset('assets/back-src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/front-src/css/style.css') }}">
</head>

<body id="body">

    <!-- Header Start -->
    @include('layouts.front-core.partials.header')
    @include('auth._login-register')
    <!-- header close -->

    @yield('content')

    <!-- Footer Start -->
    @include('layouts.front-core.partials.footer')
    <!-- footer close -->

    <!--Scroll to top-->
    <div id="scroll-to-top" class="scroll-to-top">
        <span class="icon ion-ios-arrow-up"></span>
    </div>

    <!-- Main jQuery -->
    <script src="{{ asset('assets/front-src/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{ asset('assets/front-src/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!-- slick Carousel -->
    <script src="{{ asset('assets/front-src/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/front-src/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- filter -->
    <script src="{{ asset('assets/front-src/plugins/shuffle/shuffle.min.js') }}"></script>
    <script src="{{ asset('assets/front-src/plugins/SyoTimer/jquery.syotimer.min.js') }}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places">
    </script>
    <script src="{{ asset('assets/front-src/plugins/google-map/map.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/back-src/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Main scripts -->
    <script src="{{ asset('assets/front-src/js/script.js') }}"></script>

    <script>
        const Confirm = Swal.mixin({
            showDenyButton: true,
            confirmButtonColor: '#3085d6',
            denyButtonColor: '#d33',
            denyButtonText: 'Batal',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
            customClass: {
                denyButton: 'order-1',
                confirmButton: 'order-2',
            },
        });
    </script>

    @stack('scripts')
</body>

</html>
