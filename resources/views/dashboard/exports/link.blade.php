links
@extends('dashboard.exports.layout')

@section('content')


<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th> key </th>
      <th> value</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $link)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $link->key ?? '' }}</td>
      <td>{{ trans('dashboard.links.'.$link->key) ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
