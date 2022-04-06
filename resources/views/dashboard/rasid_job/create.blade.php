@extends('dashboard.layouts.master')

@section('title', trans('dashboard.rasid_job.sub_progs.create'))
@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.rasid_job.index') }}">{{ trans('dashboard.rasid_job.sub_progs.index') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.rasid_job.sub_progs.create') }}
                </li>
            </ol>
        </nav>
    </div>
    {!! Form::open(['route' => 'dashboard.rasid_job.store', 'method' => 'POST', 'class' => 'needs-validation', 'id' => 'formId', 'novalidate']) !!}
    @include('dashboard.rasid_job._form', [
        'btn_submit' => trans('dashboard.general.save')
    ])
    {!! form::close() !!}

@endsection
