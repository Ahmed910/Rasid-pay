@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.create'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.card_package.index') }}">نسب خصم البطاقات
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        إضافة
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->
    <form action="" id="add-branch-form">
        <div class="card px-7 py-7"> 
        <div class="row">
            <div class="col-12 col-md-6 mb-5">
                <label for="clientName">اسم العميل</label><span class="requiredFields">*</span>
                <select class="form-control select2" id="clientName">
                    <option selected disabled value="">إختر العميل </option>
                    <option>أحمد عادل</option>
                    <option>خالد خليل</option>
                    <option>محمد عبدالله</option>
                </select>
            </div>

            <div class="col-12 col-md-6 mb-5">
                <label for="discountRate">نسبة خصم البطاقة الأساسية</label><span class="requiredFields">*</span>
                <div class="input-group">
                    <input id="discountRate" type="number" placeholder="أدخل نسبة الخصم  " class="form-control" />
                    <div class="input-group-text border-start-0">
                        %
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-5">
                <label for="discountRate">نسبة خصم البطاقة الذهبية</label><span class="requiredFields">*</span>
                <div class="input-group">
                    <input id="discountRate" type="number" placeholder="أدخل نسبة الخصم  " class="form-control" />
                    <div class="input-group-text border-start-0">
                        %
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-5">
                <label for="discountRate">نسبة خصم البطاقة البلاتينية</label><span class="requiredFields">*</span>
                <div class="input-group">
                    <input id="discountRate" type="number" placeholder="أدخل نسبة الخصم  " class="form-control" />
                    <div class="input-group-text border-start-0">
                        %
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>


<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-page-next-outline"></i> حفظ
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
    </div>
</div>



@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@include('dashboard.card_package.script')
@endsection

