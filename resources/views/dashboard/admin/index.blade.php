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
                <label for="userName">{{ trans('dashboard.admin.name') }}</label>
                <input type="text" class="form-control" id="userName" placeholder="{{ trans('dashboard.admin.name') }}"
                    name="name" value="{{ old('name') ?? request('name') }}" />

            </div>
            <div class="col-12 col-md-3">
                <label for="userID">{{ trans('dashboard.admin.number') }}</label>
                <input type="number" class="form-control" id="userID" placeholder="{{ trans('dashboard.admin.number') }}"
                    name="login_id" value="{{ old('login_id') ?? request('login_id') }}" />

            </div>
            <div class="col-12 col-md-3">
                <label for="mainDepartment">{{ trans('dashboard.department.department') }} </label>
                {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search', 'id' => 'mainDepartment', 'placeholder' => trans('dashboard.department.select_department')]) !!}

            </div>
            <div class="col-12 col-md-3">
                <label for="status">{{ trans('dashboard.general.status') }}</label>
                {!! Form::select('ban_status', trans('dashboard.admin.active_cases'), request('ban_status'), ['class' => 'form-control select2', 'id' => 'status', 'placeholder' => trans('dashboard.general.select_status')]) !!}
            </div>
        </div>


        <div class="row align-items-end mb-3">

            <div class="col-12 col-md-3 temporary">
                <label for="ban_from"> {{ trans('dashboard.admin.ban_from') }}</label>
                <div class="input-group">
                    <input id="from-hijri-unactive-picker-custom" type="text" readonly
                        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control"
                        name="ban_from" value="{{ old('ban_from') ?? request('ban_from') }}" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 temporary">
                <label for="ban_to">{{ trans('dashboard.admin.ban_to') }}</label>
                <div class="input-group">
                    <input id="to-hijri-unactive-picker-custom" type="text" readonly
                        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control"
                        name="ban_to" value="{{ old('ban_to') ?? request('ban_to') }}" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="created_from">
                    {{ trans('dashboard.general.from_date') }}</label>
                <div class="input-group">
                    <input id="from-hijri-picker-custom" type="text" readonly
                        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control"
                        name="created_from" value="{{ old('created_from') ?? request('created_from') }}" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <label for="created_to">
                    {{ trans('dashboard.general.to_date') }}</label>
                <div class="input-group">
                    <input id="to-hijri-picker-custom" type="text" readonly
                        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control"
                        name="created_to" value="{{ old('created_to') ?? request('created_to') }}" />
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
                        {{ trans('dashboard.general.export') }}
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
                    {{ trans('dashboard.general.search') }}
                </button>
                <a href="{{ route('dashboard.admin.index') }}" class="btn btn-outline-primary">
                    <i class="mdi mdi-restore"></i>
                    {{ trans('dashboard.general.show_all') }}
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
                            <th class="border-bottom-0">{{ trans('dashboard.admin.name') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.admin.number') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.department.department') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }}</th>
                            <th class="border-bottom-0"> {{ trans('dashboard.general.status') }}</th>
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
@include('dashboard.admin.script')
