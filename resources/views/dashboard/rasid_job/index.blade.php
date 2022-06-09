@extends('dashboard.layouts.master')

@section('title', trans('dashboard.rasid_job.sub_progs.index'))

@section('content')
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.rasid_job.sub_progs.index') }}</h1>
  <a href="{{ route('dashboard.rasid_job.create') }}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.rasid_job.add_job') }}
  </a>
</div>

{!! Form::open(['route' => 'dashboard.rasid_job.index', 'method' => 'GET', 'id' => 'search-form']) !!}
<div class="row align-items-end mb-3">
  <div class="col-12 col-md-4">
    <label for="job_name">{{ trans('dashboard.rasid_job.job_name') }}</label>
    {!! Form::text('name', old('name') ?? request('name'), ['class' => 'form-control input-regex stop-copy-paste',
    'placeholder' => trans('dashboard.rasid_job.job_name'), 'id' => 'job_name']) !!}
  </div>
  <div class="col-12 col-md-4">
    <label for="mainDepartment"> {{ trans('dashboard.department.department') }} </label>
    {!! Form::select('department_id', ['' => '', 0 => trans('dashboard.general.all_cases')] + $departments,
    old('department_id') ?? request('department_id'), ['data-placeholder' =>
    trans('dashboard.rasid_job.select_department'), 'class' => 'form-control select2-show-search', 'id' =>
    'mainDepartment']) !!}
  </div>
  <div class="col-12 col-md-4">
    <label for="from-hijri-picker-custom"> {{ trans('dashboard.general.from_date') }}</label>
    <div class="input-group">
      {!! Form::text('from_date', old('from_date') ?? request('from_date'), ['class' => 'form-control', 'id' =>
      'from-hijri-picker-custom', 'placeholder' => trans('dashboard.general.day_month_year'), 'readonly']) !!}
      <div class="input-group-text border-start-0">
        <label for="from-hijri-picker-custom">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i></label>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <label for="to-hijri-picker-custom"> {{ trans('dashboard.general.to_date') }}</label>
    <div class="input-group">
      {!! Form::text('to_date', old('to_date') ?? request('to_date'), ['class' => 'form-control', 'placeholder' =>
      trans('dashboard.general.day_month_year'), 'id' => 'to-hijri-picker-custom', 'readonly']) !!}
      <div class="input-group-text border-start-0">
        <label for="to-hijri-picker-custom">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i></label>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <label for="status">
      {{ trans('dashboard.general.status') }}</label>
    {!! Form::select('is_active', ['' => '', -1 => trans('dashboard.general.all_cases')] +
    trans('dashboard.rasid_job.active_cases'), old('is_active') ?? request('is_active'), ['class' => 'form-control
    select2', 'data-placeholder' => trans('dashboard.general.select_status'), 'id' => 'status']) !!}
  </div>
  <div class="col-12 col-md-4">
    <label for="type">
      {{ trans('dashboard.general.type') }}</label>
    {!! Form::select('is_vacant', ['' => '', -1 => trans('dashboard.general.all_cases')] +
    trans('dashboard.general.job_type_cases'), old('is_vacant') ?? request('is_vacant'), ['class' => 'form-control
    select2', 'data-placeholder' => trans('dashboard.general.select_type'), 'id' => 'type']) !!}
  </div>
</div>
<div class="row">
  <div class="col-12 col-md-6 my-2">
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-tray-arrow-down"></i> {{ trans('dashboard.general.export') }}
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
       <li><a class="dropdown-item "
                            href="{{ url(app()->getLocale().'/dashboard/rasid_job/exportPDF')  }}"
                            target="_blank">PDF</a></li>
                    <li><a class="dropdown-item"
                            href="{{ url(app()->getLocale().'/dashboard/rasid_job/export') }}"
                            target="_blank">Excel</a></li>
      </ul>
    </div>
  </div>
  <div class="col-12 col-md-6 my-2 d-flex justify-content-end">

    <button class="btn btn-primary me-2" type="submit">
      <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
    </button>

    <button class="btn btn-outline-primary" type="reset" id="reset">
      <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
    </button>
  </div>
</div>

{!! form::close() !!}

<div class="row row-sm">
  <div class="col-lg-12">
    <div class="p-1">
        <table id="JobsTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">{{ trans('dashboard.rasid_job.job_name') }}</th>
              <th class="border-bottom-0">{{ trans('dashboard.department.department') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.general.status') }}</th>
              <th class="border-bottom-0">{{ trans('dashboard.general.type') }}</th>
              <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
  <!-- End Row -->
  @include('dashboard.layouts.modals.archive')
  @include('dashboard.layouts.modals.not_archive')
  @include('dashboard.layouts.modals.alert')

  @endsection
  @include('dashboard.rasid_job.script')
