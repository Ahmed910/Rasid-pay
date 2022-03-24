@extends('dashboard.layouts.master')

@section('title', trans('dashboard.job.sub_progs.create'))
@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.job.index') }}">{{ trans('dashboard.job.sub_progs.index') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.job.sub_progs.create') }}
                </li>
            </ol>
        </nav>
    </div>
    {!! Form::open(['route' => 'dashboard.job.store', 'method' => 'POST', 'class' => 'needs-validation', 'id' => 'formId', 'novalidate']) !!}
    @include('dashboard.job._form', [
        'btn_submit' => trans('dashboard.general.save')
    ])
    {!! form::close() !!}

@endsection
