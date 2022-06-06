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
  <div class="row align-items-end mb-5">
    <div class="col-12 col-md-4 mb-5">
      <label for="clientName">اسم العميل</label><span class="requiredFields">*</span>
      <input type="text" class="form-control" id="clientName" placeholder="اسم العميل" />
    </div>
    <div class="col-12 col-md-4 mb-5">
      <label for="clientType">نوع العميل</label><span class="requiredFields">*</span>
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

    <div class="col-12 col-md-4 mb-5">
      <label for="registerType">نوع التسجيل</label><span class="requiredFields">*</span>
      <select class="form-control select2" id="registerType">
        <option selected disabled value="">إختر النوع </option>
        <option>مفوض</option>
        <option>مباشر</option>
      </select>
    </div>

    <div class="col-12 col-md-4 mb-5">
        <label for="phoneNumber">رقم الجوال</label>
        <div class="input-group">
            <input onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false"
                onDrag="return false" onDrop="return false" autocomplete=off type="number"
                class="form-control number-regex" id="phoneNumber" name="phoneNumber"
                placeholder="أدخل رقم الجوال" />

            <div class="input-group-text border-start-0" dir="ltr">
                +966
            </div>

        </div>
        <div class="invalid-feedback">رقم الجوال مطلوب.</div>
    </div>

    <div class="col-12 col-md-4 mb-5">
      <label for="transactionFrom">رقم السجل التجاري</label><span class="requiredFields">*</span>
      <input type="number" class="form-control" id="transactionFrom" placeholder="رقم السجل" />
    </div>
    <div class="col-12 col-md-4 mb-5">
      <label for="transactionTo">الرقم الضريبي</label><span class="requiredFields">*</span>
      <input type="number" class="form-control" id="transactionTo" placeholder="الرقم الضريبي" />
    </div>
    <div class="col-12 col-md-4 mb-5">
      <label for="transactionFrom">عدد المعاملات المنجزة</label>
      <input type="number" class="form-control" id="transactionFrom" placeholder="0" />
    </div>

    <div class="col-12 col-md-4 mb-5">
      <label for="bankName">البنك التابع له</label><span class="requiredFields">*</span>
      <select class="form-control select2" id="bankName">
        <option selected disabled value="">اختر البنك</option>
        <option>البنك الأهلي</option>
        <option>بنك الراجحي</option>
        <option>بنك الإنماء</option>
        <option>بنك سامبا</option>
      </select>
    </div>

    <div class="col-12 col-md-4 mb-5">
        <label for="bankAccount">رقم الحساب البنكي</label><span class="requiredFields">*</span>
        <div class="row" dir="ltr">
            <div class="col">
                <input type="number" class="form-control text-center" id="bankAccount"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="4"
                    required />
            </div>
            <div class="col">
                <input type="number" class="form-control text-center"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="4"
                    required />
            </div>
            <div class="col">
                <input type="number" class="form-control text-center"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="4"
                    required />
            </div>
            <div class="col">
                <input type="number" class="form-control text-center"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="4"
                    required />
            </div>
            <div class="col">
                <input type="number" class="form-control text-center"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="4"
                    required />
            </div>
            <div class="col">
                <input type="number" class="form-control text-center"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="4"
                    required />
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-5">
      <label for="bankStatus">حالة الحساب البنكي</label><span class="requiredFields">*</span>
      <select class="form-control select2" id="bankStatus">
        <option selected disabled value="">إختر الحالة </option>
        <option>تم تأكيد الحساب البنكي</option>
        <option>لم يتم تأكيد الحسب البنكي</option>
        <option>تم مراجعة الحساب البنكي</option>
      </select>
    </div>

    <div class="col-12 col-md-4 mb-5">
      <label for="transactionFrom">إجمالي المعاملات اليومية المتوقعة</label>
      <input type="number" class="form-control" id="transactionFrom"/>
    </div>

    <div class="col-12 col-md-4 mb-5">
      <label for="transactionFrom">نوع النشاط</label>
      <input type="number" class="form-control" id="transactionFrom"/>
    </div>

  </div>

<!-- Row -->
  <label> أسماء المديرين/المفوضين </label>
    <div class="row row-sm">
      <div class="col-lg-12">
        <div class="p-1">
          <table id="collapsedTable" class="table table-bordered dt-responsive  nowrap shadow-sm bg-body key-buttons historyTable">
            <thead>
              <tr>
                <th>#</th>
                <th>اسم المدير</th>
                <th>رقم الهوية</th>
                <th>تاريخ الميلاد</th>
                <th>رقم الجوال</th>
                <th class="text-center">العمليات</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>محمد رمضان</td>
                <td>234654313</td>
                <td>22-2-2022</td>
                <td>013256465313</td>
                <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل المدير"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
<!-- End Row -->

<!-- Row -->
  <div class="row">
      <label for="departmentImg">المرفقات</label>
        <div class="col-12 col-md-4">
            <div class="card p-5" style="border: 1px solid #e9edf4 !important; box-shadow: none">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="attachmentType">نوع المرفق</label>
                        <select class="form-control select2" id="attachmentType" required>
                            <option selected disabled value="">اختر النوع</option>
                            <option>تفويض</option>
                            <option>صورة بطاقة الهوية</option>
                            <option>مستندات</option>
                            <option>ملفات صورية</option>
                            <option>ملفات صوتية</option>
                            <option>ملفات فيديو</option>
                            <option>أخرى</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="attachmentTitle">عنوان المرفق</label>
                        <input type="text" class="form-control" id="attachmentTitle" placeholder="أدخل عنوان المرفق"
                            required />
                    </div>
                    <div class="col-12">
                        <label for="attachments">المرفقات</label>
                        <input id="demo" type="file" name="files" accept=".jpg, .png, image/jpeg, image/png" multiple>
                        <!-- {{-- <input type="file" class="dropify" data-show-remove="false" data-bs-height="250" multiple
                            id="attachments" data-errors-position="outside" data-show-errors="true"
                            data-show-loader="true" data-allowed-file-extensions="jpg png jpeg" required /> --}} -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-5" style="border: 1px solid #e9edf4 !important;height: 354px; box-shadow: none">
                <img src="{{ asset('dashboardAssets/images/pngs/photo_upload.png') }}" height="150"
                    class="d-block m-auto" alt="">
                <a href="#" class="btn btn-outline-primary">
                    <i class="mdi mdi-plus-circle-outline"></i> إضافة مرفق
                </a>
            </div>
        </div>
  </div>
<!-- End Row -->

<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-page-next-outline"></i> حفظ
        </button>
           <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
            </a>
    </div>
</div>


</form>


@endsection
@include('dashboard.client.script')


