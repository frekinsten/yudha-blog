<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/back-src/img/icon.ico') }}" type="image/x-icon" />
    <title>{{ config('app.name') }}</title>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/back-src/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('assets/back-src/css/fonts.min.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/back-src/css/bootstrap.min.css') }}">

    <!-- Sweet Alert 2 -->
    <link rel="stylesheet"
        href="{{ asset('assets/back-src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/back-src/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/back-src/css/atlantis.min.css') }}">

    <!-- Specific styles on page -->
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Header -->
        @include('layouts.back-core.partials.header')
        <!-- End Header -->

        <!-- Sidebar -->
        @include('layouts.back-core.partials.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                @yield('content')
            </div>

            <!-- Footer -->
            @include('layouts.back-core.partials.footer')
            <!-- End Footer -->
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/back-src/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/back-src/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/back-src/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/back-src/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/back-src/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/back-src/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/back-src/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/back-src/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/back-src/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/back-src/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/back-src/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('assets/back-src/js/atlantis.min.js') }}"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>

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
