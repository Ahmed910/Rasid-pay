@extends('dashboard.layouts.master')
@section('title', 'Page Title')

@section('content')

<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="permissions-record.html"> سجل الصلاحيات</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        عرض صلاحية
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->

<!-- Row -->
<div class="card py-7 px-7">
  <div class="row">
    <div class="col-12 col-md-3">
      <label>اسم المجموعة:</label>
      <p class="text-muted">قسم البرمجيات</p>
    </div>
    <div class="col-12 col-md-3">
      <label class="d-block" for="departmentName">الحالة:</label>
      <p class="badge bg-success-opacity py-2 px-4">مفعل</p>
    </div>
    <div class="col-12 col-md-3">
      <label>عدد المستخدمين:</label>
      <p class="text-muted">3254</p>
    </div>
    <div class="col-12 col-md-3">
      <label>منشئ المجموعة:</label>
      <p class="text-muted">محمد رضا تريكة</p>
    </div>
  </div>

</div>
<!-- End Row -->
<!-- Row -->

<label>بيانات المجموعة</label>
<div class="table-responsive p-1">
  <table id="groupTable" class="table table-bordered shadow-sm bg-body key-buttons historyTable">
    <thead>
      <tr>
        <th class="border-bottom-0">#</th>
        <th class="border-bottom-0">اسم الصلاحية</th>
        <th class="border-bottom-0">البرنامج الرئيسي</th>
        <th class="border-bottom-0">البرنامج الفرعي</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>
          تعديل
        </td>
        <td>
          إدارة المالية
        </td>
        <td>-----</td>
      </tr>
      <tr>
        <td>2</td>
        <td>
          عرض
        </td>
        <td>
          إدارة المحاسبة
        </td>
        <td>-----</td>
      </tr>
      <tr>
        <td>3</td>
        <td>
          تعديل
        </td>
        <td>
          إدارة التصميم
        </td>
        <td>-----</td>
      </tr>
      <tr>
        <td>4</td>
        <td>
          تعديل
        </td>
        <td>
          إدارة الحسابات
        </td>
        <td>-----</td>
      </tr>
      <tr>
        <td>5</td>
        <td>
          إضافة
        </td>
        <td>
          إدارة المالية
        </td>
        <td>إضافة</td>
      </tr>
    </tbody>
  </table>
</div>
<!-- End Row -->

<!-- Row -->
<div class="row mt-5">
  <div class="col-12 text-end">
    <a href="permission-add.html" class="btn btn-primary">
      <i class="mdi mdi-square-edit-outline"></i> تعديل
    </a>
    <a href="permissions-record.html" class="btn btn-outline-primary">
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
    <tbody>
      <tr>
        <td>1</td>
        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              هشام أشرف
            </div>
          </div>
        </td>
        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              قسم البرمجيات
            </div>
          </div>
        </td>
        <td>20 يناير 2022</td>
        <td>
          <span class="badge bg-info-opacity py-2 px-4">إضافة</span>
        </td>
        <td>
          <p>
            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
            المقروء لصفحة ما سيلهي القارئ عن التركيز على
            الشكل الخارجي للنص أو شكل توضع الفقرات في
            الصفحة التي يقرأها.
          </p>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              محمد رمضان
            </div>
          </div>
        </td>

        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              قسم تحليل المتطلبات
            </div>
          </div>
        </td>
        <td>20 يناير 2022</td>
        <td>
          <span class="badge bg-warning-opacity py-2 px-4">تعديل</span>
        </td>
        <td>
          <p>
            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
            المقروء لصفحة ما سيلهي القارئ عن التركيز على
            الشكل الخارجي للنص أو شكل توضع الفقرات في
            الصفحة التي يقرأها.
          </p>
        </td>
      </tr>
      <tr>
        <td>3</td>
        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              محمد تريكة
            </div>
          </div>
        </td>

        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              قسم التصميم
            </div>
          </div>
        </td>
        <td>20 يناير 2022</td>
        <td>
          <span class="badge bg-default-opacity py-2 px-4">تعطيل</span>
        </td>
        <td>
          <p>
            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
            المقروء لصفحة ما سيلهي القارئ عن التركيز على
            الشكل الخارجي للنص أو شكل توضع الفقرات في
            الصفحة التي يقرأها.
          </p>
        </td>
      </tr>
      <tr>
        <td>4</td>
        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              طه محمد
            </div>
          </div>
        </td>

        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              قسم الجودة
            </div>
          </div>
        </td>
        <td>20 يناير 2022</td>
        <td>
          <span class="badge bg-info-opacity py-2 px-4">إضافة</span>
        </td>
        <td>
          <p>
            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
            المقروء لصفحة ما سيلهي القارئ عن التركيز على
            الشكل الخارجي للنص أو شكل توضع الفقرات في
            الصفحة التي يقرأها.
          </p>
        </td>
      </tr>
      <tr>
        <td>5</td>
        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              أحمد اسماعيل
            </div>
          </div>
        </td>

        <td>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" />
            </div>
            <div class="flex-grow-1 ms-3">
              قسم الموارد البشرية
            </div>
          </div>
        </td>
        <td>20 يناير 2022</td>
        <td>
          <span class="badge bg-success-opacity py-2 px-4">تفعيل</span>
        </td>
        <td>
          <p>
            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
            المقروء لصفحة ما سيلهي القارئ عن التركيز على
            الشكل الخارجي للنص أو شكل توضع الفقرات في
            الصفحة التي يقرأها.
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</div>

@endsection
