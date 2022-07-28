@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'العملاء'])
    <tr>
      <th>#</th>
      <th>عدد الفروع</th>
      <th>اسم الفرع</th>
      <th>نوع الفرع</th>
      <th>السجل التجاري</th>
      <th>الرقم الضريبي</th>
      <th>الحالة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendors as $vendor)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $vendor->branches_count ?? '' }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ $vendor->type ?? '' }}</td>
      <td>{{ $vendor->commercial_record ?? '' }}</td>
      <td>{{ $vendor->tax_number ?? '' }}</td>
      <td>{{ $vendor->is_active ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
