@extends('dashboard.layouts.master')
@include('dashboard.client.style')

@section('title', trans('dashboard.client.edit_client'))

@section('content')

<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.client.index') }}">
          {{ trans('dashboard.client.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.client.edit_client') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->
<form method="get" action="">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-3 mb-3">
      <label for="clientName">اسم العميل</label>
      <input type="text" class="form-control" id="clientName" placeholder="اسم العميل" />
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="clientType">نوع العميل</label>
      <select class="form-control select2" id="clientType">
        <option selected disabled value="">إختر النوع </option>
        <option>مؤسسات</option>
        <option>أفراد</option>
        <option>شركات</option>
        <option>حر</option>
        <option>وثائق عمل</option>
        <option>مشاهير</option>
        <option>الجميع</option>
      </select>
    </div>

    <div class="col-12 col-md-3 mb-3">
      <label for="transactionFrom">رقم السجل</label>
      <input type="number" class="form-control" id="transactionFrom" placeholder="رقم السجل" />
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="transactionTo">الرقم الضريبي</label>
      <input type="number" class="form-control" id="transactionTo" placeholder="الرقم الضريبي" />
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="transactionFrom">عدد المعاملات المنجزة (من) </label>
      <input type="number" class="form-control" id="transactionFrom" placeholder="0" />
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="transactionTo">عدد المعاملات المنجزة (إلى)</label>
      <input type="number" class="form-control" id="transactionTo" placeholder="0" />
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="bankName">البنك التابع له</label>
      <select class="form-control select2" id="bankName">
        <option selected disabled value="">اختر البنك</option>
        <option>البنك الأهلي</option>
        <option>بنك الراجحي</option>
        <option>بنك الإنماء</option>
        <option>بنك سامبا</option>
      </select>
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="bankStatus">حالة الحساب البنكي</label>
      <select class="form-control select2" id="bankStatus">
        <option selected disabled value="">إختر الحالة </option>
        <option>تم تأكيد الحساب البنكي</option>
        <option>لم يتم تأكيد الحسب البنكي</option>
        <option>تم مراجعة الحساب البنكي</option>
      </select>
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="from-hijri-picker-custom"> المعاملات المنجزة في الفترة (من)</label>
      <div class="input-group">
        <input id="from-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
        <div class="input-group-text border-start-0">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
      <label for="to-hijri-picker-custom">المعاملات المنجزة في الفترة (إلى)</label>
      <div class="input-group">
        <input id="to-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
        <div class="input-group-text border-start-0">
          <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
        </div>
      </div>
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
      <table id="clientTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
        <thead>
          <tr>
            <th class="border-bottom-0">#</th>
            <th class="border-bottom-0">اسم العميل</th>
            <th class="border-bottom-0">نوع العميل</th>
            <th class="border-bottom-0">رقم السجل</th>
            <th class="border-bottom-0">الرقم الضريبي</th>
            <th class="border-bottom-0">عدد المعاملات المنجزة</th>
            <th class="border-bottom-0">البنك التابع له</th>
            <th class="border-bottom-0">حالة الحساب البنكي</th>
            <th class="border-bottom-0 text-center">العمليات</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- End Row -->

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.client.script')
