@extends('dashboard.layouts.master')
@include('dashboard.job2.style')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="jobs-record.html">{{ trans('dashboard.job.sub_progs.index') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {!! trans('dashboard.job.add_job') !!}
                            </li>
                        </ol>
                    </nav>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW OPEN -->

                    {!! Form::open(['route' => 'dashboard.jobs.store' , 'method' => 'POST' , 'files' => true ,'class' => 'steps-validation wizard-circle needs-validation','data-locale' => app()->getLocale()]) !!}
                    @include('dashboard.job2._form')
                    {!! Form::close() !!}
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
@endsection
