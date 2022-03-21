@extends('dashboard.layouts.master')
@include('dashboard.job2.style')

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
                  <a href="{{ route('dashboard.jobs.index') }}">{{ trans('dashboard.job.sub_progs.index') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  {{ trans('dashboard.job.show') }}
                </li>
              </ol>
            </nav>
          </div>
          <!-- PAGE-HEADER END -->

          <!-- Row -->
          <div class="card py-7 px-7">
            <div class="row">
              <div class="col-12 col-md-3">
                <label>{{ trans('dashboard.job.job_name') }}:</label>
                <p>{{ $job->name }}</p>
              </div>
              <div class="col-12 col-md-3">
                <label>{{ trans('dashboard.job.department') }}:</label>
                <p>{{ optional($job->department)->name }}</p>
              </div>
              <div class="col-12 col-md-3">
                <label class="d-block" for="departmentName">{{ trans('dashboard.job.status') }}:</label>
                @if ($job->is_active)
                <p class="badge bg-success-opacity py-2 px-4">{{ trans('dashboard.job.is_active.active') }}</p>
                @else
                <p class="badge bg-danger-opacity py-2 px-4">{{ trans('dashboard.job.is_active.disactive') }} </p>
                @endif

              </div>
              <div class="col-12 col-md-3">
                <label class="d-block" for="departmentName">{{ trans('dashboard.job.type') }}:</label>
                @if ($job->is_vacant)
                <p class="occupied">{{ trans('dashboard.job.is_vacant.true') }}</p>
                @else
                <p class="vacant">{{ trans('dashboard.job.is_vacant.false') }}</p>
                @endif
              </div>
               <div class="col-12 col-md-3">
                <label class="d-block" for="departmentName">{{ trans('dashboard.job.employee_name') }}:</label>
                <p>{{ $job->added_by_employee }}</p>
              </div>
              <div class="col-12 col-md-9">
                <label class="d-block" for="departmentName">{{ trans('dashboard.job.job_description') }}:</label>
                <p>
                {{ $job->description }}
                </p>
              </div>
            </div>
          </div>

            <div class="row">
              <div class="col-12 text-end">
                <a href="{{ route('dashboard.jobs.edit',$job->id) }}"
                  class="btn btn-primary"
                >
                  <i class="mdi mdi-square-edit-outline"></i> {{ trans('dashboard.general.edit') }}
                </a>
                <a
                  href="jobs-record.html"
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
@endsection
@section('scripts')
@include('dashboard.job2.script')
@endsection
