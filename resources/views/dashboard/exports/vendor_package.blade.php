@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>trans('dashboard.vendor_package.vendor_packages'), 'count' => 3])
    <tr>
      <th>#</th>
      <th>@lang('dashboard.vendor_package.vendor_name')</th>
      <th>@lang('dashboard.package.basic_card')</th>
      <th>@lang('dashboard.package.golden_card')</th>
      <th>@lang('dashboard.package.platinum_card')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendor_packages as $venorPackage)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $venorPackage?->vendor?->name }}</td>
      <td>{{ $venorPackage?->basic_discount }}</td>
      <td>{{ $venorPackage?->golden_discount }}</td>
      <td>{{ $venorPackage?->platinum_discount }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
