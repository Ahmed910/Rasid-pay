<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-4 mb-5">
            <label for="clientType">نوع العميل</label><span class="requiredFields">*</span>
            <select class="form-control select2-show-search" id="clientType" required>
                <option selected disabled value="">اختر النوع </option>
                <option>مؤسسات</option>
                <option>أفراد</option>
                <option>شركات</option>
                <option>حر</option>
                <option>وثائق عمل</option>
                <option>مشاهير</option>
                <option>الجميع</option>
            </select>

            <div class="invalid-feedback">نوع العميل مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="registerType">نوع التسجيل</label>
            <select class="form-control select2-show-search" id="registerType">
                <option selected disabled value="">اختر النوع </option>
                <option>تسجيل مباشر</option>
                <option>تسجيل بتفويض</option>
            </select>

        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="clientName">اسم العميل</label><span class="requiredFields">*</span>
            <input type="text" class="form-control" id="clientName" placeholder="أدخل اسم العميل" required />
            <div class="invalid-feedback">اسم العميل مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="tradeNumber">السجل التجاري</label><span class="requiredFields">*</span>
            <input type="text" class="form-control" id="tradeNumber" placeholder="أدخل السجل التجاري" required />
            <div class="invalid-feedback">السجل التجاري مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="taxNumber">الرقم الضريبي</label><span class="requiredFields">*</span>
            <input type="text" class="form-control" id="taxNumber" placeholder="أدخل الرقم الضريبي" required />
            <div class="invalid-feedback">الرقم الضريبي مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="activityType">نوع النشاط</label>
            <input type="text" class="form-control" id="activityType" placeholder="أدخل نوع النشاط" />
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="departmentStatus">البنك</label><span class="requiredFields">*</span>

            <select class="form-control select2-show-search" id="departmentStatus" required>
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
            <label for="allTransactions">إجمالي المعاملات اليومية المتوقعة</label>
            <div class="input-group">
                <input onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false"
                    onDrag="return false" onDrop="return false" autocomplete=off type="number"
                    class="form-control number-regex" id="allTransactions" name="allTransactions" placeholder="0" />

                <div class="input-group-text border-start-0" dir="ltr">
                    ر.س
                </div>

            </div>
        </div>

        <label for="departmentImg">المرفقات</label>
        <div class="col-12 col-md-4">
            <div class="card p-5" style="border: 1px solid #e9edf4 !important; box-shadow: none">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="attachmentType">نوع المرفق</label>
                        <select class="form-control select2-show-search" id="attachmentType" required>
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
                        {{-- <input type="file" class="dropify" data-show-remove="false" data-bs-height="250" multiple
                            id="attachments" data-errors-position="outside" data-show-errors="true"
                            data-show-loader="true" data-allowed-file-extensions="jpg png jpeg" required /> --}}
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-5" style="border: 1px solid #e9edf4 !important;height: 354px; box-shadow: none">
                <img src="{{ asset('dashboardAssets/images/pngs/photo_upload.png') }}" height="150" class="d-block m-auto" alt="">
<a href="#" class="btn btn-outline-primary">
    <i class="mdi mdi-plus-circle-outline"></i> إضافة مرفق
</a>
            </div>
        </div>
        <h3>بيانات المدير</h3>
        <div class="col-12 col-md-4 mb-5">
            <label for="managerName">اسم المدير</label><span class="requiredFields">*</span>
            <input type="text" class="form-control" id="managerName" placeholder="أدخل اسم المدير" required />
            <div class="invalid-feedback">اسم المدير مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="userID">رقم الهوية</label><span class="requiredFields">*</span>
            <input type="text" class="form-control" id="userID" placeholder="أدخل رقم الهوية" required />
            <div class="invalid-feedback">رقم الهوية مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="from-hijri-picker-custom"> تاريخ الميلاد </label><span class="requiredFields">*</span>
            <div class="input-group">
                <input id="from-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
            <div class="invalid-feedback">تاريخ الميلاد مطلوب.</div>
        </div>
        <div class="col-12 col-md-4 mb-5">
            <label for="phoneNumber">رقم الجوال</label><span class="requiredFields">*</span>
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
            <label for="clientName">البريد الإلكتروني</label><span class="requiredFields">*</span>
            <input type="text" class="form-control" id="clientName" placeholder="أدخل البريد الإلكتروني" required />
            <div class="invalid-feedback">البريد الإلكتروني مطلوب.</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-content-save-outline"></i> استكمال
        </button>
        <a href="departments-record.html" class="btn btn-outline-primary showBack" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
    </div>
</div>

@section('scripts')
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
<!-- INTERNAL File-Uploads Js-->
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.ui.widget.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.fileupload.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.iframe-transport.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/fancy-uploader.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js">
</script>
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
                    window.location.href = "{{ route('dashboard.backButton') }}";
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

            $("#from-hijri-picker-custom, #to-hijri-picker-custom, #from-hijri-unactive-picker-custom,#to-hijri-unactive-picker-custom").hijriDatePicker({
            hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
            showSwitcher: false,
            format: "YYYY-MM-DD",
            hijriFormat: "iYYYY-iMM-iDD",
            hijriDayViewHeaderFormat: "iMMMM iYYYY",
            dayViewHeaderFormat: "MMMM YYYY",
            ignoreReadonly: true,
            }).on('dp.change', function () {
            table.draw();
            });
        })();
</script>
@endsection
