@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'نسب الخصم', 'count' => 3])
    <tr>
      <th>#</th>
      <th> اسم العميل </th>
      <th> نسبة خصم البطاقة الأساسية</th>
      <th> نسبة خصم البطاقة الذهبية</th>
      <th> نسبة خصم البطاقة البلاتينية</th>
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
