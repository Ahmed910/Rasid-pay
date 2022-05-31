<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
  <!-- META DATA -->
  <meta charset="UTF-8" />
  <style>
    @media screen,
    print {
      * {
        -webkit-print-color-adjust: exact;
        font-family: "cairo", Times, serif;
      }
body{

}
      table {
        font-family: 'cairo', sans-serif;
        width: 100%;
      }
h3{
  font-weight: bold
}
      table th {
        text-align: right !important;
        padding: 15px
      }

      .active {
        color: #04A777
      }

      .unactive {
        color: #e23e3d
      }

      table {
        border-collapse: collapse;
      }

      table th {
        border: 1px solid #f3f3f3 !important;
      }

      table td {
        padding: 15px
      }
.header{
  width: 100%;
  position: relative;
}
      .logo {
        width: 10px;
      }
img{
  border-radius: 10px !important
}
      .title {
        width: 50%;
        display: block;
        float: left;
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
              <th colspan="2" style="background: #014a83; padding-right: 1em; padding-left: 1em; text-align: center">
                
                    <img src="{{ public_path('dashboardAssets/images/brand/logoPay.png') }}" width="150" style="margin: auto" alt="">
                
              </th>
<th colspan="3">
     <h3>تقرير عن الأقسام
      </h3>
      <br>
      <p>تاريخ إنشائها من (20/03/2023) إلى (25/03/2022)</p>
      <br>
      <p>رقم المستخدم: 256324</p>
      <br>
      <p>تاريخ الطباعة: 20/03/2022</p>
      <br>
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