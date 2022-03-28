@extends('dashboard.layouts.master')
@section('title', trans('dashboard.admin.sub_progs.index'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ trans('dashboard.admin.sub_progs.index') }}</h1>
        <a href="{!! route('dashboard.admin.create') !!}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.admin.sub_progs.create') }}
        </a>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- FORM OPEN -->

    <form method="get" action="" id="search-form">
        <div class="row align-items-end mb-3">
            <div class="col-12 col-md-3">
                <label for="userName">@lang('dashboard.admin.name') </label>
                <input type="text" class="form-control" id="userName" placeholder="@lang('dashboard.admin.name')"
                    name="name" value="{{ old('name') ?? request('name') }}" />

            </div>
            <div class="col-12 col-md-3">
                <label for="userID">@lang('dashboard.admin.number') </label>
                <input type="number" class="form-control" id="userID" placeholder="@lang('dashboard.admin.number')"
                    name="login_id" value="{{ old('login_id') ?? request('login_id') }}" />

            </div>
            <div class="col-12 col-md-3">
                <label for="mainDepartment">@lang('dashboard.department.department') </label>
                {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search', 'id' => 'mainDepartment', 'placeholder' => trans('dashboard.department.select_department')]) !!}

            </div>
            <div class="col-12 col-md-3">
                <label for="status">@lang('dashboard.general.status')</label>
                {!! Form::select('ban_status', trans('dashboard.admin.active_cases'), request('ban_status'), ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.general.select_status')]) !!}
            </div>
        </div>
        <div class="row align-items-end mb-3">

            <div class="col-12 col-md-3 hold">
                <label for="validationCustom02"> معطل لفترة (من)</label>
                <div class="input-group">
                    <input id="from-hijri-unactive-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 hold">
                <label for="validationCustom02"> معطل لفترة (إلى)</label>
                <div class="input-group">
                    <input id="to-hijri-unactive-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
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
                <a href="{{ route('dashboard.admin.index') }}" class="btn btn-outline-primary">
                    <i class="mdi mdi-restore"></i>
                    @lang('dashboard.general.show_all')
                </a>
            </div>
        </div>
    </form>

    <!-- FORM CLOSED -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="table-responsive p-1">
                <table id="historyTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">@lang('dashboard.admin.name')</th>
                            <th class="border-bottom-0">@lang('dashboard.admin.number')</th>
                            <th class="border-bottom-0">@lang('dashboard.department.department')</th>
                            <th class="border-bottom-0">@lang('dashboard.general.created_at')</th>
                            <th class="border-bottom-0"> @lang('dashboard.general.status')</th>
                            <th class="border-bottom-0 text-center">@lang('dashboard.general.actions')</th>
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
@include('dashboard.admin.script')
