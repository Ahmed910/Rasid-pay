@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.transfer_purpose.name')</th>
      <th>@lang('dashboard.transfer_purpose.status')</th>
      <th>@lang('dashboard.transfer_purpose.is_default_value')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $transfer)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
       <td>{{ $transfer->name ?? '' }}</td>
       <td>
        @if($transfer->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.transfer_purposes.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.transfer_purposes.active_cases.0') }}
        </div>
        @endif
      </td>
       <td>
        @if($transfer->is_default_value)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.transfer_purpose.is_default_value_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.transfer_purpose.is_default_value_cases.0') }}
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
