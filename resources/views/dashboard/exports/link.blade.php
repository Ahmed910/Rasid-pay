links
@extends('dashboard.exports.layout')

@section('content')
@include('dashboard.exports.header',['topic'=>trans('dashboard.link.links'), 'count' => 1])

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th> key </th>
      <th> value</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($links as $link)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $link->key ?? '' }}</td>
      <td>{{ trans('dashboard.links.'.$link->key) ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
