@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
    <thead>
        @include('dashboard.exports.header',['topic'=>'أرشيف الوظائف'])

        <tr>
           <th>#</th>
        <th>
          @lang('dashboard.rasid_job.job_name')</th>
        <th>
          @lang('dashboard.rasid_job.department')</th>
        <th>
          @lang('dashboard.rasid_job.archived_at')</th>
        <th>
          @lang('dashboard.rasid_job.is_active')</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($jobs_archive as $job_archive)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $job_archive->name }}</td>
        <td>{{ optional($job_archive->department)->name }}</td>
        <td>{{ $job_archive->deleted_at }}</td>
        <td>
          {{ $job_archive->is_active ? trans('dashboard.rasid_job.active_cases.1') : trans('dashboard.rasid_job.active_cases.0') }}
        </td>
      </tr>
      @endforeach
    </tbody>
</table>

@endsection
