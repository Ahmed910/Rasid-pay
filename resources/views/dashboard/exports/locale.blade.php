@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'الترجمات'])
    <tr>
      <th>#</th>
      <th> key </th>
      <th> value</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($locales as $locale)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $locale->key ?? '' }}</td>
      <td>{{ $locale->value ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
