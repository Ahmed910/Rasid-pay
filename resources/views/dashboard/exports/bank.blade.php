@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'البنوك', 'count' => 1])
    <tr>
      <th>#</th>
      <th> الحالة </th>
      <th> الاسم</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($banks as $bank)
    <tr>
      <td>{{ $loop->iteration }}</td>
       <td>
        @if($bank->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.bank.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.bank.active_cases.0') }}
        </div>
        @endif
      </td>
      <td>{{ $bank->name }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
