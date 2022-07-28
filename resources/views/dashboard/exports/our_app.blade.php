@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'تطبيقاتنا'])
    <tr>
      <th>#</th>
      <th>is_active</th>
      <th>android_link</th>
      <th>ios_link</th>
      <th>name</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($our_apps as $our_app)
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
