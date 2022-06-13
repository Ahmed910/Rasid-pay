@extends('dashboard.layouts.master')

@section('title', trans('dashboard.department.sub_progs.create'))

@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.department.index') }}">{{ trans('dashboard.department.sub_progs.index') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.department.sub_progs.create') }}
                </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW OPEN -->
    {!! Form::open(['route' => 'dashboard.department.store', 'method' => 'POST', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate' , 'autocomplete'=>"off"]) !!}
    @include('dashboard.department._form', [
        'createVal' => 0,
        'appendArray' => ['' => ''],
    ])
    {!! Form::close() !!}

@endsection
