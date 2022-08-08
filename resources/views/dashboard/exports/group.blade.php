@extends('dashboard.exports.layout')

@section('content')

 <table id="departmentTable" class="table">
          <thead>
          @include('dashboard.exports.header',['topic'=>'الصلاحيات', 'count' => 3])

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
                <td>
                  @if($group->is_active)
                  <div class="active">
                    <i class="mdi mdi-check-circle-outline"></i>
                    {{ trans('dashboard.general.active_cases.1') }}
                  </div>
                  @else
                  <div class="unactive">
                    <i class="mdi mdi-cancel"></i>
                    {{ trans('dashboard.general.active_cases.0') }}
                  </div>
                  @endif
                </td>
                <td>{{ $group->created_at_date }}</td>
            </tr>
            @endforeach
          </tbody>
          </table>

@endsection


