@extends('dashboard.layouts.master')
@section('title', trans('dashboard.activity_log.activity_log_records'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.activity_log.activity_log_records') }}</h1>
</div>
<!-- PAGE-HEADER END -->
<!-- FORM OPEN -->
{!! Form::open(['method' => 'GET', 'id' => 'search-form']) !!}
<div class="row align-items-end mb-3">
  <div class="col-12 col-md-3">
    <label for="activityName"> {{ trans('dashboard.activity_log.activity') }}</label>
    {!! Form::select('action', ['' => '', -1 => trans('dashboard.general.all_cases')] +
    trans('dashboard.activity_log.actions'),request('action'), ['class' => 'form-control select2-show-search ', 'id' =>
    'activityName', 'data-placeholder' => trans('dashboard.activity_log.select_activity')]) !!}
  </div>
  <div class="col-12 col-md-3">
    <label for="mainDepartment">{{ trans('dashboard.department.department') }} </label>
    {!! Form::select('department_id', ['' => '', 0 => trans('dashboard.general.all_cases')] + $departments,
    old('department_id') ?? request('department_id'), ['class' => 'form-control select2-show-search form-select', 'id'
    => 'mainDepartment', 'data-placeholder' => trans('dashboard.department.select_department')]) !!}
  </div>
  <div class="col-12 col-md-3">
    <label for="employee">{{ trans('dashboard.employee.employee') }}</label>
    {!! Form::select('employee_id', ['' => ''], null, ['class' => 'form-control select2-show-search form-select', 'id'
    => 'employee', 'data-placeholder' => trans('dashboard.activity_log.select_employee')]) !!}
  </div>
  <div class="col-12 col-md-3">
    <label for="mainProgram">{{ trans('dashboard.activity_log.main_program') }}</label>
    {!! Form::select('main_program', ['' => '', -1 => trans('dashboard.general.all_cases')] + $mainPrograms,
    request('main_program'), ['class' => 'form-control select2-show-search form-select', 'id' => 'mainProgram',
    'data-placeholder' => trans('dashboard.activity_log.select_mainprogram')]) !!}
  </div>
  <div class="col-12 col-md-3 mt-3">
    <label for="branchProgram"> {{ trans('dashboard.activity_log.sub_program') }}</label>
    {!! Form::select('sub_program', ['' => '', -1 => trans('dashboard.general.all_cases')] +
    trans('dashboard.activity_log.sub_progs'), request('sub_program'), ['class' => 'form-control select2-show-search
    form-select', 'id' => 'branchProgram', 'data-placeholder' => trans('dashboard.activity_log.select_subprogram')]) !!}
  </div>
  <div class="col-12 col-md-3 mt-3">
    <label for="from-hijri-picker-custom">
      @lang('dashboard.general.from_date')</label>
    <div class="input-group">
      <input id="from-hijri-picker-custom" type="text" readonly placeholder="@lang('dashboard.general.day_month_year')"
        class="form-control" name="created_from" value="{{ old('created_from') ?? request('created_from') }}" />
      <div class="input-group-text border-start-0">
        <label for="from-hijri-picker-custom">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i></label>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-3 mt-3">
    <label for="to-hijri-picker-custom">
      @lang('dashboard.general.to_date')</label>
    <div class="input-group">
      <input id="to-hijri-picker-custom" type="text" readonly placeholder="@lang('dashboard.general.day_month_year')"
        class="form-control" name="created_to" value="{{ old('created_to') ?? request('created_to') }}" />
      <div class="input-group-text border-start-0">
        <label for="to-hijri-picker-custom">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i></label>
      </div>
    </div>
  </div>
</div>
<div class="row">
   <div class="col-12 col-md-6 mt-5">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-tray-arrow-down"></i> {!! trans('dashboard.general.export') !!}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item"
                            href="{{ url(app()->getLocale().'/dashboard/activity_log/exportPDF')  }}" target="_blank">PDF</a></li>
                    <li><a class="dropdown-item"
                            href="{{ url(app()->getLocale().'/dashboard/activity_log/export') }}"
                            target="_blank">Excel</a></li>
        </ul>
      </div>
    </div>
  <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
    <button class="btn btn-primary me-2" type="submit">
      <i class="mdi mdi-magnify">
      </i> {{ trans('dashboard.general.search') }}
    </button>
    <a href="{{ route('dashboard.activity_log.index') }}" class="btn btn-outline-primary">
      <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
    </a>
  </div>
</div>
</form>
<!-- FORM CLOSED -->
<!-- Row -->
<div class="row row-sm">
  <div class="col-lg-12">
    <div class="p-1">
        <table id="activitylogtable"
          class="table table-bordered dt-responsive nowrap shadow-sm bg-body key-buttons historyTable ">
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">{{ trans('dashboard.employee.employee') }}</th>
              <th class="border-bottom-0">{{ trans('dashboard.department.department') }}</th>
              <th class="border-bottom-0">{{ trans('dashboard.activity_log.main_program') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.activity_log.sub_program') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }}</th>
              <th class="border-bottom-0">{{ trans('dashboard.activity_log.ip_address') }}</th>
              <th class="border-bottom-0 text-center">{{ trans('dashboard.activity_log.activity') }}</th>
              <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
</div>
<!-- End Row -->

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.activity_log.script')
