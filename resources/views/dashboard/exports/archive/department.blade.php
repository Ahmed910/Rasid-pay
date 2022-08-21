@extends('dashboard.exports.layout')

@section('content')

<?php
  $count = str_contains(url()->current(), 'export_pdf') ? ($key * $chunk) : 0;
 ?>
<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>
        @lang('dashboard.department.department')</th>
      <th>
        @lang('dashboard.department.main_department')</th>
      <th>
        @lang('dashboard.department.archived_at')</th>
      <th>
        @lang('dashboard.general.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $department)

    <tr>
      <td>{{ $loop->iteration + $count }}</td>
      <td>{{ $department->name }}</td>
      <td>{{ @$department->parent->name ?? trans('dashboard.department.without_parent') }}</td>
      <td>{{ $department->deleted_at }}</td>
      <td>
        {{ $department->is_active ? trans('dashboard.general.active') : trans('dashboard.general.inactive') }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
