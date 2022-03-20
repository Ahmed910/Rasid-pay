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
                                {!! trans('dashboard.job.edit_job') !!}
                            </li>
                        </ol>
                    </nav>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW OPEN -->

                {!! Form::model($job, ['route' => ['dashboard.jobs.update', $job->id], 'method' => 'PUT', 'files' => true, 'class' => 'steps-validation wizard-circle needs-validation', 'data-locale' => app()->getLocale()]) !!}
                @include('dashboard.job2._form')
                {!! Form::close() !!}
            </div>
            </section>
        </div>

    </div>
@endsection
@include('dashboard.job2.script')
