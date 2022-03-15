<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Rasid Jack Dashboard" />
    <meta name="author" content="Spruko Technologies Private Limited" />
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit." />

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboardAssets/images/brand/favicon.ico') }}" />

    <!-- TITLE -->
    <title>Rasid Jack Dashboard - @yield('title')</title>

    <!-- BOOTSTRAP CSS -->

    <link id="style" href="{{ asset('dashboardAssets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('dashboardAssets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('dashboardAssets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('dashboardAssets/colors/color1.css') }}" />

    @yield('styles')
</head>

<body class="app sidebar-mini rtl">
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

    <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>

    <!-- Sticky js -->
    <script src="{{ asset('dashboardAssets/js/sticky.js') }}"></script>

    <!-- lottie-player js -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@0.4.0/dist/tgs-player.js"></script>

    <!-- INTERNAL Bootstrap-Datepicker js-->
    <!-- <script src="{{ asset('dashboardAssets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script> -->

    <!-- SELECT2 JS -->
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('dashboardAssets/js/custom.js') }}"></script>

    @yield('scripts')

</body>

</html>
