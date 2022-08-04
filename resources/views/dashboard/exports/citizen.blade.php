

@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'مستخدمي التطبيق'])
    <tr>
      <th>#</th>
      <th>الاسم</th>
      <th>رقم الهوية</th>
      <th>الحالة</th>
      <th>البطاقة المفعلة</th>
      <th>تاريخ التسجيل</th>
      <th>تاريخ انتهاء البطاقة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($citizens as $citizen)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $citizen?->user?->fullname }}</td>
      <td>{{ $citizen?->user?->identity_number }}</td>
      @php
                $ban_status = match ($citizen?->user?->ban_status) {
                'active' => trans('dashboard.admin.active_cases.active'),
                'permanent' => trans('dashboard.admin.active_cases.permanent'),
                'temporary' => trans('dashboard.admin.active_cases.temporary'),
                }
      @endphp

      <td>
        @if($citizen?->user?->ban_status == 'active')
                  <div class="active">
                    <i class="mdi mdi-check-circle-outline"></i>
                    {{ $ban_status }}
                  </div>
                  @else
                  <div class="unactive">
                    <i class="mdi mdi-cancel"></i>
                    {{ $ban_status }}
                  </div>
        @endif
      </td>
      <td>{{ trans('dashboard.package_types.'. $citizen?->enabledPackage?->package_type) }}</td>
      <td>{{ $citizen?->enabledPackage?->start_at_dashboard }}</td>
      <td>{{ $citizen?->enabledPackage?->end_at_dashboard }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
