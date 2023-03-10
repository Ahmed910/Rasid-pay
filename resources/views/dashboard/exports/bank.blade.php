@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th> @lang('dashboard.bank.name')</th>
      <th> @lang('dashboard.bank.status') </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $bank)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
       <td>{{ $bank->name }}</td>
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
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
