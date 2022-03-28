@extends('dashboard.layouts.master')
@section('title', 'Page Title')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">سجل الصلاحيات</h1>
  <a href="{!! route('dashboard.group.edit','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i> إضافة مجموعة
  </a>
</div>
<!-- PAGE-HEADER END -->

<!-- FORM OPEN -->
<form method="get" action="">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-3">
      <label for="groupName">اسم المجموعة</label>
      <input type="text" class="form-control" id="groupName" placeholder="اسم المجموعة" />
    </div>
    <div class="col-12 col-md-3">
      <label for="status">الحالة</label>
      <select class="form-control select2" id="status">
        <option selected disabled value="">اختر الحالة</option>
        <option>الجميع</option>
        <option>مفعلة</option>
        <option>معطله</option>
      </select>
    </div>

    <div class="col-12 col-md-3">
      <label for="userNumFrom">عدد المستخدمين من</label>
      <input type="text" class="form-control" id="userNumFrom" placeholder="0" />
    </div>
    <div class="col-12 col-md-3">
      <label for="userNumTo">عدد المستخدمين إلي</label>
      <input type="text" class="form-control" id="userNumTo" placeholder="0" />
    </div>
    <div class="col-12 col-md-6 mt-5">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-tray-arrow-down"></i> تصدير
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="#">PDF</a></li>
          <li><a class="dropdown-item" href="#">Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-6 mt-5 d-flex justify-content-end">
      <button class="btn btn-primary mx-2" type="submit">
        <i class="mdi mdi-magnify"></i> بحث
      </button>
      <button class="btn btn-outline-primary" type="submit">
        <i class="mdi mdi-restore"></i> عرض الكل
      </button>
    </div>
  </div>
</form>

<!-- FORM CLOSED -->
<!-- Row -->
<div class="row row-sm">
  <div class="col-lg-12">
    <div class="table-responsive p-1">
      <table id="ajaxTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
        <thead>
          <tr>
            <th class="border-bottom-0">#</th>
            <th class="border-bottom-0">اسم المجموعة</th>
            <th class="border-bottom-0">عدد المستخدمين</th>
            <th class="border-bottom-0">الحالة</th>
            <th class="border-bottom-0 text-center">العمليات</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.group.script')
