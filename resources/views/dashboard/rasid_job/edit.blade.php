@extends('dashboard.layouts.master')

@section('title', trans('dashboard.rasid_job.edit_job'))

@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.rasid_job.index') }}">
                        {{ trans('dashboard.rasid_job.sub_progs.index') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.rasid_job.edit_job') }}

                </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW OPEN -->
    {!! Form::model($rasidJob, ['route' => ['dashboard.rasid_job.update', $rasidJob->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'novalidate','autocomplete'=>"off"]) !!}
    @include('dashboard.rasid_job._form')
    {!! Form::close() !!}

@endsection
