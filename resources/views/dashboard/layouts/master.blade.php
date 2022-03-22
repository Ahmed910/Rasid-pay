<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Rasid Jack Dashboard" />
    <meta name="author" content="Spruko Technologies Private Limited" />
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit." />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboardAssets/images/brand/favicon.ico') }}" />

    <!-- TITLE -->
    <title>{!! trans('dashboard.general.dashboard') !!} - @yield('title')</title>

    <!-- BOOTSTRAP CSS -->

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('dashboardAssets') }}/plugins/bootstrap/css/bootstrap{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? '.rtl' : null }}.min.css" />

    <!-- STYLE CSS -->
    <link href="{{ asset('dashboardAssets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet" />
    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('dashboardAssets/css/icons.css') }}" rel="stylesheet" />


    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('dashboardAssets/colors/color1.css') }}" />

    @yield('styles')
</head>

<body class="app sidebar-mini {{ LaravelLocalization::getCurrentLocaleDirection() }}">
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('dashboardAssets/images/loader.gif') }}" class="loader-img" alt="Loader" />
    </div>
    <!-- /GLOBAL-LOADER -->
    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            <!-- app-Header -->
            @include('dashboard.layouts.header')
            <!-- /app-Header -->

            <!--APP-SIDEBAR-->
            @include('dashboard.layouts.side')
            <!--APP-SIDEBAR END-->

            <!--app-content open-->
            @yield('content')
            <!--app-content closed-->
        </div>

        <!-- Modal -->
        @yield('modals')
        <!-- Modal END -->

        <!-- FOOTER -->

        @include('dashboard.layouts.footer')
        <!-- FOOTER END -->
    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- JQUERY JS -->
    <script src="{{ asset('dashboardAssets/js/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('dashboardAssets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- SIDE-MENU JS -->
    <script src="{{ asset('dashboardAssets/plugins/sidemenu/sidemenu.js') }}"></script>

    <!-- DATA TABLE JS-->
    <!-- Sticky js -->
    <script src="{{ asset('dashboardAssets/js/sticky.js') }}"></script>

    <!-- lottie-player js -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@0.4.0/dist/tgs-player.js"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('dashboardAssets/js/custom.js') }}"></script>

    <script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}"></script>



    @yield('scripts')

</body>

</html>
