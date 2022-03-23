@extends('dashboard.layouts.master')
@section('title', trans('dashboard.activity_log.sub_progs.index'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.activity_log.sub_progs.index') }}</h1>
</div>
<!-- PAGE-HEADER END -->
<!-- FORM OPEN -->
<form method="get" action="">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-3">
      <label for="activityName"> النشاط</label>
      <select
        class="form-control select2-show-search form-select"
        data-placeholder="اختر نشاط"
        id="activityName"
      >
        <option selected disabled value="">اختر نشاط</option>
        <option>الجميع</option>
        <option>تعديل</option>
        <option>إضافة</option>
        <option>أرشفة</option>
        <option>استعادة</option>
        <option>حذف نهائي</option>
      </select>
    </div>
    <div class="col-12 col-md-3">
      <label for="employee">الموظف</label>
      <select
        class="form-control select2-show-search form-select"
        data-placeholder="اختر موظف"
        id="employee"
      >
        <option selected disabled value="">
          اختر اسم الموظف
        </option>
        <option>الجميع</option>
        <option>محمد رمضان</option>
        <option>هشام أشرف</option>
        <option>أحمد اسماعيل</option>
      </select>
    </div>
    <div class="col-12 col-md-3">
      <label for="mainDepartment">القسم </label>
      <select
        class="form-control select2-show-search form-select"
        data-placeholder="اختر قسم "
        id="mainDepartment"
      >
        <option selected disabled value="">اختر قسم</option>
        <option>الجميع</option>
        <option>قسم البرمجيات</option>
        <option>قسم التصميم</option>
        <option>قسم الجودة</option>
        <option>قسم تحليل المتطلبات</option>
      </select>
    </div>
    <div class="col-12 col-md-3">
      <label for="mainProgram">البرنامج الرئيسي</label>
      <select
        class="form-control select2-show-search form-select"
        data-placeholder="اختر برنامج رئيسي "
        id="mainProgram"
      >
        <option disabled value="">
          اختر برنامج رئيسي
        </option>
        <option>الجميع</option>
        <option>العملاء</option>
        <option>المستخدمين</option>
        <option>الصلاحيات</option>
        <option>الموظفين</option>
      </select>
    </div>
    <div class="col-12 col-md-3 mt-3">
      <label for="branchProgram">البرنامج الفرعي</label>
      <select
        class="form-control select2-show-search form-select"
        data-placeholder="اختر برنامج فرعي "
        id="branchProgram"
      >
        <option disabled value="">
          اختر برنامج فرعي
        </option>
        <option>الجميع</option>
        <option>سجل العملاء</option>
        <option>سجل المستخدمين</option>
        <option>سجل الصلاحيات</option>
        <option>سجل الموظفين</option>
      </select>
    </div>
    <div class="col-12 col-md-3 mt-3">
      <label for="validationCustom02"> الفترة (من)</label>
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
    <div class="col-12 col-md-3 mt-3">
      <label for="validationCustom02"> الفترة (إلى)</label>
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
      <button class="btn btn-outline-primary" type="submit">
        <i class="mdi mdi-printer"></i> طباعة تقرير
      </button>
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
        id="table-details"
        class="table table-bordered dt-responsive nowrap shadow-sm bg-body key-buttons historyTable"
      >
        <thead>
          <tr>
            <th class="border-bottom-0">#</th>
            <th class="border-bottom-0">الموظف</th>
            <th class="border-bottom-0">القسم</th>
            <th class="border-bottom-0">البرنامج الرئيسي</th>
            <th class="border-bottom-0">البرنامج الفرعي</th>
            <th class="border-bottom-0">التاريخ / الوقت</th>
            <th class="border-bottom-0">رقم معرف الجهاز</th>
            <th class="border-bottom-0 text-center">النشاط</th>
            <th class="border-bottom-0 text-center">
              تفاصيل النشاط
            </th>
            <th class="border-bottom-0 text-center">العمليات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>محمد رمضان</td>
            <td>قسم البرمجيات</td>
            <td>العملاء</td>
            <td>سجل العملاء</td>
            <td>20 يناير 2022 / 09:00 صباحاً</td>
            <td>00-14-7B-EE-19-F8</td>
            <td class="text-center">
              <span class="badge bg-warning-opacity py-2 px-4"
                >تعديل</span
              >
            </td>
            <td>
              <p>
                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                الخارجي للنص أو شكل توضع الفقرات في الصفحة التي
                يقرأها.
              </p>
            </td>
            <td data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تفاصيل النشاط"></td>
          </tr>
          <tr>
            <td>2</td>
            <td>طه محمد</td>
            <td>قسم البرمجيات</td>
            <td>الموظفين</td>
            <td>سجل الموظفين</td>
            <td>20 يناير 2022 / 01:00 مساءاً</td>
            <td>00-14-7B-EE-19-F8</td>
            <td class="text-center">
              <span class="badge bg-info-opacity py-2 px-4"
                >إضافة</span
              >
            </td>
            <td>
              <p>
                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                الخارجي للنص أو شكل توضع الفقرات في الصفحة التي
                يقرأها.
              </p>
            </td>
            <td data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تفاصيل النشاط"></td>
          </tr>
          <tr>
            <td>3</td>
            <td>هشام أشرف</td>
            <td>قسم البرمجيات</td>
            <td>الصلاحيات</td>
            <td>سجل الصلاحيات</td>
            <td>20 يناير 2022 / 10:00 صباحاً</td>
            <td>00-14-7B-EE-19-F8</td>
            <td class="text-center">
              <span class="badge bg-success-opacity py-2 px-4"
                >تفعيل</span
              >
            </td>
            <td>
              <p>
                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                الخارجي للنص أو شكل توضع الفقرات في الصفحة التي
                يقرأها.
              </p>
            </td>
            <td data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تفاصيل النشاط"></td>
          </tr>
          <tr>
            <td>4</td>
            <td>محمد رضا</td>
            <td>قسم الإداريين</td>
            <td>الموظفين</td>
            <td>سجل الموظفين</td>
            <td>20 يناير 2022 / 03:00 مساءاً</td>
            <td>00-14-7B-EE-19-F8</td>
            <td class="text-center">
              <span class="badge bg-default-opacity py-2 px-4"
                >تعطيل</span
              >
            </td>
            <td>
              <p>
                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                الخارجي للنص أو شكل توضع الفقرات في الصفحة التي
                يقرأها.
              </p>
            </td>
            <td data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تفاصيل النشاط"></td>
          </tr>
          <tr>
            <td>5</td>
            <td>أحمد إسماعيل</td>
            <td>قسم المحاسبة</td>
            <td>المستخدمين</td>
            <td>سجل المستخدمين</td>
            <td>20 يناير 2022 / 05:00 مساءاً</td>
            <td>00-14-7B-EE-19-F8</td>
            <td class="text-center">
              <span class="badge bg-danger-opacity py-2 px-4"
                >حذف</span
              >
            </td>
            <td>
              <p>
                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                الخارجي للنص أو شكل توضع الفقرات في الصفحة التي
                يقرأها.
              </p>
            </td>
            <td data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="تفاصيل النشاط"></td>
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
@include('dashboard.activity_log.script')
