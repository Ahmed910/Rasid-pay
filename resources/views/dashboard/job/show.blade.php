@extends('dashboard.layouts.master')

@section('title')
Job view
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
                      <a href="departments-record.html"> سجل الوظائف</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      عرض الوظيفة
                    </li>
                  </ol>
                </nav>
              </div>
              <!-- PAGE-HEADER END -->

              <!-- Row -->
              <div class="card py-7 px-7">
                <div class="row">
                  <div class="col-12 col-md-3">
                    <label>اسم الوظيفة:</label>
                    <p>{{$rasidJob->name}}</p>
                  </div>
                  <div class="col-12 col-md-3">
                    <label>اسم القسم:</label>
                    <p>{{$rasidJob->department->name}}</p>
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="d-block" for="departmentName">الحالة:</label>
                    <p class="badge bg-success-opacity py-2 px-4">{{$rasidJob->is_active === 1 ? 'مفعلة ': 'معطلة ' }}</p>
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="d-block" for="departmentName">النوع:</label>
                    <p class="occupied">{{$rasidJob->is_vacant === 1 ? 'شاغرة ': 'مشغولة ' }}</p>
                  </div>
                   <div class="col-12 col-md-3">
                    <label class="d-block" for="departmentName">اسم الموظف:</label>
                    <p>هشام أشرف</p>
                  </div>
                  <div class="col-12 col-md-9">
                    <label class="d-block" for="departmentName">الوصف الوظيفي:</label>
                    <p>
                      {{$rasidJob->description}}
                    </p>
                  </div>
                </div>
              </div>

                <div class="row">
                  <div class="col-12 text-end">
                    <a href="{{route('dashboard.jobs.edit',$rasidJob->id)}}"
                      class="btn btn-primary"
                    >
                      <i class="mdi mdi-square-edit-outline"></i> تعديل
                    </a>
                    <a
                      href="{{route('dashboard.jobs.index')}}"
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
              <!-- <div class="card custom px-5 py-5 mt-8">
                <h5 class="card-title mb-0">معلومات التاريخ</h5>
                <div class="card-body pb-0">
                  <div class="row row-sm">
                    <div class="col-lg-12">

                    </div>
                  </div>
                </div>
              </div> -->

              <!-- End Row -->
            </div>
            <!-- CONTAINER CLOSED -->
          </div>
        </div>
        <!--app-content closed-->
      </div>

      <!-- Modal -->
      <div
        class="modal fade"
        id="staticBackdrop"
        data-bs-backdrop="static"
        data-bs-effect="effect-sign"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0">
            <div class="modal-header bg-primary">
              <h5 class="modal-title" id="staticBackdropLabel">أرشفة</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body text-center">
              <lottie-player
                autoplay
                loop
                mode="normal"
                src="{{asset('dashboardAssets/images/lottie/archive.json')}}"
                style="width: 70%; display: block; margin: auto"
              >
              </lottie-player>
              <p>هل تريد أرشفة هذا القسم؟</p>
              <div class="mt-3">
                <textarea
                  class="form-control"
                  placeholder="الرجاء ذكر السبب"
                  rows="3"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">تأكيد</button>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-bs-dismiss="modal"
              >
                إلغاء
              </button>
            </div>
          </div>
        </div>
      </div>

     @endsection
