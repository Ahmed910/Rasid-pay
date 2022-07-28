@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'أنواع الرسائل'])
    <tr>
      <th>#</th>
      <th> الحالة </th>
      <th> الاسم</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($message_types as $message_type)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $message_type->is_active ?? '' }}</td>
      <td>{{ $message_type->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
