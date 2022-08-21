@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>

    <tr>
      <th class="border-bottom-0">#</th>
      <th class="border-bottom-0">
        @lang('dashboard.department.department_name')</th>
      <th class="border-bottom-0">
        @lang('dashboard.department.main_department')</th>
      <th class="border-bottom-0">
        @lang('dashboard.general.created_at')</th>
      <th class="border-bottom-0">
        @lang('dashboard.general.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $department)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $department->name }}</td>
      <td>{{ @$department->parent->name ?? trans('dashboard.department.without_parent') }}</td>
      <td>{{ $department->created_at_date }}</td>
      <td>
        @if($department->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.department.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.department.active_cases.0') }}
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
