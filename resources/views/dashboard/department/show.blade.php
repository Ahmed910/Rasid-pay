@extends('dashboard.layouts.master')

@section('title', trans('dashboard.department.sub_progs.show'))


@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.department.index') }}">
                        {{ trans('dashboard.department.sub_progs.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.department.sub_progs.show') }} </li>
            </ol>
        </nav>

    </div>
    <!-- PAGE-HEADER END -->


    <!-- Row -->
    <div class="card py-7 px-7">
        <div class="row">
            <div class="col-12 col-md-4">
                <label>{{ trans('dashboard.department.department_name') }} :</label>
                <p class="text-muted"> {!! $department->name !!}</p>
            </div>
            <div class="col-12 col-md-4">
                <label>{{ trans('dashboard.department.main_department') }} :</label>
                <p class="text-muted">

                    {!! $department->parent->name ?? trans('dashboard.department.without_parent') !!}</p>
            </div>
            <div class="col-12 col-md-4">
                <label class="d-block" for="departmentName">{{ trans('dashboard.general.status') }} :</label>
                <p class="badge bg-{{ $department->is_active == 1 ? 'success' : 'danger' }}-opacity py-2 px-4">
                    {{ trans('dashboard.general.active_cases.' . $department->is_active) }}</p>
            </div>

            <div class="col-12 col-md-4">
                <label> {{ trans('dashboard.department.department_image') }}:</label>
                <img src="{{ $department->image }}" width="150" height="150" class="d-block rounded-3" alt=""
                    data-toggle="popoverIMG"
                    title='<img src="{{ $department->image }}" width="300" height="300" class="d-block rounded-3" alt="">'>
            </div>

            @if ($department->description != null)
                <div class="col-12 col-md-8">
                    <label class="d-block"
                        for="departmentName">{{ trans('dashboard.general.description') }}:</label>
                    <p class="text-muted">
                        {!! $department->description !!}
                    </p>
                </div>
            @endif
        </div>

    </div>
    <div class="row">
        <div class="col-12 text-end">
            <a href="{{ route('dashboard.department.edit', $department->id) }}" class="btn btn-primary">
                <i class="mdi mdi-square-edit-outline"></i> {{ trans('dashboard.general.edit') }}
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
            </a>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <label> {{ trans('dashboard.activity_log.history') }} </label>
    <div class="table-responsive p-1">
        <table id="historyTable" class="table table-bordered shadow-sm bg-body key-buttons historyTable">
            <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">{{ trans('dashboard.general.done_by') }} </th>
                    <th class="border-bottom-0"> {{ trans('dashboard.department.department_name') }}</th>
                    <th class="border-bottom-0">{{ trans('dashboard.activity_log.date') }} </th>
                    <th class="border-bottom-0">{{ trans('dashboard.activity_log.activity') }}</th>
                    <th class="border-bottom-0" style="max-width: 800px;">{{ trans('dashboard.general.reason') }}
                    </th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@include('dashboard.department.show-script')
