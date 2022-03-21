<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-4 mb-5">
            <label for="departmentName">اسم القسم</label>
            <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم" required />
            <div class="invalid-feedback">اسم القسم مطلوب.</div>
        </div>

        <div class="col">
          <label for="mainDepartment">القسم الرئيسي</label>
          <select class="form-control select2-show-search form-select" data-placeholder="اختر قسم رئيسي" id="mainDepartment">
            <option selected disabled value="">اختر قسم رئيسي</option>
            <option>قسم البرمجيات</option>
            <option>قسم التصميم</option>
            <option>قسم الجودة</option>
            <option>قسم تحليل المتطلبات</option>
          </select>
        </div>

        <div class="col-12 col-md-4 mb-5">
            <label for="status">الحالة</label>
            <select class="form-control select2" id="status">
                <option selected disabled value="">اختر الحالة</option>
                <option>مفعل</option>
                <option>معطل</option>
            </select>
        </div>
        <div class="col-12">
            <label for="departmentImg">صورة القسم (JPG, PNG, JPEG, DWG)</label>
            <input type="file" class="dropify" data-show-remove="true" data-bs-height="250" id="departmentImg"
                data-errors-position="inside" data-show-errors="true" data-show-loader="true"
                data-allowed-file-extensions="jpg png jpeg dwg" required />
        </div>
        <div class="col-12">
            <label for="departmentDes">الوصف</label>
            <textarea type="text" class="form-control" id="departmentDes" rows="3" placeholder="الوصف"></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-content-save-outline"></i> حفظ
        </button>
        <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
    </div>
</div>


@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <!-- FORMVALIDATION JS -->
    <script src="{{ asset('dashboardAssets/js/form-validation.js') }}"></script>

    <!-- FILE UPLOADES JS -->
    <script src="{{ asset('dashboardAssets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/fileuploads/js/file-upload.js') }}"></script>

@endsection
