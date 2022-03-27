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
      <table id="historyTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
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
          <tr>
            <td>1</td>
            <td>
              جروب الموظفين
              <i class="mdi mdi-clipboard-list" tabindex="1" data-bs-toggle="popoverRoles"></i>
            </td>
            <td>50</td>
            <td>
              <span class="badge bg-success-opacity py-2 px-4">
                مفعلة</span>
            </td>
            <td class="text-center">
              <a href="{!! route('dashboard.group.show','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="عرض"><i class="mdi mdi-eye-outline"></i></a>
              <a href="{!! route('dashboard.group.edit','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>
              جروب المستخدمين
              <i class="mdi mdi-clipboard-list" tabindex="2" data-bs-toggle="popoverRoles"></i>
            </td>
            <td>62</td>
            <td>
              <span class="badge bg-danger-opacity py-2 px-4">
                معطله</span>
            </td>
            <td class="text-center">
              <a href="{!! route('dashboard.group.show','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="عرض"><i class="mdi mdi-eye-outline"></i></a>
              <a href="{!! route('dashboard.group.edit','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>
            </td>
          </tr>


          <tr>
            <td>3</td>
            <td>
              جروب العملاء
              <i class="mdi mdi-clipboard-list" tabindex="3" data-bs-toggle="popoverRoles"></i>
            </td>
            <td>36</td>
            <td>
              <span class="badge bg-success-opacity py-2 px-4">
                مفعلة</span>
            </td>
            <td class="text-center">
              <a href="{!! route('dashboard.group.show','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="عرض"><i class="mdi mdi-eye-outline"></i></a>
              <a href="{!! route('dashboard.group.edit','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>
            </td>
          </tr>


          <tr>
            <td>4</td>
            <td>
              جروب الإداريين
              <i class="mdi mdi-clipboard-list" tabindex="4" data-bs-toggle="popoverRoles"></i>
            </td>
            <td>62</td>
            <td>
              <span class="badge bg-success-opacity py-2 px-4">
                مفعلة</span>
            </td>
            <td class="text-center">
              <a href="{!! route('dashboard.group.show','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="عرض"><i class="mdi mdi-eye-outline"></i></a>
              <a href="{!! route('dashboard.group.edit','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>
            </td>
          </tr>


          <tr>
            <td>5</td>
            <td>
              جروب المراجعين
              <i class="mdi mdi-clipboard-list" tabindex="5" data-bs-toggle="popoverRoles"></i>
            </td>
            <td>15</td>
            <td>
              <span class="badge bg-danger-opacity py-2 px-4">
                معطله</span>
            </td>
            <td class="text-center">
              <a href="{!! route('dashboard.group.show','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="عرض"><i class="mdi mdi-eye-outline"></i></a>
              <a href="{!! route('dashboard.group.edit','c5529d54-3900-4b35-95ed-39a21568031a') !!}" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.group.script')
