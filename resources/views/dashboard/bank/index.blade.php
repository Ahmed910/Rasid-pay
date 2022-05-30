@extends('dashboard.layouts.master')
@section('title', trans('dashboard.bank.sub_progs.index'))

@section('content')


<!-- PAGE-HEADER -->
 <div class="page-header">
    <h1 class="page-title">سجل البنوك</h1>
    <a href="{{ route('dashboard.bank.create') }}" class="btn btn-primary">
      <i class="mdi mdi-plus-circle-outline"></i> إضافة بنك
    </a>
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
            <label for="transactionValueFrom">قيمة تكلفة التحويل</label>
            <div class="input-group">
                <input id="transactionValueFrom" type="number" placeholder="أدخل قيمة المعاملة " class="form-control" />
                <div class="input-group-text border-start-0">
                    ر.س
                </div>
            </div>
        </div>


        <div class="col-12 col-md-3 mb-3">
            <label for="transactionType">الحالة</label>
            <select class="form-control select2" id="transactionType">
                <option selected disabled value="">إختر الحالة </option>
                <option>ناجحة</option>
                <option>فاشلة</option>
                <option>بانتظار الاستلام</option>
                <option>تم الاستلام</option>
                <option>تم الإلغاء</option>
            </select>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label for="transactionsNumber">عدد المعاملات</label>
            <input type="number" class="form-control" id="transactionsNumber" placeholder="ادخل عدد المعاملات"/>
        </div>

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
        <div class="col-12 col-md-6 my-3 d-flex justify-content-end">
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

<div class="row row-sm">
  <div class="col-lg-12">
      <div class="p-1">
          <table id="bankTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
              <thead>
                  <tr>
                      <th class="border-bottom-0">#</th>
                      <th class="border-bottom-0">
                          @lang('dashboard.bank.bank_name')</th>
                      <th class="border-bottom-0">
                          @lang('dashboard.bank.type bank')</th>
                      <th class="border-bottom-0">
                          @lang('dashboard.bank.code')</th>
                      <th class="border-bottom-0">
                          @lang('dashboard.bank.BranchName')</th>
                        <th class="border-bottom-0">
                          @lang('dashboard.bank.location')</th>
                          <th class="border-bottom-0">
                            @lang('dashboard.bank.transaction_Value_From')</th>
                            <th class="border-bottom-0">
                              @lang('dashboard.bank.transaction_Value_From')</th>
                              <th class="border-bottom-0">
                                @lang('dashboard.bank.Number Transactions')</th>
                                <th class="border-bottom-0">
                                  @lang('dashboard.general.status')</th>
                      <th class="border-bottom-0 text-center">
                          @lang('dashboard.general.actions')</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
  </div>
</div>

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.bank.script')

