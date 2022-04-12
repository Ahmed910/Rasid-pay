<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <!-- META DATA -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Rasid Jack Dashboard" />
    <meta name="author" content="Spruko Technologies Private Limited" />
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit." />

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboardAssets') }}/images/brand/favicon.ico" />

    <!-- TITLE -->
    {{-- <title>@yield('title' , trans('dashboard.general.dashboard',['title' => $title ?? '']))</title> --}}

    @yield('styles')
    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('dashboardAssets') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('dashboardAssets') }}/css/style.css" rel="stylesheet" />
    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('dashboardAssets') }}/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{ asset('dashboardAssets') }}/colors/color1.css" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>

<body class="app sidebar-mini {{ LaravelLocalization::getCurrentLocaleDirection() }}">
    <!-- GLOABAL LOADER -->
    <div id="global-loader">
        <img src="{{ asset('dashboardAssets') }}/images/loader.gif" class="loader-img" alt="Loader" />
    </div>
    @include('dashboard.layouts.modals.alert')
    <!-- /GLOABAL LOADER -->

    <!-- PAGE -->
    <div class="page">
        <!-- CONTAINER OPEN -->
        <div class="row no-gutters">
            <div class="col-12 col-md-5">
                <div class="auth_vector d-flex align-center">
                    <lottie-player autoplay loop mode="normal"
                        src="{{ asset('dashboardAssets') }}/images/lottie/login.json"
                        style="display: block; margin: auto">
                    </lottie-player>
                </div>
            </div>
            <div class="col-12 col-md-7 d-flex align-center">
                <div class="card m-auto w-60 p-9">
                    <img src="{{ asset('dashboardAssets') }}/images/brand/Rasid-Jack-Logo-V.svg" width="150" alt=""
                        class="mb-5" />
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- CONTAINER CLOSED -->
    </div>
    <!-- End PAGE -->

    <!-- JQUERY JS -->
    <script src="{{ asset('dashboardAssets/js/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('dashboardAssets') }}/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- FORMVALIDATION JS -->
    <script src="{{ asset('dashboardAssets') }}/js/form-validation.js"></script>

    <!-- lottie-player js -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@0.4.0/dist/tgs-player.js"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('dashboardAssets') }}/js/custom.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @yield('toast')
    {{-- @yield('notify') --}}
    @yield('scripts')
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on("click", function(event) {
                event.preventDefault();
                if ($("#show_hide_password input").attr("type") == "text") {
                    $("#show_hide_password input").attr("type", "password");
                    $("#show_hide_password i").addClass("mdi-eye-off-outline");
                    $("#show_hide_password i").removeClass("mdi-eye-outline");
                } else if (
                    $("#show_hide_password input").attr("type") == "password"
                ) {
                    $("#show_hide_password input").attr("type", "text");
                    $("#show_hide_password i").removeClass("mdi-eye-off-outline");
                    $("#show_hide_password i").addClass("mdi-eye-outline");
                }
            });

        });


        function submitForm(formId) {


            let form = $(formId)[0];
            let data = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $(formId).attr('action'),
                type: $(formId).attr('method'),
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function(data) {
                    $(formId).submit();
                },
                error: function(data) {
                    $.each(data.responseJSON.errors, function(name, message) {
                        $('input[name="' + name + '"]').addClass('is-invalid');
                        $('select[name="' + name + '"]').addClass('is-invalid');
                        $('#' + name + '_error').html(`<small>${message}</small>`);

                        toastr.error(message);
                    });
                    // if (data.responseJSON.message) toastr.error("{{ trans('auth.failed') }}");
                }
            })
        }
    </script>
</body>

</html>
