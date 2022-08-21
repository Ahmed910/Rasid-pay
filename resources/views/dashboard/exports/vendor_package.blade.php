@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.vendor_package.vendor_name')</th>
      <th>@lang('dashboard.package.basic_card')</th>
      <th>@lang('dashboard.package.golden_card')</th>
      <th>@lang('dashboard.package.platinum_card')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $vendorPackage)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $vendorPackage?->vendor?->name }}</td>
      <td>{{ $vendorPackage?->basic_discount }}</td>
      <td>{{ $vendorPackage?->golden_discount }}</td>
      <td>{{ $vendorPackage?->platinum_discount }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
