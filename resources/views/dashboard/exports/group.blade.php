@extends('dashboard.exports.layout')

@section('content')

 <table id="departmentTable" class="table">
          <thead>
          @include('dashboard.exports.header',['topic'=>'الصلاحيات'])

            <tr>
            <th>#</th>
                <th>
                    @lang('dashboard.group.group_name')</th>
                <th>
                    @lang('dashboard.group.admins_count')</th>
                <th>
                    @lang('dashboard.general.status')</th>
                <th>
                    @lang('dashboard.general.created_at')</th>
            </tr>
          </thead>
          <tbody>
             @foreach ($groups as $group)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->user_count }}</td>
                <td>{{ trans('dashboard.general.active_cases.'.$group->is_active) }}</td>
                <td>{{ $group->created_at }}</td>
            </tr>
            @endforeach
          </tbody>
          </table>

@endsection


