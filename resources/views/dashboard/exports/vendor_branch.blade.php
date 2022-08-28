@extends('dashboard.exports.layout')

@section('content')


<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.vendor_branch.name')</th>
      <th>@lang('dashboard.vendor.vendor_name')</th>
      <th>@lang('dashboard.general.phone')</th>
      <th>@lang('dashboard.vendor_branch.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $vendor)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ $vendor->vendor?->name ?? '' }}</td>
      <td>{{ $vendor->phone ?? '' }}</td>
      <td>
        @if($vendor->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.vendor_branch.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.vendor_branch.active_cases.0') }}
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
