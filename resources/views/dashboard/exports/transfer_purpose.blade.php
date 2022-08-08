@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'أغراض الحوالة', 'count' => 2])
    <tr>
      <th>#</th>
      <th>الحالة</th>
      <th>is_default_value</th>
      <th>الاسم</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transfer_purposes as $transfer)
    <tr>
      <td>{{ $loop->iteration  }}</td>
       <td>
        @if($transfer->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.transfer_purposes.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.transfer_purposes.active_cases.0') }}
        </div>
        @endif
      </td>
      <td>{{ $transfer->is_default_value ?? '' }}</td>
      <td>{{ $transfer->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
