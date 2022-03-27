@extends('dashboard.layouts.master')

@section('title', trans('dashboard.rasid_job.sub_progs.show'))

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.job.index') }}">
                    @lang('dashboard.rasid_job.sub_progs.index') </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @lang('dashboard.rasid_job.sub_progs.show')
            </li>
        </ol>
    </nav>
</div>

<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-3">
            <label>@lang('dashboard.rasid_job.name') :</label>
            <p>{{ $rasidJob->name }}</p>
        </div>
        <div class="col-12 col-md-3">
            <label>@lang('dashboard.rasid_job.rasid_job_department'):</label>
            <p>{{ $rasidJob->department->name }}</p>
        </div>
        <div class="col-12 col-md-3">
            <label class="d-block" for="departmentName">@lang('dashboard.general.status'):</label>
            @if ($rasidJob->is_active == 1)
                <p class="badge bg-success-opacity py-2 px-4">@lang('dashboard.general.active')</p>
            @else
                <p class="badge bg-danger-opacity py-2 px-4">@lang('dashboard.general.inactive')</p>
            @endif
        </div>
        <div class="col-12 col-md-3">
            <label class="d-block" for="departmentName">@lang('dashboard.general.type'):</label>
            <p class="occupied">
                {{ $rasidJob->is_vacant === 1? trans('dashboard.rasid_job.is_vacant.false'): trans('dashboard.rasid_job.is_vacant.true') }}
            </p>
        </div>
        <div class="col-12 col-md-3">
            <label class="d-block" for="departmentName">@lang('dashboard.rasid_job.employee_name')
                :</label>
            <p> {{ $rasidJob->employee?->user?->fullname }}</p>
        </div>
        <div class="col-12 col-md-9">
            <label class="d-block" for="departmentName">@lang('dashboard.rasid_job.rasid_job_description')
                :</label>
            <p>
                {{ $rasidJob->description }}
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-end">
        <a href="{{ route('dashboard.job.edit', $rasidJob->id) }}" class="btn btn-primary">
            <i class="mdi mdi-square-edit-outline"></i> @lang('dashboard.general.edit')
        </a>
        <a href="{{ route('dashboard.job.index') }}" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left"></i> @lang('dashboard.general.back')
        </a>
    </div>
</div>

<label> @lang('dashboard.activity_log.history') </label>
<div class="table-responsive p-1">
    <table id="historyTable" class="table table-bordered shadow-sm bg-body key-buttons historyTable">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">@lang('dashboard.general.done_by') </th>
                <th class="border-bottom-0"> @lang('dashboard.department.department') </th>
                <th class="border-bottom-0">@lang('dashboard.activity_log.date') </th>
                <th class="border-bottom-0">@lang('dashboard.activity_log.activity')</th>
                <th class="border-bottom-0" style="max-width: 800px;">@lang('dashboard.general.reason')
                </th>
            </tr>
        </thead>
    </table>
</div>

@endsection
@include('dashboard.job.show-script')
