@extends('dashboard.exports.layout')

@section('content')


<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th> @lang('dashboard.localization.value')</th>
      <th> @lang('dashboard.localization.key') </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $locale)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $locale->value ?? '' }}</td>
      <td>{{ $locale->key ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
