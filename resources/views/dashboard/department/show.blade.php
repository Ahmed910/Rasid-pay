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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.department.index') }}"> سجل
                                    الأقسام</a></li>
                            <li class="breadcrumb-item active" aria-current="page">عرض القسم</li>
                        </ol>
                    </nav>

                </div>
                <!-- PAGE-HEADER END -->


                <!-- Row -->
                <div class="card py-7 px-7">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <label>اسم القسم:</label>
                            <p class="text-muted"> {!! $department->name !!}</p>
                        </div>
                        <div class="col-12 col-md-4">
                            <label>القسم الرئيسي:</label>
                            <p class="text-muted">
                                {!! isset($department->parent->name) ? $department->parent->name : '' !!}</p>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="d-block" for="departmentName">الحالة:</label>
                            @if ($department->is_active == 1)
                                <p class="badge bg-success-opacity py-2 px-4">مفعل</p>
                            @else
                                <p class="badge bg-danger-opacity py-2 px-4">معطل</p>
                            @endif

                        </div>
                        <div class="col-12 col-md-4">
                            <label>صورة القسم:</label>
                            <img src="{{ asset("{$department->images[0]->media}") }}" width="150" height="150"
                                class="d-block rounded-3" alt="" data-toggle="popoverIMG" title='<img src="{{ asset("{$department->images[0]->media}") }}" width="150" height="150" class="d-block rounded-3" alt=""
                                        data-toggle="popoverIMG" >'>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="d-block" for="departmentName">الوصف:</label>
                            <p class="text-muted">
                                {!! $department->description !!}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('dashboard.department.edit', $department->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-square-edit-outline"></i> تعديل
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-arrow-left"></i> عودة
                        </a>
                    </div>
                </div>
                <!-- End Row -->

                <!-- Row -->
                <label>الحركة التاريخية</label>
                <div class="table-responsive p-1">
                    <table id="historyTable" class="table table-bordered shadow-sm bg-body key-buttons historyTable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">تم بواسطة</th>
                                <th class="border-bottom-0">اسم القسم</th>
                                <th class="border-bottom-0">تاريخ النشاط</th>
                                <th class="border-bottom-0">
                                    النشاط
                                </th>
                                <th class="border-bottom-0" style="max-width: 800px;">السبب</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- End Row -->

                <!-- Row -->



                <!-- End Row -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
    <!--app-content closed-->
@endsection
@include('dashboard.department.script')
