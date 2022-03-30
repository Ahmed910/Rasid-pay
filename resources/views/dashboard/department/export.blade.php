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
    <title>{!! trans('dashboard.general.dashboard') !!} @yield('title')</title>

    <!-- STYLE CSS -->
    <link href="{{ asset('dashboardAssets/css/style.css') }}" rel="stylesheet" />
    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('dashboardAssets/css/icons.css') }}" rel="stylesheet" />

    <style>
        @media screen,
        print {
            * {
                -webkit-print-color-adjust: exact;

            }

            header {
                margin-bottom: 2em;
                background: url("{{ asset('dashboardAssets/images/brand/fot-04.svg') }}") no-repeat;
                background-size: contain;
                min-height: 270px;
                position: relative
            }

            header h3 {
                text-align: left;
                width: 100%;
                font-weight: bold;
                line-height: 1.5em
            }

            header p {
                margin: 0
            }

            header b {
                font-weight: bold
            }

            thead tr th {
                font-weight: bold !important
            }

            table {
                width: 100%
            }

            footer {
                margin-bottom: 2em;
                background: url("{{ asset('dashboardAssets/images/brand/header-05.svg') }}") no-repeat;
                background-size: cover;
                min-height: 350px;
                position: relative
            }

            .table-bordered th,
            .text-wrap table th,
            .table-bordered td,
            .text-wrap table td {
                border: 1px solid #e9edf4;
            }

            table {
                border: none;
            }

            td {
                border-right: 1px solid #e9edf4;
                border-bottom: 1px solid #e9edf4;
            }

            thead tr:first-child th {
                border: none;
                padding: 0 0 0 0.73rem;
                border-width: 0
            }

            thead tr:nth-child(2) th {
                border: none;
                border-right: 1px solid #e9edf4;
                border-bottom: 1px solid #e9edf4;
                border-top: 1px solid #e9edf4;
            }

            thead tr:nth-child(2) th:last-of-type {
                border-left: 1px solid #e9edf4 !important;
            }

            td:last-of-type {
                border-left: 1px solid #e9edf4;
            }
            .active{
                color: #04A777
            }
            .unactive{
            color: #e23e3d
            }
        }
    </style>
</head>

<body class="app sidebar-mini {{ LaravelLocalization::getCurrentLocaleDirection() }}">

    <div class="container">

        <div class="row row-sm">
            <div class="col-lg-12">
                <table id="departmentTable" class="table">
                    <thead>
                        <tr>
                            <th colspan="5" style="border: none;">
                                <header>
                                    <div class="row ">
                                        <div class="col-6 ms-md-auto"
                                            style="transform: translateY(100%);text-align: left;">
                                            <h3>تقرير عن الأقسام
                                            </h3>
                                            <p>تاريخ إنشائها من (20/03/2023) إلى (25/03/2022)</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5 ms-md-auto"
                                            style="position: absolute; left: 0; padding: 0; text-align: left; top: 65%; transform: translateY(100%);">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>رقم المستخدم: </b>256324
                                                </div>
                                                <div class="col-6">
                                                    <b>تاريخ الطباعة: </b>20/03/2022
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </header>
                            </th>

                        </tr>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.department.department')</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.department.main_department')</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.general.created_at')</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.general.status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ @$department->parent->name ?? null }}</td>
                            <td>{{ $department->created_at }}</td>
                            <td>
                                @if($department->is_active)
                                <div class="active">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                    {{ trans('dashboard.general.active_cases.1') }}
                                </div>
                                @else
                                <div class="unactive">
                                    <i class="mdi mdi-cancel"></i>
                                    {{ trans('dashboard.general.active_cases.0') }}
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <footer>
        </footer>
    </div>


</body>

</html>

