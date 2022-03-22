@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('title', trans('dashboard.department.edit_department'))

@section('content')
    <!--app-content open-->

    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
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
                {!! Form::model($department, ['route' => ['dashboard.department.update', $department->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'enctype' => 'multipart/form-data', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
                @include('dashboard.department._form')
                {!! Form::close() !!}
                <!-- ROW CLOSED -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>

    <!--app-content closed-->
@endsection
