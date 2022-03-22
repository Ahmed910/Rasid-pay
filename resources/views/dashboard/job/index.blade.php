@extends('dashboard.layouts.master')
@include('dashboard.job2.style')

@section('nav-title')
@endsection

@section('content')
  <!--app-content open-->
  <div class="main-content app-content mt-0">
    <div class="side-app">
      <!-- CONTAINER -->
      <div class="main-container container-fluid">
        <!-- PAGE-HEADER -->
        <div class="page-header">
          <h1 class="page-title">{{ trans('dashboard.job.sub_progs.index') }}</h1>
          <a href="{{ route('dashboard.jobs.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.job.add_job') }}
          </a>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- FORM OPEN -->
        <form method="get" action="{{ route('dashboard.jobs.index') }}">
          <div class="row align-items-end mb-3">
            <div class="col">
              <label for="job_name">{{ trans('dashboard.job.job_name') }}</label>

              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('dashboard.job.job_name'), 'id' => 'job_name']) !!}
            </div>
            <div class="col">
              <label for="mainDepartment"> {{ trans('dashboard.job.department') }} </label>
              {{--              <select class="form-control select2"--}}

              {{--                      name="department_id">--}}
              {{--                <option selected disabled value="">{{ trans('dashboard.job.select_department') }}</option>--}}
              {{--                @foreach ($departments as $id => $name)--}}
              {{--                  <option value="{{ $id }}"--}}
              {{--                    {{ (old('department_id') ?? request('department_id')) == $id ? 'selected' : '' }}--}}
              {{--                  >--}}
              {{--                    {{ $name }}</option>--}}
              {{--                @endforeach--}}
              {{--              </select>--}}
              {!! Form::select('department_id', $departments, "ll", ['placeholder' => trans('dashboard.job.select_department'),'class' => 'form-control select2-show-search select2-hidden-accessible select2 select2-container  select2-container--below', 'id' => 'mainDepartment',] , ) !!}
            </div>
            <div class="col">
              <label for="from-hijri-picker"> {{ trans('dashboard.job.from_date') }}</label>
              <div class="input-group">

                {!! Form::date('from_date', null, ['class' => 'form-control', 'id' => 'from-hijri-picker']) !!}
                <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <label for="to-hijri-picker"> {{ trans('dashboard.job.to_date') }}</label>
              <div class="input-group">

                {!! Form::date('to_date', null, ['class' => 'form-control', 'placeholder' => 'يوم/شهر/سنة', 'id' => 'to-hijri-picker']) !!}

                <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <label for="status">{{ trans('dashboard.job.status') }}</label>
              <select name = "is_active" class="form-control select2" id="status">
                <option selected disabled value="">
                  {{ trans('dashboard.job.select_status') }}
                </option>
                <option value="">{{ trans('dashboard.job.all') }}</option>
                <option value=1>{{ trans('dashboard.job.is_active.active') }}</option>
                <option value=0>{{ trans('dashboard.job.is_active.disactive') }}</option>
              </select>
            </div>

            <div class="col">
              <label for="type">{{ trans('dashboard.job.type') }}</label>
              <select class="form-control select2" id="type" name="is_vacant">
                <option selected disabled value="">{{ trans('dashboard.job.select_type') }}</option>
                <option value="">{{ trans('dashboard.job.all') }}</option>
                <option value=1>{{ trans('dashboard.job.is_vacant.false') }}</option>
                <option value=0>{{ trans('dashboard.job.is_vacant.true') }}</option>
              </select>
            </div>

          </div>
          <div class="row">
            <div class="col-12 col-md-6 my-2">
              <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
                <i class="mdi mdi-magnify"></i> {{ trans('dashboard.job.search') }}
              </button>
              <button class="btn btn-outline-primary" type="submit">
                <i class="mdi mdi-restore"></i> {{ trans('dashboard.job.show_all') }}
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
                  <th class="border-bottom-0">{{ trans('dashboard.job.department') }} </th>
                  <th class="border-bottom-0">{{ trans('dashboard.job.created_at') }} </th>
                  <th class="border-bottom-0">{{ trans('dashboard.job.status') }}</th>
                  <th class="border-bottom-0">{{ trans('dashboard.job.type') }}</th>
                  <th class="border-bottom-0 text-center">{{ trans('dashboard.job.actions') }}</th>
                </tr>
                </thead>
                <tbody>


                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- End Row -->
      </div>
      <!-- CONTAINER CLOSED -->
    </div>
  </div>
  <!--app-content closed-->
@endsection

@section('scripts')
  @include('dashboard.job.script')
@endsection
