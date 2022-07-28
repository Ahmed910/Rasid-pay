@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'تطبيقاتنا'])
    <tr>
      <th>#</th>
      <th>الحالة</th>
      <th>رابط الاندرويد</th>
      <th>رابط الios</th>
      <th>name</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($ourApps as $our_app)
    <tr>
      <td>{{ $loop->iteration  }}</td>
      <td>{{ $our_app->is_active ?? '' }}</td>
      <td>{{ $our_app->android_link ?? '' }}</td>
      <td>{{ $our_app->ios_link ?? '' }}</td>
      <td>{{ $our_app->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
