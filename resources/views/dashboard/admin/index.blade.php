@extends('dashboard.layouts.master')
@section('title', trans('dashboard.admin.sub_progs.index'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.admin.sub_progs.index') }}</h1>
  <a href="{!! route('dashboard.admin.create') !!}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.admin.sub_progs.create') }}
  </a>
</div>
<!-- PAGE-HEADER END -->
<!-- FORM OPEN -->

<form method="get" action="">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-3">
      <label for="userName">اسم المستخدم</label>
      <input
        type="text"
        class="form-control"
        id="userName"
        placeholder="اسم المستخدم"
      />
    </div>
    <div class="col-12 col-md-3">
      <label for="userID">رقم المستخدم</label>
      <input
        type="number"
        class="form-control"
        id="userID"
        placeholder="رقم المستخدم"
      />
    </div>
    <div class="col-12 col-md-3">
      <label for="mainDepartment">القسم </label>
      <select class="form-control select2" id="mainDepartment">
        <option selected disabled value="">اختر قسم</option>
        <option>قسم البرمجيات</option>
        <option>قسم التصميم</option>
        <option>قسم الجودة</option>
        <option>قسم تحليل المتطلبات</option>
      </select>
    </div>
    <div class="col-12 col-md-3">
      <label for="status">الحالة</label>
      <select class="form-control select2" id="status">
        <option selected disabled value="">اختر الحالة</option>
        <option>الجميع</option>
        <option>مفعل</option>
        <option value="hold">معطل لفترة</option>
        <option>معطل دائم</option>
      </select>
    </div>
  </div>
   <div class="row align-items-end mb-3">

    <div class="col-12 col-md-3 hold">
      <label for="validationCustom02"> معطل لفترة (من)</label>
      <div class="input-group">
        <input
          id="from-hijri-unactive-picker"
          type="text"
          placeholder="يوم/شهر/سنة"
          class="form-control"
        />
        <div class="input-group-text border-start-0">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 hold">
      <label for="validationCustom02"> معطل لفترة (إلى)</label>
      <div class="input-group">
        <input
          id="to-hijri-unactive-picker"
          type="text"
          placeholder="يوم/شهر/سنة"
          class="form-control"
        />
        <div class="input-group-text border-start-0">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <label for="validationCustom02"> تاريخ الإنشاء (من)</label>
      <div class="input-group">
        <input
          id="from-hijri-picker"
          type="text"
          placeholder="يوم/شهر/سنة"
          class="form-control"
        />
        <div class="input-group-text border-start-0">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <label for="validationCustom02"> تاريخ الإنشاء (إلى)</label>
      <div class="input-group">
        <input
          id="to-hijri-picker"
          type="text"
          placeholder="يوم/شهر/سنة"
          class="form-control"
        />
        <div class="input-group-text border-start-0">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-12 col-md-6 my-2">
      <div class="dropdown">
        <button
          class="btn btn-outline-primary dropdown-toggle"
          type="button"
          id="dropdownMenuButton1"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <i class="mdi mdi-tray-arrow-down"></i> تصدير
        </button>
        <ul
          class="dropdown-menu"
          aria-labelledby="dropdownMenuButton1"
        >
          <li><a class="dropdown-item" href="#">PDF</a></li>
          <li><a class="dropdown-item" href="#">Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
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
      <table
        id="historyTable"
        class="table table-bordered shadow-sm bg-body text-nowrap key-buttons"
      >
        <thead>
          <tr>
            <th class="border-bottom-0">#</th>
            <th class="border-bottom-0">اسم المستخدم</th>
            <th class="border-bottom-0">رقم المستخدم</th>
            <th class="border-bottom-0">القسم</th>
            <th class="border-bottom-0">تاريخ الإنشاء</th>
            <th class="border-bottom-0">الحالة</th>
            <th class="border-bottom-0 text-center">العمليات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>محمد رمضان</td>
            <td>863254</td>
            <td>قسم الجودة</td>
            <td>20 يناير 2022</td>
            <td>
              <span class="badge bg-danger-opacity py-2 px-4">
                معطل دائم</span
              >
            </td>
            <td class="text-center">
              <a
                href="user-view.html"
                class="azureIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="عرض"
                ><i class="mdi mdi-eye-outline"></i
              ></a>
              <a
                href="user-add.html"
                class="warningIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تعديل"
                ><i class="mdi mdi-square-edit-outline"></i
              ></a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>هشام أشرف</td>
            <td>156987</td>
            <td>قسم التصميم</td>
            <td>15 يناير 2022</td>
            <td>
              <span class="badge bg-success-opacity py-2 px-4">
                مفعل</span
              >
            </td>
            <td class="text-center">
              <a
                href="user-view.html"
                class="azureIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="عرض"
                ><i class="mdi mdi-eye-outline"></i
              ></a>
              <a
                href="user-add.html"
                class="warningIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تعديل"
                ><i class="mdi mdi-square-edit-outline"></i
              ></a>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>محمد رضا</td>
            <td>658943</td>
            <td>قسم الإداريين</td>
            <td>13 مارس 2022</td>
            <td>
              <span class="badge bg-success-opacity py-2 px-4">
                مفعل</span
              >
            </td>
            <td class="text-center">
              <a
                href="user-view.html"
                class="azureIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="عرض"
                ><i class="mdi mdi-eye-outline"></i
              ></a>
              <a
                href="user-add.html"
                class="warningIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تعديل"
                ><i class="mdi mdi-square-edit-outline"></i
              ></a>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>أحمد إسماعيل</td>
            <td>654892</td>
            <td>قسم البرمجيات</td>
            <td>13 يناير 2022</td>
            <td>
              <span class="badge bg-danger-opacity py-2 px-4" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="من  (7 شعبان 1443) <br><br> إلى  (14 شعبان 1443) ">
                معطل لفترة</span
              >
            </td>
            <td class="text-center">
              <a
                href="user-view.html"
                class="azureIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="عرض"
                ><i class="mdi mdi-eye-outline"></i
              ></a>
              <a
                href="user-add.html"
                class="warningIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تعديل"
                ><i class="mdi mdi-square-edit-outline"></i
              ></a>
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>طه محمد</td>
            <td>236548</td>
            <td>قسم المالية</td>
            <td>20 فيراير 2022</td>
            <td>
              <span class="badge bg-success-opacity py-2 px-4">
                مفعل</span
              >
            </td>
            <td class="text-center">
              <a
                href="user-view.html"
                class="azureIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="عرض"
                ><i class="mdi mdi-eye-outline"></i
              ></a>
              <a
                href="user-add.html"
                class="warningIcon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تعديل"
                ><i class="mdi mdi-square-edit-outline"></i
              ></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- End Row -->

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.admin.script')
