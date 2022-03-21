@extends('dashboard.layouts.master')
@section("content")
    {{--    {{dd($dapartments)}}--}}
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title">سجل الأقسام</h1>
                    <a href="department-add.html" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle-outline"></i> إضافة قسم
                    </a>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- FORM OPEN -->

                <form method="get" action="">
                    <div class="row align-items-end mb-3">
                        <div class="col">
                            <label for="departmentName">اسم القسم</label>
                            <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم"
                                   autocomplete="off">
                        </div>
                        <div class="col">
                            <label for="mainDepartment">القسم الرئيسي</label>
                            <select class="form-control select2-show-search form-select select2-hidden-accessible"
                                    data-placeholder="اختر قسم رئيسي" id="mainDepartment" tabindex="-1"
                                    aria-hidden="true">
                                <option selected="" disabled="" value="">اختر قسم رئيسي</option>
                                <option>قسم البرمجيات</option>
                                <option>قسم التصميم</option>
                                <option>قسم الجودة</option>
                                <option>قسم تحليل المتطلبات</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                           style="width: 100%;"><span class="selection"><span
                                        class="select2-selection select2-selection--single" role="combobox"
                                        aria-haspopup="true" aria-expanded="false" tabindex="0"
                                        aria-labelledby="select2-mainDepartment-container"><span
                                            class="select2-selection__rendered"
                                            id="select2-mainDepartment-container"><span
                                                class="select2-selection__placeholder">اختر قسم رئيسي</span></span><span
                                            class="select2-selection__arrow" role="presentation"><b
                                                role="presentation"></b></span></span></span><span
                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                        </div>
                        <div class="col">
                            <label for="validationCustom02"> تاريخ الإنشاء (من)</label>
                            <div class="input-group">
                                <input id="from-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control"
                                       autocomplete="off">
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="validationCustom02"> تاريخ الإنشاء (إلى)</label>
                            <div class="input-group">
                                <input id="to-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control"
                                       autocomplete="off">
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="status">الحالة</label>
                            <select class="form-control select2 select2-hidden-accessible" id="status" tabindex="-1"
                                    aria-hidden="true">
                                <option selected="" disabled="" value="">اختر الحالة</option>
                                <option>الجميع</option>
                                <option>مفعل</option>
                                <option>معطل</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                           style="width: 100%;"><span class="selection"><span
                                        class="select2-selection select2-selection--single" role="combobox"
                                        aria-haspopup="true" aria-expanded="false" tabindex="0"
                                        aria-labelledby="select2-status-container"><span
                                            class="select2-selection__rendered" id="select2-status-container"
                                            title="اختر الحالة">اختر الحالة</span><span class="select2-selection__arrow"
                                                                                        role="presentation"><b
                                                role="presentation"></b></span></span></span><span
                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
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
                            <div id="historyTable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <table id="historyTable"
                                       class="table table-bordered shadow-sm bg-body text-nowrap key-buttons dataTable no-footer"
                                       role="grid" aria-describedby="historyTable_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="border-bottom-0 sorting sorting_asc" tabindex="0"
                                            aria-controls="historyTable" rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="#: activate to sort column descending"
                                            style="width: 65.9531px;">#
                                        </th>
                                        <th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable"
                                            rowspan="1" colspan="1"
                                            aria-label="اسم القسم: activate to sort column ascending"
                                            style="width: 417.297px;">اسم القسم
                                        </th>
                                        <th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable"
                                            rowspan="1" colspan="1"
                                            aria-label="القسم الرئيسي: activate to sort column ascending"
                                            style="width: 233.141px;">القسم الرئيسي
                                        </th>
                                        <th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable"
                                            rowspan="1" colspan="1"
                                            aria-label="تاريخ الإنشاء: activate to sort column ascending"
                                            style="width: 200.172px;">تاريخ الإنشاء
                                        </th>
                                        <th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable"
                                            rowspan="1" colspan="1"
                                            aria-label="الحالة: activate to sort column ascending"
                                            style="width: 175.391px;">الحالة
                                        </th>
                                        <th class="border-bottom-0 text-center sorting" tabindex="0"
                                            aria-controls="historyTable" rowspan="1" colspan="1"
                                            aria-label="العمليات: activate to sort column ascending"
                                            style="width: 229.047px;">العمليات
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($dapartments as $key => $value)

                                        <tr class="odd">
                                            <td class="sorting_1">1</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="https://picsum.photos/seed/picsum/100" width="25"
                                                             class="avatar brround cover-image" alt="..."
                                                             data-toggle="popoverIMG" data-bs-original-title=""
                                                             title="">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        {{--                                                    {{dd($value)}}--}}
                                                        {{$value->name}}
                                                    </div>
                                                </div>
                                            </td>
                                            @php
                                                $dname = "لايوجد" ;
                                           if ($value->parent) {
                                               if (isset( $value->parent->translations[0] ))
                                                $dname = $value->parent->translations[0]->name;
                                               else $dname = $value->parent ;

                                           }



                                            @endphp
                                            {{--                                        {{dd(app()->getLocale())}}--}}
                                            <td>{{$dname

                                           }}</td>
                                            {{--                                        <td>{{(!$value->parent->translations?"لايوجد":$value->parent->translations)}}</td>--}}

                                            <td>{{$value->created_at}}</td>
                                            <td>
                            <span class="badge bg-success-opacity py-2 px-4">
                              {{$value->is_active==1?'مفعل':'معطل'}}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="./{{$value->id}}" class="azureIcon"
                                                   data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                   data-bs-original-title="التفاصيل" aria-label="التفاصيل"><i
                                                        class="mdi mdi-eye-outline"></i></a>
                                                <a href="department-add.html" class="warningIcon"
                                                   data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                   data-bs-original-title="تعديل" aria-label="تعديل"><i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                                                   data-bs-placement="top" title="" data-bs-original-title="أرشفة"
                                                   aria-label="أرشفة"><i data-bs-toggle="modal"
                                                                         data-bs-target="#archiveModal"
                                                                         class="mdi mdi-archive-arrow-down-outline"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
@endsection
