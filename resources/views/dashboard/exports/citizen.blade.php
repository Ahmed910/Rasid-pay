citizens

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
      <td>{{ $citizen?->user?->ban_status }}</td>
      <td>{{ trans('dashboard.package_types.'. $citizen?->enabledPackage?->package_type) }}</td>
      <td>{{ $citizen?->enabledPackage?->start_at_dashboard }}</td>
      <td>{{ $citizen?->enabledPackage?->end_at_dashboard }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
