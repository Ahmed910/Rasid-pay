@extends('dashboard.exports.layout')

@section('content')

 <table id="departmentTable" class="table">
          <thead>
          @include('dashboard.exports.header',['topic'=>@lang('dashboard.admin.admins'), 'count' => 4)

            <tr>
             <th>#</th>
                <th>
                    @lang('dashboard.admin.name')</th>
                <th>
                    @lang('dashboard.admin.login_id')</th>
                <th>
                    @lang('dashboard.department.department')</th>
                <th>
                    @lang('dashboard.general.created_at')</th>
                <th>
                    @lang('dashboard.general.status')</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($admins as $admin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admin->fullname }}</td>
                <td>{{ $admin->login_id }}</td>
                <td>{{ $admin->department?->name}}</td>
                <td>{{ $admin->created_at_date }}</td>
            @php
                $ban_status = match ($admin->ban_status) {
                'active' => trans('dashboard.admin.active_cases.active'),
                'permanent' => trans('dashboard.admin.active_cases.permanent'),
                'temporary' => trans('dashboard.admin.active_cases.temporary'),
                }
            @endphp
                <td>
                  @if($admin->ban_status == 'active')
                  <div class="active">
                    <i class="mdi mdi-check-circle-outline"></i>
                    {{ $ban_status }}
                  </div>
                  @else
                  <div class="unactive">
                    <i class="mdi mdi-cancel"></i>
                    {{ $ban_status }}
                  </div>
                  @endif
                </td>

            </tr>
            @endforeach
          </tbody>
          </table>

@endsection


