@extends('dashboard.layouts.master')

@section('nav-title')
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ trans('dashboard.department.sub_progs.archive') }}</h1>
    </div>
    <form method="get" action="" id="search-form">
        <div class="row align-items-end mb-3">
            <div class="col">
                <label for="departmentName">{{ trans('dashboard.department.department_main') }}</label>
                <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم" name="name"
                    value="{{ old('name') ?? request('name') }}" />
            </div>
            <div class="col">
              <label>
                {{ trans('dashboard.department.main_department')}}</label>
                {!! Form::select('parent_id', $parentDepartments, null, ['class' => 'form-control select2', 'placeholder' => trans('dashboard.department.select_main_department')]) !!}
            </div>
            <div class="col">
                <label for="validationCustom02"> {{ trans('dashboard.department.archive_from_date') }}</label>
                <div class="input-group">
                    <input id="from-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control" readonly
                        name="created_from" value="{{ old('created_from') ?? request('created_from') }}" />
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <label for="validationCustom02">{{ trans('dashboard.department.archive_to_date') }} </label>
                <div class="input-group">
                    <input id="to-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control" readonly
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
                        <i class="mdi mdi-tray-arrow-down"></i> تصدير
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">PDF</a></li>
                        <li><a class="dropdown-item" href="#">Excel</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
                <button class="btn btn-primary mx-2" type="submit">
                    <i class="mdi mdi-magnify"></i> {{ trans('dashboard.department.search') }}
                </button>
                <a href="{{ route('dashboard.department.index') }}" class="btn btn-outline-primary">
                    <i class="mdi mdi-restore"></i>{{ trans('dashboard.department.show_all') }}
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
                            <th class="border-bottom-0">{{ trans('dashboard.department.department_name') }}</th>
                            <th class="border-bottom-0"> {{ trans('dashboard.department.department_main') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.department.archived_at') }} </th>
                            <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    @include('dashboard.layouts.modals.force_delete')
    @include('dashboard.layouts.modals.un_archive')
    @include('dashboard.layouts.modals.alert')

    <!--app-content closed-->
@endsection
@section('scripts')
    @include('dashboard.archive.department.script')
@endsection
