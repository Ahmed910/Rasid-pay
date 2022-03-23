@extends('dashboard.layouts.master')

@section('title', trans('dashboard.job.sub_progs.index'))

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ trans('dashboard.job.sub_progs.index') }}</h1>
        <a href="{{ route('dashboard.job.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.job.add_job') }}
        </a>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- FORM OPEN -->
    <form method="get" action="{{ route('dashboard.job.index') }}">
        <div class="row align-items-end mb-3">
            <div class="col">
                <label for="job_name">{{ trans('dashboard.job.job_name') }}</label>

                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('dashboard.job.job_name'), 'id' => 'job_name']) !!}
            </div>
            <div class="col">
                <label for="mainDepartment"> {{ trans('dashboard.department.department') }} </label>

                {!! Form::select('department_id', $departments, null, ['placeholder' => trans('dashboard.job.select_department'), 'class' => 'form-control select2-show-search', 'id' => 'mainDepartment']) !!}
            </div>



            <div class="col">
                <label for="from-hijri-picker"> {{ trans('dashboard.general.from_date') }}</label>
                <div class="input-group">

                    {!! Form::text('from_date', null, ['class' => 'form-control', 'id' => 'from-hijri-picker', 'placeholder' => trans('dashboard.general.day_month_year'), 'readonly']) !!}
                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>



            <div class="col">
                <label for="to-hijri-picker"> {{ trans('dashboard.general.to_date') }}</label>
                <div class="input-group">

                    {!! Form::text('to_date', null, ['class' => 'form-control', 'placeholder' => trans('dashboard.general.day_month_year'), 'id' => 'to-hijri-picker', 'readonly']) !!}

                    <div class="input-group-text border-start-0">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                </div>
            </div>

            <div class="col">
                <label for="status">
                    @lang('dashboard.general.status')</label>
                {!! Form::select('is_active', trans('dashboard.general.active_cases'), null, ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.general.select_status'), 'id' => 'status']) !!}
            </div>

            <div class="col">
                <label for="type">
                    @lang('dashboard.general.type')</label>
                {!! Form::select('is_vacant', trans('dashboard.general.job_type_cases'), null, ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.general.select_type'), 'id' => 'type']) !!}
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
                    <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
                </button>
                <button class="btn btn-outline-primary" type="submit">
                    <i class="mdi mdi-restore"></i> {{ trans('dashboard.general.show_all') }}
                </button>
            </div>
        </div>

    </form>

    <!-- FORM CLOSED -->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="table-responsive p-1">
                <table id="JobsTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">{{ trans('dashboard.job.job_name') }}</th>

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
    </div>
    <!-- End Row -->

    <!--app-content closed-->
@endsection

@section('scripts')
    @include('dashboard.job.script')
@endsection
