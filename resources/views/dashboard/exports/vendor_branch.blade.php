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
      <td>{{ (bool) $vendor->is_active ?? '' }}</td>
      <td>{{ $vendor->email ?? '' }}</td>
      <td>{{ $vendor->phone ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection