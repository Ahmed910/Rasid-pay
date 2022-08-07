@php
$package_discount = [];
foreach ($packages as $key => $clientPackage) {
  $package_discount[$key]['fullname'] = $clientPackage->fullname;
  foreach ($clientPackage->clientPackages as $clientPackage) {
    if ($clientPackage->id == $clientPackage->pivot->package_id) {
      $package_discount[$key][$clientPackage->name] = $clientPackage->pivot->package_discount;
    }
  }
}

@endphp

@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'نسب خصم البطاقات'])

    <tr>
      <th class="border-bottom-0">#</th>
      <th class="border-bottom-0">@lang('dashboard.package.client_name')</th>
      <th class="border-bottom-0">@lang('dashboard.package.basic_card')</th>
      <th class="border-bottom-0">@lang('dashboard.package.golden_card')</th>
      <th class="border-bottom-0">@lang('dashboard.package.platinum_card')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($package_discount as $package)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $package['fullname'] ?? '' }}</td>
      <td>{{ $package[trans('dashboard.cardpackage.basic')]  ?? '' }}</td>
      <td>{{ $package[trans('dashboard.cardpackage.golden')]  ?? '' }}</td>
      <td>{{ $package[trans('dashboard.cardpackage.platinum')]  ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
