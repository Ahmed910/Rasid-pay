@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('nav-title')
@endsection

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
                                <a href="{{ route('dashboard.department.index') }}"> سجل الأقسام</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                تعديل قسم
                            </li>
                        </ol>
                    </nav>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW OPEN -->
                {!! Form::model($department, ['route' => ['dashboard.department.update', $department->id], 'method' => 'PUT', 'class' => 'needs-validation', 'enctype' => 'multipart/form-data','id' =>'formId', 'files' => true]) !!}
                @include('dashboard.department._form')
                {!! Form::close() !!}
                <!-- ROW CLOSED -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>

    <!--app-content closed-->
@endsection
@include('dashboard.department.script')
