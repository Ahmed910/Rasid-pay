@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('title', trans('dashboard.department.sub_progs.index'))

@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid" style="min-height:50vh;">
                <div class="page-header">
                    <h1 class="page-title">@lang('dashboard.department.sub_progs.index')</h1>
                    <a href="{{ route('dashboard.department.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle-outline"></i>
                        @lang('dashboard.department.add_department')
                    </a>
                </div>
                <form method="get" action="" id="search-form">
                    <div class="row align-items-end mb-3">
                        <div class="col">
                            <label for="departmentName">@lang('dashboard.department.department')</label>
                            <input type="text" class="form-control" id="departmentName"
                                placeholder="@lang('dashboard.department.department')" name="name"
                                value="{{ old('name') ?? request('name') }}" />
                        </div>
                        <div class="col">
                            <label>@lang('dashboard.department.main_department')</label>
                            <select class="form-control select2"
                                data-placeholder="@lang('dashboard.department.select_main_department')" name="parent_id">
                                <option selected disabled value="">@lang('dashboard.department.select_main_department')
                                </option>
                                @foreach ($parentDepartments as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ (old('parent_id') ?? request('parent_id')) == $id ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="validationCustom02">@lang('dashboard.general.from_date')</label>
                            <div class="input-group">
                                <input id="from-hijri-picker" type="text" readonly
                                    placeholder="@lang('dashboard.general.day_month_year')" class="form-control"
                                    name="created_from" value="{{ old('created_from') ?? request('created_from') }}" />
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="validationCustom02">@lang('dashboard.general.to_date')</label>
                            <div class="input-group">
                                <input id="to-hijri-picker" type="text" readonly
                                    placeholder="@lang('dashboard.general.day_month_year')" class="form-control"
                                    name="created_to" value="{{ old('created_to') ?? request('created_to') }}" />
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="status">@lang('dashboard.general.status')</label>
                            <select class="form-control select2" id="status" name="is_active">
                                <option selected disabled value="">@lang('dashboard.general.select_status')</option>
                                <option value="">@lang('dashboard.general.all')</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>
                                    @lang('dashboard.general.active')</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>
                                    @lang('dashboard.general.inactive')</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 my-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-tray-arrow-down"></i>
                                    @lang('dashboard.general.export')
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    <li><a class="dropdown-item" href="#">Excel</a></li>
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
                            <table id="departmentTable"
                                class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">@lang('dashboard.department.department')</th>
                                        <th class="border-bottom-0">@lang('dashboard.department.main_department')</th>
                                        <th class="border-bottom-0">@lang('dashboard.general.created_at')</th>
                                        <th class="border-bottom-0">@lang('dashboard.general.status')</th>
                                        <th class="border-bottom-0 text-center">@lang('dashboard.general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.layouts.modals.archive')
    @include('dashboard.layouts.modals.not_archive')
@endsection

@section('scripts')
    @include('dashboard.department.script')
@endsection
