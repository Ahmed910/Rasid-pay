@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.create'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.client.index') }}">{{ trans('dashboard.bank.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.bank.sub_progs.create') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->

<div class="col-12 mb-5">
    <label for="bankName">اسم البنك</label><span class="requiredFields">*</span>
    <input type="text" class="form-control" id="bankName" placeholder="أدخل اسم البنك" required />
    <div class="invalid-feedback">اسم البنك مطلوب.</div>
</div>
    <form action="" id="add-branch-form">
        <fieldset class="card createBankBranch px-4 py-4" id="">
            <a
                role="button"
                class="deleteBranch text-end"
                ><i class="mdi mdi-delete"></i></a>
        <div class="row">
            <div class="col-12 col-md-4 mb-5">
                <label for="bankBranchName">اسم الفرع</label><span class="requiredFields">*</span>
                <input type="text" class="form-control" id="bankBranchName" placeholder="أدخل اسم الفرع" required />
                <div class="invalid-feedback">اسم الفرع مطلوب.</div>
            </div>

            <div class="col-12 col-md-4 mb-5">
                <label for="bankType">نوع البنك</label><span class="requiredFields">*</span>
                <select class="form-control select2" id="bankType">
                    <option selected disabled value="">إختر النوع </option>
                    <option>بنك اسلامي</option>
                    <option>بنك استثماري</option>
                    <option>البنك المركزي</option>
                </select>
            </div>
            <div class="col-12 col-md-4 mb-5">
                <label for="bankCode">الكود</label><span class="requiredFields">*</span>
                <input type="text" class="form-control" id="bankCode" placeholder="الكود" />
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label for="bankLocation">الموقع</label><span class="requiredFields">*</span>
                <input type="text" class="form-control" id="bankLocation" placeholder="أدخل الموقع" />
            </div>
            <div class="col-12 col-md-4 mb-5">
                <label for="transactionValueFrom">قيمة تكلفة التحويل</label><span class="requiredFields">*</span>
                <div class="input-group">
                    <input id="transactionValueFrom" type="number" placeholder="أدخل قيمة التحويل " class="form-control" />
                    <div class="input-group-text border-start-0">
                        ر.س
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-5">
                <label for="commercialRecord">السجل التجاري</label>
                <input type="text" class="form-control" id="commercialRecord" placeholder="أدخل السجل التجاري" required />
            </div>

            <div class="col-12 col-md-4 mb-5">
                <label for="taxNumber">الرقم الضريبي</label>
                <input type="text" class="form-control" id="taxNumber" placeholder="أدخل الرقم الضريبي" required />
            </div>

            <div class="col-12 col-md-4 mb-5">
                <label for="serviceNumber">رقم خدمة العملاء</label>
                <input type="text" class="form-control" id="serviceNumber" placeholder="أدخل رقم خدمة العملاء" required />
            </div>
        </div>
        </fieldset>
    </form>

<div class="card py-7 px-7 h-300">
    <div class="row">
        <div class="col-12 col-md-6 text-end">
            <button class="btn btn-outline-primary mt-9" id="addBranchBtn">
                <i class="mdi mdi-plus-circle-outline"></i> إضافة فرع جديد
            </button>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-content-save-outline"></i> حفظ
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

