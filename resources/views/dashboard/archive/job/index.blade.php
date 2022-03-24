@extends('dashboard.layouts.master')

@section('nav-title')
@endsection

@section('content')
            <div class="page-header">
              <h1 class="page-title">{{ trans('dashboard.rasid_job.sub_progs.archive') }}</h1>

            </div>
            <!-- PAGE-HEADER END -->

            <!-- FORM OPEN -->

            <form method="get" action="">
              <div class="row align-items-end mb-3">
                <div class="col">
                  <label for="job_name">{{ trans('dashboard.job.job_name') }}</label>
                  {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('dashboard.job.job_name'), 'id' => 'job_name']) !!}
                </div>
                <div class="col">
                  <label for="mainDepartment"> {{ trans('dashboard.job.department') }} </label>

                  {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search form-select', 'placeholder' => trans('dashboard.job.select_department'), 'id' => 'mainDepartment']) !!}
              </div>
              <div class="col">
                <label for="status">{{ trans('dashboard.job.status') }}</label>
                <select class="form-control select2" id="status">
                    <option selected disabled value="">
                        {{ trans('dashboard.job.select_status') }}
                    </option>
                    <option value="">{{ trans('dashboard.job.all') }}</option>
                    <option value=true>{{ trans('dashboard.job.is_active.active') }}</option>
                    <option value=false>{{ trans('dashboard.job.is_active.disactive') }}</option>
                </select>
            </div>
            <div class="col">
              <label for="from-hijri-picker"> {{ trans('dashboard.job.archive_from_date') }}</label>
              <div class="input-group">

                  {!! Form::date('from_date', null, ['class' => 'form-control', 'id' => 'from-hijri-picker']) !!}
                  <div class="input-group-text border-start-0">
                      <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
              </div>
          </div>
          <div class="col">
            <label for="to-hijri-picker"> {{ trans('dashboard.job.archive_to_date') }}</label>
            <div class="input-group">

                {!! Form::date('to_date', null, ['class' => 'form-control', 'placeholder' => 'يوم/شهر/سنة', 'id' => 'to-hijri-picker']) !!}

                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
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
                  <table
                    id="jobTable"
                    class="table table-bordered shadow-sm bg-body text-nowrap key-buttons"
                  >
                    <thead>
                      <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">{{ trans('dashboard.job.job_name') }}</th>
                        <th class="border-bottom-0">{{ trans('dashboard.job.department') }} </th>
                        <th class="border-bottom-0">{{ trans('dashboard.job.archived_at') }} </th>
                        <th class="border-bottom-0">{{ trans('dashboard.job.is_active') }}</th>
                        <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
                      </tr>
                    </thead>

                  </table>
                </div>
              </div>
            </div>
            <!-- End Row -->

    @endsection
    @section('scripts')
        @include('dashboard.archive.job.script')
    @endsection
