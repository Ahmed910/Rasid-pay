@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>
        @lang('dashboard.employee.employee')</th>
      <th>
        @lang('dashboard.department.department')</th>
      <th>
        @lang('dashboard.activity_log.main_program')</th>
      <th>
        @lang('dashboard.activity_log.sub_program')</th>
      <th>
        @lang('dashboard.general.created_at')</th>
      <th>
        @lang('dashboard.activity_log.ip_address')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $activity_log)
    <tr>
      <td>{{ $loop->iteration + ($key * $chunk) }}</td>
      <td>{{ $activity_log->user?->fullname ?? trans("dashboard.error.not_found") }}</td>
      <td>{{ $activity_log->user?->department !== null ? $activity_log->user?->department?->name :
        trans('dashboard.department.without_parent') }}</td>
      <td>{{ trans("dashboard." . Str::snake(class_basename($activity_log->auditable_type)) . "." .
        str_plural(Str::snake(class_basename($activity_log->auditable_type)))) }}</td>
      <td>{{ trans("dashboard.sub_progs." . strtolower($activity_log->sub_program))}}</td>
      <td>{{ $activity_log->created_at_date_time }}</td>
      <td>{{ $activity_log->ip_address }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
