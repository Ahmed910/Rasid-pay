@extends('dashboard.layouts.master')
@section('title', trans('dashboard.activity_log.sub_progs.index'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ trans('dashboard.activity_log.sub_progs.index') }}</h1>
    </div>
    <!-- PAGE-HEADER END -->
   

    <!-- FORM CLOSED -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="p-1">
                <table id="table-details"
                    class="table table-bordered dt-responsive text-nowrap shadow-sm bg-body key-buttons historyTable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">رقم المعاملة</th>
                            <th class="border-bottom-0">تاريخ المعاملة</th>
                            <th class="border-bottom-0">اسم المستخدم</th>
                            <th class="border-bottom-0">رقم الهوية</th>
                            <th class="border-bottom-0">اسم العميل</th>
                            <th class="border-bottom-0">قيمة المعاملة</th>
                            <th class="border-bottom-0">قيمة الفاتورة</th>
                            <th class="border-bottom-0">نوع المعاملة</th>
                            <th class="border-bottom-0 text-center">حالة المعاملة</th>
                            <th class="border-bottom-0">البطاقة المفعلة</th>
    
                            <th class="border-bottom-0">نسبة خصم البطاقة</th>
                            <th class="border-bottom-0">المكافآت المكتسبة</th>
                            <th class="border-bottom-0 text-center">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>32</td>
                            <td>20 يناير 2022 / 09:00 صباحاً</td>
                            <td>محمد رمضان ذكي</td>
                            <td>29463215876325</td>
                            <td> هشام أشرف عبد الشافي</td>
                            <td>1325 ر.س</td>
                            <td>1900 ر.س</td>
                            <td>تحويل بنكي</td>
                            <td class="text-center">
                                <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                            </td>
                            <td>الأساسية</td>
                            <td>25%</td>
                            <td>675 ر.س</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>32</td>
                            <td>20 يناير 2022 / 09:00 صباحاً</td>
                            <td>محمد رمضان ذكي</td>
                            <td>29463215876325</td>
                            <td> هشام أشرف عبد الشافي</td>
                            <td>1325 ر.س</td>
                            <td>1900 ر.س</td>
                            <td>تحويل بنكي</td>
                            <td class="text-center">
                                <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                            </td>
                            <td>الأساسية</td>
                            <td>25%</td>
                            <td>675 ر.س</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>32</td>
                            <td>20 يناير 2022 / 09:00 صباحاً</td>
                            <td>محمد رمضان ذكي</td>
                            <td>29463215876325</td>
                            <td> هشام أشرف عبد الشافي</td>
                            <td>1325 ر.س</td>
                            <td>1900 ر.س</td>
                            <td>تحويل بنكي</td>
                            <td class="text-center">
                                <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                            </td>
                            <td>الأساسية</td>
                            <td>25%</td>
                            <td>675 ر.س</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>32</td>
                            <td>20 يناير 2022 / 09:00 صباحاً</td>
                            <td>محمد رمضان ذكي</td>
                            <td>29463215876325</td>
                            <td> هشام أشرف عبد الشافي</td>
                            <td>1325 ر.س</td>
                            <td>1900 ر.س</td>
                            <td>تحويل بنكي</td>
                            <td class="text-center">
                                <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                            </td>
                            <td>الأساسية</td>
                            <td>25%</td>
                            <td>675 ر.س</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td>
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
@include('dashboard.citizen.script')
