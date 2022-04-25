@extends('dashboard.layouts.master')
@section('title', trans('dashboard.activity_log.sub_progs.index'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ trans('dashboard.activity_log.sub_progs.index') }}</h1>
    </div>
    <!-- PAGE-HEADER END -->
   

    <!-- FORM CLOSED -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="p-1">
                <table id="activitylogtable"
                    class="table table-bordered dt-responsive nowrap shadow-sm bg-body key-buttons historyTable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">{{ trans('dashboard.employee.employee') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.department.department') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.activity_log.main_program') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.activity_log.sub_program') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }}</th>
                            <th class="border-bottom-0">{{ trans('dashboard.activity_log.ip_address') }}</th>
                            <th class="border-bottom-0 text-center">{{ trans('dashboard.activity_log.activity') }}</th>
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
@include('dashboard.transaction.script')
