@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>

    @include('dashboard.exports.header',['topic'=> trans('dashboard.department.departments'),'count'=>3])
    <tr>
      <td class="border-bottom-0">#</td>
      <td class="border-bottom-0">
        @lang('dashboard.department.department_name')</td>
      <td class="border-bottom-0">
        @lang('dashboard.department.main_department')</td>
      <td class="border-bottom-0">
        @lang('dashboard.general.created_at')</td>
      <td class="border-bottom-0">
        @lang('dashboard.general.status')</td>
    </tr>
  </thead>
  <tbody>
    @foreach ($departments as $department)
    <tr>
      <td>{{ $loop->iteration }}</td>
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
