<div class="card py-7 px-7">
  <div class="row">
    <div class="col-12 col-md-4 mb-5">
      <label for="mainDepartment">القسم الرئيسي</label>
      <select class="form-control" id="mainDepartment" required>
        <option selected disabled value="">اختر قسم رئيسي</option>
        <option>قسم البرمجيات</option>
        <option>قسم التصميم</option>
        <option>قسم الجودة</option>
        <option>قسم تحليل المتطلبات</option>
      </select>

      <div class="invalid-feedback">القسم الرئيسي مطلوب.</div>
    </div>
    <div class="col-12 col-md-4 mb-5">
      <label for="departmentName">اسم القسم</label>
      <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم" required />
      <div class="invalid-feedback">اسم القسم مطلوب.</div>
    </div>
    <div class="col-12 col-md-4 mb-5">
      <label class="d-block" for="departmentStatus">الحالة</label>
      <!-- <label class="custom-switch form-switch me-5">
                  <input
                    type="checkbox"
                    name="custom-switch-checkbox1"
                    class="custom-switch-input"
                    required
                  />
                  <span
                    class="custom-switch-indicator custom-switch-indicator-lg"
                  ></span>
                </label> -->
      <select class="form-control" id="departmentStatus" required>
        <option selected disabled value="">اختر الحالة</option>
        <option>مفعل</option>
        <option>معطل</option>
      </select>
    </div>
    <div class="col-12">
      <label for="departmentImg">صورة القسم (JPG, PNG, JPEG)</label>
      <input type="file" class="dropify" data-show-remove="false" data-bs-height="250" id="departmentImg" data-errors-position="outside" data-show-errors="true" data-show-loader="true" data-allowed-file-extensions="jpg png jpeg" required />
    </div>
    <div class="col-12">
      <label for="departmentDes">الوصف</label>
      <textarea type="text" class="form-control" id="departmentDes" placeholder="الوصف"></textarea>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 mb-5 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
      <i class="mdi mdi-content-save-outline"></i> حفظ
    </button>
    <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#backModal">
      <i class="mdi mdi-arrow-left"></i> عودة
    </a>
  </div>
</div>

@section('scripts')
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener(
                "load",
                function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName("needs-validation");
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(
                        forms,
                        function(form) {
                            form.addEventListener(
                                "submit",
                                function(event) {
                                    form.classList.add("was-validated");
                                    event.preventDefault();
                                    if (form.checkValidity() === false) {
                                        event.stopPropagation();
                                    } else {
                                        $('#successModal').modal('show');
                                    }
                                },
                                false
                            );
                        }
                    );
                },
                false
            );

            $("#showBack").click(function() {
                let validate = false;
                $('#formId input').each(function() {
                    if ($(this).attr('name') !== '_token' && ($(this).val() != '' || $(this).attr(
                            'checked')))
                        validate = true;
                });
                if (validate) {
                    $('#backModal').modal('show');
                    return false;
                } else {
                    history.back()
                }
            });
            $(".dropify").dropify({
                messages: {
                    default: "{{ trans('dashboard.general.hold_upload') }}",
                    replace: "{{ trans('dashboard.general.hold_change') }}",
                    remove: "{{ trans('dashboard.general.delete') }}",
                    error: "{{ trans('dashboard.general.upload_error') }}",
                },
                error: {
                  fileExtension: "{{ trans('dashboard.general.notAllowdedToUpload') }}",
                    fileSize: "{{ trans('dashboard.general.upload_file_max') }} (5M max).",
                },
            });
        })();
    </script>
@endsection
