@extends('dashboard.layouts.master')

@section('title', ' - ' . trans('dashboard.department.sub_progs.index'))

@section('content')

    <div class="page-header">
        <h1 class="page-title">
            @lang('dashboard.department.sub_progs.index')</h1>
        <a href="{{ route('dashboard.department.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i>
            @lang('dashboard.department.add_department')
        </a>
    </div>
    <form method="get" action="" id="search-form">
        <div class="row align-items-end mb-3">
            <div class="col">
                <label for="departmentName">
                    @lang('dashboard.department.department_name')</label>
                <input type="text" class="form-control" id="departmentName"
                    placeholder="@lang('dashboard.general.enter_name')" name="name"
                    value="{{ old('name') ?? request('name') }}" />
            </div>
            <div class="col">
                <label>
                    @lang('dashboard.department.main_department')</label>



                {!! Form::select('parent_id', [0 => trans('dashboard.department.without_parent')] + $parentDepartments, request('parent_id'), ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.department.select_main_department')]) !!}
            </div>
            <div class="col">
                <label for="validationCustom02">
                    @lang('dashboard.general.from_date')</label>
                <div class="input-group">
                    <input id="from-hijri-picker-custom" type="text" readonly
                        placeholder="@lang('dashboard.general.day_month_year')" class="form-control" name="created_from"
                        value="{{ old('created_from') ?? request('created_from') }}" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <label for="validationCustom02">
                    @lang('dashboard.general.to_date')</label>
                <div class="input-group">
                    <input id="to-hijri-picker-custom" type="text" readonly
                        placeholder="@lang('dashboard.general.day_month_year')" class="form-control" name="created_to"
                        value="{{ old('created_to') ?? request('created_to') }}" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <label for="status">
                    @lang('dashboard.general.status')</label>


                {!! Form::select('is_active', [-1 => trans('dashboard.general.all_cases')] + trans('dashboard.general.active_cases'), request('is_active'), ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.general.select_status')]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 my-2">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-tray-arrow-down"></i>
                        @lang('dashboard.general.export')
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item"
                                href="{{ route('dashboard.department.exportPDF', ['is_active' => request('is_active'),'name' => request('name'),'parent_id' => request('parent_id'),'created_from' => request('created_from'),'created_to' => request('created_to')]) }}"
                                target="_blank">PDF</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('dashboard.department.export', ['is_active' => request('is_active'),'name' => request('name'),'parent_id' => request('parent_id'),'created_from' => request('created_from'),'created_to' => request('created_to')]) }}"
                                target="_blank">Excel</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
                <button class="btn btn-primary mx-2" type="submit">
                    <i class="mdi mdi-magnify"></i>
                    @lang('dashboard.general.search')
                </button>
                <a href="{{ route('dashboard.department.index') }}" class="btn btn-outline-primary">
                    <i class="mdi mdi-restore"></i>
                    @lang('dashboard.general.show_all')
                </a>
            </div>
        </div>
    </form>

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="table-responsive p-1">
                <table id="departmentTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.department.department_name')</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.department.main_department')</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.general.created_at')</th>
                            <th class="border-bottom-0">
                                @lang('dashboard.general.status')</th>
                            <th class="border-bottom-0 text-center">
                                @lang('dashboard.general.actions')</th>
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
@include('dashboard.department.script')
