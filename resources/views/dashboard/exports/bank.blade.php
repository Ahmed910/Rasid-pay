@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'البنوك'])
    <tr>
      <th>#</th>
      <th> is_active </th>
      <th> name</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($banks as $bank)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $bank->is_active }}</td>
      <td>{{ $bank->name }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
