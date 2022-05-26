<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
  <style>
    @media screen,print {
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

      table th,
      table th,
      table td,
      table td {
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

<body>

  <table>
    <thead>
      <tr>
        <th colspan="5" style="border: none;">
          <header>
            <div style="transform: translateY(100%);text-align: left;">
              <h3>تقرير عن الأقسام
              </h3>
              <p>تاريخ إنشائها من (20/03/2023) إلى (25/03/2022)</p>
            </div>
            <div style="position: absolute; left: 0; padding: 0; text-align: left; top: 65%; transform: translateY(100%);">
              <div class="col-6">
                <b>رقم المستخدم: </b>256324
              </div>
              <div class="col-6">
                <b>تاريخ الطباعة: </b>20/03/2022
              </div>
            </div>
          </header>
        </th>
      </tr>
      <tr>
        <th>#</th>
        <th>
          @lang('dashboard.department.department')
        </th>
        <th>
          @lang('dashboard.department.main_department')
        </th>
        <th>
          @lang('dashboard.general.created_at')
        </th>
        <th>
          @lang('dashboard.general.status')
        </th>
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
          {{ trans('dashboard.general.active_cases.'.$department->is_active) }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <footer></footer>
</body>

</html>
