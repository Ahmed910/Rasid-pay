@extends('dashboard.layouts.master')
@section('title', trans('dashboard.bank.sub_progs.index'))

@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">نسب خصم البطاقات</h1>
  <a href="{{ route('dashboard.client_package.create') }}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i> إضافة نسب خصم البطاقات
  </a>
</div>
<!-- PAGE-HEADER END -->


<!-- FORM OPEN -->
<form method="get" action="">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-12 mb-3">
      <label for="clientName">اسم العميل</label>
      <select class="form-control select2-show-search" id="client_id">
        <option selected disabled value="">إختر العميل</option>
        <option value="-1 "> {{trans("dashboard.general.all_cases")}}</option>
        @foreach($clients as $key =>$value)
        <option value="{{ $key }}">{{$value}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 my-2">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-tray-arrow-down"></i> تصدير
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="#">PDF</a></li>
          <li><a class="dropdown-item" href="#">Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
      <button class="btn btn-primary me-2" type="submit">
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
        <table id="package-table"
          class="table table-bordered text-nowrap shadow-sm bg-body key-buttons historyTable">
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">اسم العميل</th>
              <th class="border-bottom-0">البطاقة الأساسية</th>
              <th class="border-bottom-0">البطاقة الذهبية</th>
              <th class="border-bottom-0">البطاقة البلاتينية</th>
              <th class="border-bottom-0">العمليات</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
</div>
<!-- End Row -->

@include('dashboard.layouts.modals.alert')

@endsection
@include('dashboard.client_package.script')
