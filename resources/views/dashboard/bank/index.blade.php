@extends('dashboard.layouts.master')
@section('title', trans('dashboard.bank.index'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">البنوك</h1>
</div>
<!-- PAGE-HEADER END -->


<!-- FORM OPEN -->

<form method="get" action="">
    <div class="row align-items-end mb-3">
        <div class="col-12 col-md-3 mb-3">
            <label for="bankName">اسم البنك</label>
            <input type="text" class="form-control" id="bankName" placeholder="اسم البنك" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="bankType">نوع البنك</label>
            <select class="form-control select2" id="bankType">
                <option selected disabled value="">إختر النوع </option>
                <option>بنك اسلامي</option>
                <option>بنك استثماري</option>
                <option>البنك المركزي</option>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="bankCode">الكود</label>
            <input type="text" class="form-control" id="bankCode" placeholder="الكود" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="bankBranchName">اسم الفرع</label>
            <input type="text" class="form-control" id="bankBranchName" placeholder="اسم الفرع" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="bankLocation">الموقع</label>
            <input type="text" class="form-control" id="bankLocation" placeholder="الموقع" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="bankCode">الكود</label>
            <input type="text" class="form-control" id="bankName" placeholder="الكود" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="from-hijri-picker-custom"> تاريخ المعاملة (من)</label>
            <div class="input-group">
                <input id="from-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="to-hijri-picker-custom">تاريخ المعاملة (إلى)</label>
            <div class="input-group">
                <input id="to-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="transactionValueFrom">قيمة المعاملة (من)</label>
            <div class="input-group">
                <input id="transactionValueFrom" type="number" placeholder="أدخل قيمة المعاملة " class="form-control" />
                <div class="input-group-text border-start-0">
                    ر.س
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="transactionValueTo">قيمة المعاملة (إلى)</label>
            <div class="input-group">
                <input id="transactionValueTo" type="number" placeholder="أدخل قيمة المعاملة " class="form-control" />
                <div class="input-group-text border-start-0">
                    ر.س
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="transactionType">نوع المعاملة</label>
            <select class="form-control select2" id="transactionType">
                <option selected disabled value="">إختر النوع </option>
                <option>دفع</option>
                <option>تحويل محلي</option>
                <option>تحويل لمحفظة</option>
                <option>تحويل دولي</option>
                <option>استلام رصيد</option>
                <option>شحن رصيد</option>
                <option>ترقية البطاقات</option>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="activeCard">البطاقة المفعلة</label>
            <select class="form-control select2" id="activeCard">
                <option selected disabled value="">إختر البطاقة </option>
                <option>البطاقة الأساسية</option>
                <option>البطاقة الذهبية</option>
                <option>البطاقة البلاتينية</option>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="transactionType">حالة المعاملة</label>
            <select class="form-control select2" id="transactionType">
                <option selected disabled value="">إختر الحالة </option>
                <option>ناجحة</option>
                <option>فاشلة</option><option>فاشلة</option><option>بانتظار الاستلام</option><option>تم الاستلام</option><option>تم الإلغاء</option>
            </select>
        </div>
        {{-- <div class="col-12 col-md-3 mb-3">
            <label for="phone">رقم الجوال</label>
            <div class="input-group">
                <input id="phone" type="number" placeholder="أدخل رقم الجوال" class="form-control" />
                <div class="input-group-text border-start-0">
                    +966
                </div>
            </div>
        </div> 
        
        
        <div class="col-12 col-md-3 mb-3">
            <label for="from-hijri-picker-custom"> تاريخ التسجيل (من)</label>
            <div class="input-group">
                <input id="from-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="to-hijri-picker-custom">تاريخ التسجيل (إلى)</label>
            <div class="input-group">
                <input id="to-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
--}}

    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-tray-arrow-down"></i> تصدير
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                    <li><a class="dropdown-item" href="#">Excel</a></li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-end">
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
        <div class="p-1">
            <table id="transaction" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons historyTable">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0"> رقم المعاملة</th>
                        <th class="border-bottom-0">تاريخ المعاملة</th>
                        <th class="border-bottom-0">اسم المستخدم</th>
                        <th class="border-bottom-0">رقم الهوية</th>
                        <th class="border-bottom-0">اسم العميل</th>
                        <th class="border-bottom-0">قيمة المعاملة</th>
                        <th class="border-bottom-0">قيمة الفاتورة</th>
                        <th class="border-bottom-0">المكافآت </th>
                        <th class="border-bottom-0">نوع المعاملة</th>
                        <th class="border-bottom-0 text-center">حالة المعاملة</th>
                        <th class="border-bottom-0">البطاقة المفعلة</th>
                        {{-- <th class="border-bottom-0 text-center">العمليات</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>32</td>
                        <td>20 يناير 2022 / 09:00 ص</td>
                        <td>محمد رمضان ذكي</td>
                        <td>29463215876325</td>
                        <td> هشام أشرف عبد الشافي</td>
                        <td>1325 ر.س</td>
                        <td>1900 ر.س</td>
                        <td>675 ر.س</td>
                        <td>تحويل بنكي</td>
                        <td class="text-center">
                            <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                        </td>
                        <td>الأساسية / 25%</td>
                        {{-- <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td> --}}
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>15</td>
                        <td>20 يناير 2022 / 09:00 ص</td>
                        <td>محمد رمضان ذكي</td>
                        <td>29463215876325</td>
                        <td> هشام أشرف عبد الشافي</td>
                        <td>1325 ر.س</td>
                        <td>1900 ر.س</td>
                        <td>675 ر.س</td>
                        <td>تحويل بنكي</td>
                        <td class="text-center">
                            <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                        </td>
                        <td>الأساسية / 25%</td>
                        {{-- <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td> --}}
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>45</td>
                        <td>20 يناير 2022 / 09:00 ص</td>
                        <td>محمد رمضان ذكي</td>
                        <td>29463215876325</td>
                        <td> هشام أشرف عبد الشافي</td>
                        <td>1325 ر.س</td>
                        <td>1900 ر.س</td>
                        <td>675 ر.س</td>
                        <td>تحويل بنكي</td>
                        <td class="text-center">
                            <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                        </td>
                        <td>الأساسية / 25%</td>
                        {{-- <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td> --}}
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>21</td>
                        <td>20 يناير 2022 / 09:00 ص</td>
                        <td>محمد رمضان ذكي</td>
                        <td>29463215876325</td>
                        <td> هشام أشرف عبد الشافي</td>
                        <td>1325 ر.س</td>
                        <td>1900 ر.س</td>
                        <td>675 ر.س</td>
                        <td>تحويل بنكي</td>
                        <td class="text-center">
                            <span class="badge bg-warning-opacity py-2 px-4">ناجحة</span>
                        </td>
                        <td>الأساسية / 25%</td>
                        {{-- <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل النشاط"></td> --}}
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
@include('dashboard.transaction.script')