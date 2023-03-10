@extends('dashboard.layouts.master')
@section('title', ' - ' . trans('dashboard.group.groups'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.group.sub_progs.index') }}</h1>
  <a href="{{ route('dashboard.group.create') }}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i>
    {{ trans('dashboard.group.add_group') }}
  </a>
</div>

<form method="get" id="search-form">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-3">
      <label for="groupName">{!! trans('dashboard.group.group_name') !!}</label>
      <input type="text" name="name" value="{{ request('name') }}" id="name"
        class="form-control input-regex stop-copy-paste" maxlength="100" id="groupName"
        placeholder="{!! trans('dashboard.general.enter_name') !!}" />
    </div>
    <div class="col-12 col-md-3">
      <label for="userNumFrom">{!! trans('dashboard.group.admins_from') !!}</label>
      <input type="number" oninput="checkNumberFieldLength(this);" name="admins_from"
        value="{{ request('admins_from') }}" class="form-control number-regex  stop-copy-paste " onkeypress = 'return /[0-9]/i.test(event.key)'  id="userNumFrom"
        placeholder="{!! trans('dashboard.datatable.from') !!}" />
    </div>
    <div class="col-12 col-md-3">
      <label for="userNumTo">{!! trans('dashboard.group.admins_to') !!}</label>
      <input type="number" oninput="checkNumberFieldLength(this);" name="admins_to" value="{{ request('admins_to') }}"
        class="form-control number-regex  stop-copy-paste" onkeypress = 'return /[0-9]/i.test(event.key)' id="userNumTo" placeholder="{!! trans('dashboard.datatable.to') !!}" />
    </div>
    <div class="col-12 col-md-3">
     <label for="status">
        @lang('dashboard.general.status')</label>
      {!! Form::select('is_active', ['' => '', -1 => trans('dashboard.general.all_cases')] +
      trans('dashboard.general.active_cases'), request('is_active'), ['class' => 'form-control select2',
      'data-placeholder' => trans('dashboard.general.select_status'), 'id' => 'status']) !!}
    </div>
    <div class="col-12 col-md-6 mt-5">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-tray-arrow-down"></i> {!! trans('dashboard.general.export') !!}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item"
                            href="{{ url(app()->getLocale().'/dashboard/group/exportPDF')  }}"
                            target="_blank">PDF</a></li>
                    <li><a class="dropdown-item"
                            href="{{ url(app()->getLocale().'/dashboard/group/export') }}"
                            target="_blank">Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-6 mt-5 d-flex justify-content-end">
      <button class="btn btn-primary me-2" type="submit">
        <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
      </button>
      <button class="btn btn-outline-primary" type="reset" id="reset">
        <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
      </button>
    </div>
  </div>
</form>

<div class="row row-sm">
  <div class="col-lg-12">
    <div class="p-1">

        <table id="ajaxTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">{!! trans('dashboard.group.group_name') !!}</th>
              <th class="border-bottom-0">{!! trans('dashboard.admin.admin_count') !!}</th>
              <th class="border-bottom-0">{!! trans('dashboard.general.status') !!}</th>
              <th class="border-bottom-0">{!! trans('dashboard.general.created_at') !!}</th>
              <th class="border-bottom-0 text-center">{!! trans('dashboard.general.actions') !!}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

    </div>
  </div>
</div>

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@include('dashboard.layouts.modals.alert')
@endsection
@include('dashboard.group.script')
