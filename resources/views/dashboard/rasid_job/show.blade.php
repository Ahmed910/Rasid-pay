@extends('dashboard.layouts.master')

@section('title', trans('dashboard.rasid_job.sub_progs.show'))

@section('content')
    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.rasid_job.index') }}">
                        {{ trans('dashboard.rasid_job.sub_progs.index') }} </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.rasid_job.sub_progs.show') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="card py-7 px-7">
        <div class="row">
            <div class="col-12 col-md-3">
                <label>{{ trans('dashboard.rasid_job.name') }} </label>
                <p>{{ $rasidJob->name }}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>{{ trans('dashboard.department.department') }}</label>
                <p>{{ $rasidJob->department->name }}</p>
            </div>
            <div class="col-12 col-md-3">
                <label class="d-block" for="departmentName">{{ trans('dashboard.general.status') }}</label>
                <p class="badge bg-{{ $rasidJob->is_active == 1 ? 'success' : 'danger' }}-opacity py-2 px-4">
                    {{ trans('dashboard.rasid_job.active_cases.' . $rasidJob->is_active) }}</p>
            </div>
            <div class="col-12 col-md-3">
                <label class="d-block" for="departmentName">{{ trans('dashboard.general.type') }}</label>
                <p class="occupied">
                    {{ trans('dashboard.general.job_type_cases.' . $rasidJob->is_vacant) }}
                </p>
            </div>
          @if ( $rasidJob->employee?->user?->fullname )
            <div class="col-12 col-md-3">
              <label class="d-block" for="departmentName">{{ trans('dashboard.rasid_job.employee_name') }}
                </label>
              <p> {{ $rasidJob->employee?->user?->fullname }}</p>
            </div>
          @endif
        @if ($rasidJob->description)
            <div class="col-12 col-md-9">
            <label class="d-block"
                   for="departmentName">{{ trans('dashboard.rasid_job.rasid_job_description') }}
              </label>
            <p>
              {{$rasidJob->description }}
            </p>
          </div>
          @endif

        </div>
    </div>

    <div class="row">
        <div class="col-12 text-end">
            <a href="{{ route('dashboard.rasid_job.edit', $rasidJob->id) }}" class="btn btn-primary">
                <i class="mdi mdi-square-edit-outline"></i> {{ trans('dashboard.general.edit') }}
            </a>


            <a href="{{ URL::previous() }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
            </a>

        </div>
    </div>

    <label> {{ trans('dashboard.activity_log.history') }} </label>
    <div class="table-responsive p-1">
        <table id="historyTable" class="table table-bordered shadow-sm bg-body key-buttons historyTable">
            <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">{{ trans('dashboard.general.done_by') }}</th>
                    <th class="border-bottom-0"> {{ trans('dashboard.department.department_name') }} </th>
                    <th class="border-bottom-0">{{ trans('dashboard.activity_log.date') }} </th>
                    <th class="border-bottom-0">{{ trans('dashboard.activity_log.activity') }}</th>
                    <th class="border-bottom-0" style="max-width: 800px;">{{ trans('dashboard.general.reason') }}
                    </th>
                </tr>
            </thead>
        </table>
    </div>

@endsection
@include('dashboard.rasid_job.show-script')
