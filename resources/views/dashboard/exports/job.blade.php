@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
    <thead>
        @include('dashboard.exports.header',['topic'=>'الوظائف'])

        <tr>
            <th>#</th>
            <th>
                {{ trans('dashboard.rasid_job.job_name') }}</th>
            <th>
                {{ trans('dashboard.department.department') }}</th>
            <th>
                {{ trans('dashboard.general.created_at') }}</th>
            <th>
                {{ trans('dashboard.general.status') }}</th>
            <th>
                {{ trans('dashboard.general.type') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jobs as $job)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $job->name }}</td>
            <td>{{ $job->department?->name }}</td>
            <td>{{ $job->created_at }}</td>
            <td>
                @if($job->is_active)
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

            <td>{{ trans('dashboard.general.job_type_cases.' . $job->is_vacant) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
