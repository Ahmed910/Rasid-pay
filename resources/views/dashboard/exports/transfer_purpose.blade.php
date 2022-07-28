@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'أغراض الحوالة'])
    <tr>
      <th>#</th>
      <th>الحالة</th>
      <th>is_default_value</th>
      <th>الاسم</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transfer_purposes as $transfer)
    <tr>
      <td>{{ $loop->iteration  }}</td>
      <td>{{ (bool) $transfer->is_active ?? '' }}</td>
      <td>{{ $transfer->is_default_value ?? '' }}</td>
      <td>{{ $transfer->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
