@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'أنواع الرسائل'])
    <tr>
      <th>#</th>
      <th> الحالة </th>
      <th> الاسم</th>
      <th>عدد الموظفين</th>
      <th>تاريخ الإضافة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($messageTypes as $message_type)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ (bool) $message_type->is_active ?? '' }}</td>
      <td>{{ $message_type->name ?? '' }}</td>
      <td>{{ $message_type->admins_count ?? '' }}</td>
      <td>{{ $message_type->created_at ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
