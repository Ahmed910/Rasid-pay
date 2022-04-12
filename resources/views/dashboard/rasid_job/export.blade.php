<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Rasid Jack Dashboard" />
    <meta name="author" content="Spruko Technologies Private Limited" />
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit." />
    <style>
        @media screen,
        print {
            @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap');

            * {
                -webkit-print-color-adjust: exact;
            }

            body {
                font-family: 'Cairo', sans-serif;
            }

            header {
                margin-bottom: 2em;
                background: url('https://jackapi.fintechrsa.com/dashboardAssets/images/brand/fot-04.svg') no-repeat;
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

            tbody {
                margin-bottom: 2em;
                background: url(https://jackapi.fintechrsa.com/dashboardAssets/images/brand/header-05.svg) no-repeat;
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

            .active {
                color: #04A777
            }

            .unactive {
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
                        <tr style="background-image: url('https://jackapi.fintechrsa.com/dashboardAssets/images/brand/fot-04.svg') ;background-repeat:no-repeat;  background-size: cover;">
                            <th colspan="6" style="border: none;">
                                <header>
                                    <div class="row ">
                                        <div class="col-6 ms-md-auto"
                                            style="transform: translateY(100%);text-align: left;">
                                            <h3 style="font-family: 'Cairo', sans-serif;">تقرير عن الأقسام
                                            </h3><br>
                                            <p>تاريخ إنشائها من (20/03/2023) إلى (25/03/2022)</p>
                                            <br>
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
                                            <br><br>
                                        </div>
                                    </div>
                                </header>
                            </th>

                        </tr>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">
                                {{ trans('dashboard.rasid_job.job_name') }}</th>
                            <th class="border-bottom-0">
                                {{ trans('dashboard.department.department') }}</th>
                            <th class="border-bottom-0">
                                {{ trans('dashboard.general.created_at') }}</th>
                            <th class="border-bottom-0">
                                {{ trans('dashboard.general.status') }}</th>
                            <th class="border-bottom-0">
                                {{ trans('dashboard.general.type') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $job->name }}</td>
                            <td>{{ $job->department->name }}</td>
                            <td>{{ $job->created_at }}</td>
                            <td>
                                @if ($job->is_active)
                                <div class="active">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                    {{ trans('dashboard.general.active_cases.' . $job->is_active) }}
                                </div>
                                @else
                                <div class="unactive">
                                    <i class="mdi mdi-cancel"></i>
                                    {{ trans('dashboard.general.active_cases.' . $job->is_active) }}
                                </div>
                                @endif
                            </td>

                            <td>{{ trans('dashboard.general.job_type_cases.' . $job->is_vacant) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</body>

</html>