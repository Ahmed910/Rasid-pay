@extends('dashboard.exports.layout')

@section('content')

@include('dashboard.exports.header',['topic'=>trans('dashboard.group.all_groups'), 'count' => 3])
 <table id="departmentTable" class="table">
          <thead>

    <tr>
      <th>#</th>
      <th>
        @lang('dashboard.group.group_name')</th>
      <th>
        @lang('dashboard.group.admins_count')</th>
      <th>
        @lang('dashboard.general.status')</th>
      <th>
        @lang('dashboard.general.created_at')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $group)
    <tr>
      <td>{{ $loop->iteration + ($key * $chunk) }}</td>
      <td>{{ $group->name }}</td>
      <td>{{ $group->user_count }}</td>
      <td>
        @if($group->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.group.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.group.active_cases.0') }}
        </div>
        @endif
      </td>
      <td>{{ $group->created_at_date }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
