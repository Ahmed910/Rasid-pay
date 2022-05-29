<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
  <!-- META DATA -->
  <meta charset="UTF-8" />
  <style>
    @media screen,
    print {
      /* @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap'); */
      * {
        -webkit-print-color-adjust: exact;
          font-family: "cairo", Times, serif;
      }

      .header {
        margin-bottom: 2em;
        background: url("{{ asset('dashboardAssets/images/brand/fot-04.svg') }}") no-repeat;
        background-size: contain;
        min-height: 270px;
        position: relative
      }

      .header h3 {
        text-align: left;
        width: 100%;
        font-weight: bold;
        line-height: 1.5em
      }

      .header p {
        margin: 0
      }

      .header b {
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
        border: 1px solid #000;
      }

      table {
        border: none;
      }

      td {
        border-right: 1px solid #e9edf4;
        border-bottom: 1px solid #e9edf4;
        text-align: center;
      }

      thead tr:first-child th {
        border: none;
        padding: 0 0 0 0.73rem;
        border-width: 0
      }

      thead tr:nth-child(2) th {
        border: none;
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
      }

      thead tr:nth-child(2) th:last-of-type {
        border-left: 1px solid #000 !important;
      }

      td:last-of-type {
        border-left: 1px solid #000;
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

<body class="app sidebar-mini {{ LaravelLocalization::getCurrentLocaleDirection() }}" style="font-family:cairo !important">
  <div class="container">
    <div class="row row-sm">
      <div class="col-lg-12">
        <table id="departmentTable" class="table">
          <thead>
            <tr>
              <th colspan="5">
                <div class="header">
                  <div class="row ">
                    <div class="col-6 ms-md-auto" style="transform: translateY(100%);text-align: left;">
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
                </div>
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


</body>

</html>
