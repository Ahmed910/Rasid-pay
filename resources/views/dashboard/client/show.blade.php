@extends('dashboard.layouts.master')

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard.client.index') }}">{{ trans('dashboard.client.sub_progs.index') }}
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ trans('dashboard.client.sub_progs.show') }}
          </li>
        </ol>
      </nav>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- Row -->
    <div class="card py-7 px-7">
        <div class="row mb-5">
            <div class="col-12 col-md-4">
                <label>القسم الرئيسي:</label>
                <p class="text-muted">
                    قسم البرمجيات</p>
            </div>
            <div class="col-12 col-md-4">
                <label>اسم القسم:</label>
                <p class="text-muted">
                    قسم التصميم</p>
            </div>
            <div class="col-12 col-md-4">
                <label class="d-block" for="departmentName">الحالة:</label>
                <p class="badge bg-success-opacity py-2 px-4">مفعل</p>
            </div>
            <div class="col-12 col-md-4">
                <label>صورة القسم:</label>
                <img src="https://picsum.photos/seed/picsum/1000" width="150" height="150" class="d-block rounded-3" alt="" data-toggle="popoverIMG">
            </div>
            <div class="col-12 col-md-8">
                <label class="d-block" for="departmentName">الوصف:</label>
                <p class="text-muted">
                    هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                    لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                    للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.
                </p>
            </div>
        </div>
        <hr>
        <label>تاريخ العمليات</label>
        <div class="table-responsive p-1">
            <table id="historyTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons historyTable">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">تم بواسطة</th>
                        <th class="border-bottom-0">تاريخ العمل</th>
                        <th class="border-bottom-0 text-center">
                            النشاط
                        </th>
                        <th class="border-bottom-0">السبب</th>
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
                        <td>20 يناير 2022</td>
                        <td class="text-center">
                            <span class="badge bg-primary-opacity py-2 px-4">أرشفة</span>
                        </td>
                        <td>
                            <p data-bs-toggle="tooltip" data-bs-placement="top" title="هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                                المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي للنص أو شكل توضع الفقرات في
                                الصفحة التي يقرأها.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
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
                        <td>20 يناير 2022</td>
                        <td class="text-center">
                            <span class="badge bg-warning-opacity py-2 px-4">تعديل</span>
                        </td>
                        <td>
                            <p data-bs-toggle="tooltip" data-bs-placement="top" title="هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                                المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي للنص أو شكل توضع الفقرات في
                                الصفحة التي يقرأها.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
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
                        <td>20 يناير 2022</td>
                        <td class="text-center">
                            <span class="badge bg-default-opacity py-2 px-4">معطل</span>
                        </td>
                        <td>
                            <p data-bs-toggle="tooltip" data-bs-placement="top" title="هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                                المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي للنص أو شكل توضع الفقرات في
                                الصفحة التي يقرأها.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
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
                        <td>20 يناير 2022</td>
                        <td class="text-center">
                            <span class="badge bg-primary-opacity py-2 px-4">أرشفة</span>
                        </td>
                        <td>
                            <p data-bs-toggle="tooltip" data-bs-placement="top" title="هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
                                المقروء لصفحة ما سيلهي القارئ عن التركيز على
                                الشكل الخارجي للنص أو شكل توضع الفقرات في
                                الصفحة التي يقرأها.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
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
                        <td>20 يناير 2022</td>
                        <td class="text-center">
                            <span class="badge bg-success-opacity py-2 px-4">مفعل</span>
                        </td>
                        <td>
                            <p data-bs-toggle="tooltip" data-bs-placement="top" title="هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى
              المقروء لصفحة ما سيلهي القارئ عن التركيز على
              الشكل الخارجي للنص أو شكل توضع الفقرات في
              الصفحة التي يقرأها.">
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
    </div>
    <!-- End Row -->
@endsection
