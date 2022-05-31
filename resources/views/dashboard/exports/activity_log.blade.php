@extends('dashboard.exports.layout')

@section('content')

 <table id="departmentTable" class="table">
          <thead>
          @include('dashboard.exports.header',['topic'=>'المتابعة'])

            <tr>
             <th>#</th>
                <th>
                    @lang('dashboard.employee.employee')</th>
                <th>
                    @lang('dashboard.department.department')</th>
                <th>
                    @lang('dashboard.activity_log.main_program')</th>
                <th>
                    @lang('dashboard.activity_log.sub_program')</th>
                <th>
                    @lang('dashboard.general.created_at')</th>
                <th>
                    @lang('dashboard.activity_log.ip_address')</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($activity_logs as $activity_log)
            <?php  $model = $activity_log->auditable_type;
               if (str_contains($activity_log->auditable_type, '\\')) {
                  $class = explode('\\', $activity_log->auditable_type);
                  $model = $class[COUNT($class) - 1];
                }; ?>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $activity_log->user?->fullname ?? trans("dashboard.error.not_found") }}</td>
                <td>{{ $activity_log->user?->department !== null ? $activity_log->user?->department?->name : trans('dashboard.department.without_parent') }}</td>
                <td>{{ $model}}</td>
                <td>{{ strtolower($activity_log->action_type)}}</td>
                <td>{{ $activity_log->created_at }}</td>
                <td>{{ $activity_log->ip_address }}</td>

            </tr>
            @endforeach
          </tbody>
          </table>

@endsection


