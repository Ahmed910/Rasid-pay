@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'فروع العملاء'])
    <tr>
      <th>#</th>
      <th>الاسم</th>
      <th>lat</th>
      <th>lng</th>
      <th>العنوان</th>
      <th>تفاصيل العنوان</th>
      <th>الحالة</th>
      <th>البريد الالكتروني</th>
      <th>الهاتف</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendorbranches as $vendor)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ $vendor->lat ?? '' }}</td>
      <td>{{ $vendor->lng ?? '' }}</td>
      <td>{{ $vendor->location ?? '' }}</td>
      <td>{{ $vendor->address_details ?? '' }}</td>
      <td>
        @if($vendor->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.vendor_branch.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.vendor_branch.active_cases.0') }}
        </div>
        @endif
      </td>
      <td>{{ $vendor->email ?? '' }}</td>
      <td>{{ $vendor->phone ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
