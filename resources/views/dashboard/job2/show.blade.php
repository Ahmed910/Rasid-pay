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
<li class="breadcrumb-item"><a href="departments-record.html"> سجل الأقسام</a></li>
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
                                            <p class="text-muted">

قسم التصميم</p>
                </div>
                <div class="col-12 col-md-4">
                  <label>القسم الرئيسي:</label>
                                            <p class="text-muted">
قسم البرمجيات</p>
                </div>
                <div class="col-12 col-md-4">
                  <label class="d-block" for="departmentName"
                    >الحالة:</label
                  >
                  <p class="badge bg-success-opacity py-2 px-4">مفعل</p>
                </div>
              <div class="col-12 col-md-4">
                  <label>صورة القسم:</label>
                  <img src="https://picsum.photos/seed/picsum/1000" width="150" height="150" class="d-block rounded-3" alt=""
                              data-toggle="popoverIMG">
                </div>
                <div class="col-12 col-md-8">
                  <label class="d-block" for="departmentName"
                    >الوصف:</label
                  >
                  <p class="text-muted">
                    هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                    لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                    للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.
                  </p>
                </div>
          </div>

        </div>
        <div class="row">
          <div class="col-12 text-end">
            <a href="department-add.html"
              class="btn btn-primary"
            >
              <i class="mdi mdi-square-edit-outline"></i> تعديل
            </a>
            <a
              href="departments-record.html"
              class="btn btn-outline-primary"
            >
              <i class="mdi mdi-arrow-left"></i> عودة
            </a>
          </div>
        </div>
      <!-- End Row -->

      <!-- Row -->
          <label>الحركة التاريخية</label>
              <div class="table-responsive p-1">
                <table
                  id="historyTable"
                  class="table table-bordered shadow-sm bg-body key-buttons historyTable"
                >
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
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            هشام أشرف
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0">
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            قسم البرمجيات
                          </div>
                        </div>
                      </td>
                      <td>20 يناير 2022</td>
                      <td>
                        <span class="badge bg-primary-opacity py-2 px-4"
                          >أرشفة</span
                        >
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
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            محمد رمضان
                          </div>
                        </div>
                      </td>

                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0">
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            قسم تحليل المتطلبات
                          </div>
                        </div>
                      </td>
                      <td>20 يناير 2022</td>
                      <td>
                        <span class="badge bg-warning-opacity py-2 px-4"
                          >تعديل</span
                        >
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
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            محمد تريكة
                          </div>
                        </div>
                      </td>

                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0">
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            قسم التصميم
                          </div>
                        </div>
                      </td>
                      <td>20 يناير 2022</td>
                      <td>
                        <span class="badge bg-default-opacity py-2 px-4"
                          >تعطيل</span
                        >
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
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            طه محمد
                          </div>
                        </div>
                      </td>

                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0">
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            قسم الجودة
                          </div>
                        </div>
                      </td>
                      <td>20 يناير 2022</td>
                      <td>
                        <span class="badge bg-primary-opacity py-2 px-4"
                          >أرشفة</span
                        >
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
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            أحمد اسماعيل
                          </div>
                        </div>
                      </td>

                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0">
                            <img
                              src="https://picsum.photos/seed/picsum/100"
                              width="25"
                              class="avatar brround cover-image"
                              alt="..."
                              data-toggle="popoverIMG"
                            />
                          </div>
                          <div class="flex-grow-1 ms-3">
                            قسم الموارد البشرية
                          </div>
                        </div>
                      </td>
                      <td>20 يناير 2022</td>
                      <td>
                        <span class="badge bg-success-opacity py-2 px-4"
                          >تفعيل</span
                        >
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
