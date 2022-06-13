@extends('dashboard.layouts.master')

@section('title', trans('dashboard.department.edit_department'))

@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.department.index') }}">
                        {{ trans('dashboard.department.sub_progs.index') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('dashboard.department.edit_department') }}

                </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW OPEN -->
    {!! Form::model($department, ['route' => ['dashboard.department.update', $department->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate','autocomplete'=>"off"]) !!}
    @include('dashboard.department._form', [
        'createVal' => 1,
        'appendArray' => ['' => '', 'without' => trans('dashboard.department.without_parent')],
    ])
    {!! Form::close() !!}

@endsection
