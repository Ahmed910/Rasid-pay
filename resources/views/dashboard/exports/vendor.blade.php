@extends('dashboard.exports.layout')

@section('content')
@include('dashboard.exports.header',['topic'=>trans('dashboard.vendor.vendors'), 'count' => 5])

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.vendor.branch_counts') </th>
      <th>@lang('dashboard.vendor.branch_name') </th>
      <th>@lang('dashboard.vendor.branch_type') </th>
      <th>@lang('dashboard.vendor.commerical_number') </th>
      <th>@lang('dashboard.vendor.tax_number') </th>
      <th>@lang('dashboard.vendor.status') </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendors as $vendor)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $vendor->branches_count ?? '' }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ trans('dashboard.vendor.type.'.$vendor->type)}}</td>
      <td>{{ $vendor->commercial_record ?? '' }}</td>
      <td>{{ $vendor->tax_number ?? '' }}</td>
       <td>
        @if($vendor->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.vendor.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.vendor.active_cases.0') }}
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
