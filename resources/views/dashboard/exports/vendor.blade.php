@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'العملاء'])
    <tr>
      <th>#</th>
      <th>branches_count</th>
      <th>name</th>
      <th>type</th>
      <th>commercial_record</th>
      <th>tax_number</th>
      <th>is_active</th>
      <th>is_support_maak</th>
      <th>email</th>
      <th>country_code</th>
      <th>phone</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendors as $vendor)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $vendor->branches_count ?? '' }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ $vendor->type ?? '' }}</td>
      <td>{{ $vendor->commercial_record ?? '' }}</td>
      <td>{{ $vendor->tax_number ?? '' }}</td>
      <td>{{ $vendor->is_active ?? '' }}</td>
      <td>{{ $vendor->is_support_maak ?? '' }}</td>
      <td>{{ $vendor->email ?? '' }}</td>
      <td>{{ $vendor->country_code ?? '' }}</td>
      <td>{{ $vendor->phone ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
