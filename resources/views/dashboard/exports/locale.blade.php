@extends('dashboard.exports.layout')

@section('content')
@include('dashboard.exports.header',['topic'=>trans('dashboard.localization.localizations'), 'count' => 1])

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th> @lang('dashboard.localization.value')</th>
      <th> @lang('dashboard.localization.key') </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($locales as $locale)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $locale->value ?? '' }}</td>
      <td>{{ $locale->key ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
