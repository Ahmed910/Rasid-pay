@extends('dashboard.exports.layout')

@section('content')

  <table id="departmentTable" class="table">
    <thead>


      <tr>
      <th class="border-bottom-0">#</th>
      <th class="border-bottom-0">
        @lang('dashboard.message_type.name')</th>
      <th class="border-bottom-0">
        @lang('dashboard.message_type.employee_count')</th>
      <th class="border-bottom-0">
        @lang('dashboard.general.created_at')</th>
        <th class="border-bottom-0">
        @lang('dashboard.general.status')</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($rows as $message_type)
      <tr>
        <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
        <td>{{ $message_type->name ?? '' }}</td>
        <td>{{ $message_type->admins_count ?? '' }}</td>

        <td>{{ $message_type->created_at_date ?? '' }}</td>
         <td>
        @if($message_type->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.message_type.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.message_type.active_cases.0') }}
        </div>
        @endif
      </td>
      </tr>
    @endforeach
    </tbody>
  </table>

@endsection
