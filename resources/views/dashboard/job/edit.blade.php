@extends('dashboard.layouts.master')

@section('title', trans('dashboard.job.edit_job'))

@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.job.index') }}">
                        {{ trans('dashboard.job.sub_progs.index') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.job.edit_job') }}

                </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW OPEN -->
    {!! Form::model($rasidJob, ['route' => ['dashboard.job.update', $rasidJob->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'novalidate']) !!}
    @include('dashboard.job._form', [
        'btn_submit' => trans('dashboard.general.edit')
    ])
    {!! Form::close() !!}

@endsection
