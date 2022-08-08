@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>trans('dashboard.vendor_branch.vendors_branches'), 'count' => 7])
    <tr>
      <th>#</th>
      <th>@lang('dashboard.vendor_branch.name')</th>
      <th>lat</th>
      <th>lng</th>
      <th>@lang('dashboard.vendor_branch.address')</th>
      <th>@lang('dashboard.vendor_branch.address_details')</th>
      <th>@lang('dashboard.vendor_branch.status')</th>
      <th>@lang('dashboard.vendor_branch.email') </th>
      <th>@lang('dashboard.vendor_branch.phone')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendorbranches as $vendor)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ $vendor->lat ?? '' }}</td>
      <td>{{ $vendor->lng ?? '' }}</td>
      <td>{{ $vendor->location ?? '' }}</td>
      <td>{{ $vendor->address_details ?? '' }}</td>
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
      <td>{{ $vendor->email ?? '' }}</td>
      <td>{{ $vendor->phone ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
