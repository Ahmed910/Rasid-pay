@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.our_app.name')</th>
      <th>@lang('dashboard.general.created_at')</th>
      <th>@lang('dashboard.our_app.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $our_app)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $our_app->name ?? '' }}</td>
      <td>{{ $our_app->created_at_date ?? '' }}</td>
      <td>
        @if($our_app->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.our_app.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.our_app.active_cases.0') }}
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
