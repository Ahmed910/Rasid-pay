  <div class="card py-7 px-7">
    <div class="row">
      <div class="col-12 col-md-4">
        <label for="mainDepartment">القسم </label>
        <select class="form-control select2" id="mainDepartment">
          <option selected disabled value="">اختر قسم</option>
          <option>قسم البرمجيات</option>
          <option>قسم التصميم</option>
          <option>قسم الجودة</option>
          <option>قسم تحليل المتطلبات</option>
        </select>
      </div>
      <div class="col-12 col-md-4">
        <label for="userName">اسم المستخدم</label>
        <input
          type="text"
          class="form-control"
          id="userName"
          placeholder="اسم المستخدم"
        />
      </div>
      <div class="col-12 col-md-4">
        <label for="userID">رقم المستخدم</label>
        <input
          type="number"
          class="form-control"
          id="userID"
          placeholder="رقم المستخدم"
        />
      </div>
      <div class="col-12 col-md-8 mt-3">
        <label for="systemPermission">صلاحيات النظام</label>
        <select
          class="form-control select2"
          data-placeholder="اختر الصلاحيات"
          multiple="multiple"
          id="systemPermission"
          required
        >
          <option>قسم البرمجيات</option>
          <option>قسم التصميم</option>
          <option>قسم الجودة</option>
          <option>قسم تحليل المتطلبات</option>
        </select>
        <div class="invalid-feedback">الصلاحيات مطلوبة.</div>
      </div>
      <div class="col-12 col-md-4 mt-3">
        <label for="status">الحالة</label>
        <select class="form-control select2" id="status">
          <option selected disabled value="">اختر الحالة</option>
          <option>الجميع</option>
          <option>مفعل</option>
          <option value="hold">معطل لفترة</option>
          <option>معطل دائم</option>
        </select>
      </div>
      <div class="col-12 col-md-4 hold mt-3">
        <label for="validationCustom02"> معطل لفترة (من)</label>
        <div class="input-group">
          <input
            id="from-hijri-unactive-picker"
            type="text"
            placeholder="يوم/شهر/سنة"
            class="form-control"
          />
          <div class="input-group-text border-start-0">
            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 hold mt-3">
        <label for="validationCustom02"> معطل لفترة (إلى)</label>
        <div class="input-group">
          <input
            id="to-hijri-unactive-picker"
            type="text"
            placeholder="يوم/شهر/سنة"
            class="form-control"
          />
          <div class="input-group-text border-start-0">
            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-2  mt-3 d-flex align-items-end">
        <div class="form-check">
          <input
            class="form-check-input"
            type="checkbox"
            value="checked"
            id="verifyCode"
          />
          <label class="form-check-label" for="verifyCode">
            إرسال رمز التحقق
          </label>
        </div>
      </div>
      <div class="col-12 col-md-2  mt-3 d-flex align-items-end">
        <div class="form-check">
          <input
            class="form-check-input changeCheck"
            type="checkbox"
            value="change"
            id="passwordChange"

          />
          <label class="form-check-label" for="passwordChange">
            تغيير كلمة المرور
          </label>
        </div>
      </div>
      <div class="col-12 col-md-4 mt-3 changePass">
        <div class="form-group">
          <label>كلمة المرور الجديدة</label>
          <div class="input-group" id="show_hide_password">
            <input
              class="form-control"
              placeholder="كلمة المرور"
              type="password"
            />
            <div class="input-group-text bg-white border-start-0">
              <a href=""
                ><i class="mdi mdi-eye-off-outline d-flex"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 mt-3 changePass">
        <div class="form-group">
          <label>تأكيد كلمة المرور </label>
          <div
            class="input-group"
            id="show_hide_confirm_password"
          >
            <input
              class="form-control"
              placeholder="كلمة المرور"
              type="password"
            />
            <div class="input-group-text bg-white border-start-0">
              <a href=""
                ><i class="mdi mdi-eye-off-outline d-flex"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 mb-5 text-end">
      <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#successModal"
        type="submit"
      >
        <i class="mdi mdi-content-save-outline"></i> حفظ
      </button>
      <a
        href="departments-record.html"
        class="btn btn-outline-primary"
        data-bs-toggle="modal"
        data-bs-target="#backModal"
      >
        <i class="mdi mdi-arrow-left"></i> عودة
      </a>
    </div>
  </div@section('scripts')
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
