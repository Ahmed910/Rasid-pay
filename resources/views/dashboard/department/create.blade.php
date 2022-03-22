@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('title', trans('dashboard.department.sub_progs.create'))

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
                {!! Form::open(['route' => 'dashboard.department.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'id' => 'formId', 'novalidate']) !!}
                @include('dashboard.department._form')
                {!! Form::close() !!}
                <!-- ROW CLOSED -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>

    <!--app-content closed-->
@endsection
