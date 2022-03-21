@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('nav-title')
@endsection

@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">سجل الأقسام</h1>
                    <a href="department-add.html" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle-outline"></i> إضافة قسم
                    </a>
                </div>
                <form method="get" action="" id="search-form">
                    <div class="row align-items-end mb-3">
                        <div class="col">
                            <label for="departmentName">اسم القسم</label>
                            <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم" name="name"
                                value="{{ old('name') ?? request('name') }}" />
                        </div>
                        <div class="col">
                            <label>القسم الرئيسي</label>
                            <select class="form-control select2" data-placeholder="اختر قسم رئيسي" name="parent_id">
                                <option selected disabled value="">اختر قسم رئيسي</option>
                                @foreach ($parentDepartments as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ (old('parent_id') ?? request('parent_id')) == $id ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="validationCustom02"> تاريخ الإنشاء (من)</label>
                            <div class="input-group">
                                <input id="from-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control"
                                    name="created_from" value="{{ old('created_from') ?? request('created_from') }}" />
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="validationCustom02"> تاريخ الإنشاء (إلى)</label>
                            <div class="input-group">
                                <input id="to-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control"
                                    name="created_to" value="{{ old('created_to') ?? request('created_to') }}" />
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="status">الحالة</label>
                            <select class="form-control select2" id="status" name="is_active">
                                <option selected disabled value="">اختر الحالة</option>
                                <option value="">الجميع</option>
                                <option value="1" {{ request('is_active') == "1" ? 'selected' : '' }}>مفعل</option>
                                <option value="0" {{ request('is_active') == "0" ? 'selected' : '' }}>معطل</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 my-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-tray-arrow-down"></i> تصدير
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    <li><a class="dropdown-item" href="#">Excel</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
                            <button class="btn btn-primary mx-2" type="submit">
                                <i class="mdi mdi-magnify"></i> بحث
                            </button>
                            <a href="{{ route('dashboard.department.index') }}" class="btn btn-outline-primary">
                                <i class="mdi mdi-restore"></i> عرض الكل
                            </a>
                        </div>
                    </div>
                </form>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="table-responsive p-1">
                            <table id="departmentTable"
                                class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">اسم القسم</th>
                                        <th class="border-bottom-0">القسم الرئيسي</th>
                                        <th class="border-bottom-0">تاريخ الإنشاء</th>
                                        <th class="border-bottom-0">الحالة</th>
                                        <th class="border-bottom-0 text-center">العمليات</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('dashboard.department.script')
@endsection
