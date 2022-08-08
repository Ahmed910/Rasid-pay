@extends('dashboard.exports.layout')

@section('content')

  <table id="departmentTable" class="table">
    <thead>
    @include('dashboard.exports.header',['topic'=>'أنواع الرسائل', 'count' => 3])


      <tr>
      <th class="border-bottom-0">#</th>
      <th class="border-bottom-0">
        @lang('dashboard.message_type.name')</th>
      <th class="border-bottom-0">
        @lang('dashboard.message_type.employee_count')</th>
      <th class="border-bottom-0">
        @lang('dashboard.general.status')</th>
      <th class="border-bottom-0">
       @lang('dashboard.general.created_at')</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($messageTypes as $message_type)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $message_type->name ?? '' }}</td>
        <td>{{ $message_type->admins_count ?? '' }}</td>

         <td>
        @if($message_type->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.message_type.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.message_type.active_cases.0') }}
        </div>
        @endif
      </td>
      <td>{{ $message_type->created_at_date ?? '' }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>

@endsection
