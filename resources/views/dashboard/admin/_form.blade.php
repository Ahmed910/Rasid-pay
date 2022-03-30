  <div class="card py-7 px-7">
      <div class="row">

          <div class="col-12 col-md-4">
              {!! Form::label('mainDepartment', trans('dashboard.department.department_name')) !!}
              {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.department.select_department'), 'id' => 'mainDepartment']) !!}
              @error('department_id')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-12 col-md-4">
              {!! Form::label('userName', trans('dashboard.admin.name')) !!}
              {!! Form::select('employee_id', [], null, ['class' => 'form-control select2', 'id' => 'userName', 'placeholder' => trans('dashboard.general.select_user')]) !!}
              @error('employee_id')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-12 col-md-4">
              {!! Form::label('userId', trans('dashboard.admin.number')) !!}
              {!! Form::number('login_id', null, ['class' => 'form-control ', 'id' => 'userId', 'placeholder' => trans('dashboard.admin.number')]) !!}
              @error('login_id')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>

          <div class="col-12 col-md-8 mt-3">
              {!! Form::label('systemPermission', trans('dashboard.admin.permission_system')) !!}
              {!! Form::select('permission_list[]', $groups, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => trans('dashboard.general.select_permissions'), 'id' => 'systemPermission']) !!}
              @error('permission_list')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-12 col-md-4 mt-3">
              {!! Form::label('status', trans('dashboard.general.status')) !!}
              {!! Form::select('ban_status', trans('dashboard.admin.active_cases'), request('ban_status'), ['class' => 'form-control select2-show-search', 'id' => 'status', 'placeholder' => trans('dashboard.general.select_status')]) !!}
              @error('ban_status')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>

          <div class="col-12 col-md-4 temporary mt-3">
              <label for="validationCustom02"> {{ trans('dashboard.admin.ban_from') }}</label>
              <div class="input-group">
                  {!! Form::text('ban_from', null, ['class' => 'form-control ', 'readonly' => 'readonly', 'id' => 'from-hijri-unactive-picker-custom', 'placeholder' => trans('dashboard.general.day_month_year'), 'value' => "old('ban_from')"]) !!}
                  <div class="input-group-text border-start-0">
                      <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
              </div>
              @error('ban_from')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-12 col-md-4 temporary mt-3">
              <label for="validationCustom02">{{ trans('dashboard.admin.ban_to') }}</label>
              <div class="input-group">
                  {!! Form::text('ban_to', null, ['class' => 'form-control ', 'readonly' => 'readonly', 'id' => 'to-hijri-unactive-picker-custom', 'placeholder' => trans('dashboard.general.day_month_year'), 'value' => "old('ban_to')"]) !!}
                  <div class="input-group-text border-start-0">
                      <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
              </div>
              @error('ban_to')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>


          <div class="col-12 col-md-4 mt-3 d-flex align-items-end">
              <div class="col-12 col-md-6">

                  <div class="form-check">
                      {!! Form::checkbox('is_login_code', '1', false, ['class' => 'form-check-input', 'id' => 'verifyCode']) !!}
                      {!! Form::label('verifyCode', trans('dashboard.general.Send VerificationCode'), ['class' => 'form-check-label']) !!}
                      @error('is_login_code')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>

              </div>
              @if (isset($admin))
                  <div class="col-12 col-md-6">
                      <div class="form-check">
                          {!! Form::checkbox('change_password', '1', false, ['class' => 'form-check-input', 'id' => 'changePassword']) !!}
                          {!! Form::label('changePassword', trans('dashboard.general.change_password'), ['class' => 'form-check-label']) !!}
                          @error('change_password')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
              @endif
          </div>


          <div class="col-12 col-md-4 mt-3 changePass">
              <div class="form-group">
                  {!! Form::label('newPassword', trans('dashboard.admin.new_password')) !!}
                  <div class="input-group" id="show_hide_password">
                      {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('dashboard.admin.new_password')]) !!}
                      <div class="input-group-text bg-white border-start-0">
                          <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
                      </div>
                  </div>
                  @error('password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          </div>
          <div class="col-12 col-md-4 mt-3 changePass">
              <div class="form-group">
                  {!! Form::label('confirmPassword', trans('dashboard.admin.confirmed_password')) !!}
                  <div class="input-group" id="show_hide_confirm_password">
                      {!! Form::password('confirmed_password', ['class' => 'form-control', 'placeholder' => trans('dashboard.admin.confirmed_password')]) !!}
                      <div class="input-group-text bg-white border-start-0">
                          <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
                      </div>
                  </div>
                  @error('confirmed_password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-12 mb-5 text-end">
          {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . $btn_submit, ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
          {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button', 'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}
      </div>
  </div>

  @include('dashboard.layouts.modals.confirm')
  @include('dashboard.layouts.modals.back')

  @section('scripts')
      <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
      <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
      <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
      <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
      <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
      <script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}">
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
                                      // form.classList.add("was-validated");
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
              $("#from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
                  .hijriDatePicker({
                      hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                      showSwitcher: false,
                      format: "YYYY-MM-DD",
                      hijriFormat: "iYYYY-iMM-iDD",
                      hijriDayViewHeaderFormat: "iMMMM iYYYY",
                      dayViewHeaderFormat: "MMMM YYYY",
                      showClear: true,
                      ignoreReadonly: true,
                  });


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

              //change password checkbox
              $("#changePassword").change(function() {
                  if (this.checked) {
                      $(".changePass").show();
                  } else {
                      $(".changePass").hide();
                  }
              });

              // temporary status appear date
              $(document).ready(function() {
                  $("#status").change(function() {
                      if (this.value == 'temporary') {
                          $(".temporary").show();
                      } else {
                          $(".temporary").hide();
                          $('#from-hijri-unactive-picker-custom').val('');
                          $('#to-hijri-unactive-picker-custom').val('');
                      }
                  }).change();
              });


              //get users from department script
              $("#mainDepartment").change(function(e) {
                  e.preventDefault();
                  let department_id = $("#mainDepartment").val();

                  $('#userName').empty();
                  $("#userName").append(
                      '<option value=""> {{ trans('dashboard.general.select_user') }} </option>')
                  if (department_id != '') {
                      //send ajax
                      $.ajax({
                          url: '{{ url('/dashboard/admin/all-employees') }}' + '/' + department_id,
                          type: 'get',
                          success: function(data) {
                              if (data) {
                                  $.each(data.data, function(index, user) {
                                      $("#userName").append('<option value="' + user.id +
                                          '">' + user.fullname + '</option>')
                                  });
                              }
                          }
                      });
                  }

              });

              $(document).ready(function() {
                  $("#show_hide_password a").on("click", function(event) {
                      event.preventDefault();
                      if ($("#show_hide_password input").attr("type") == "text") {
                          $("#show_hide_password input").attr("type", "password");
                          $("#show_hide_password i").addClass("mdi-eye-off-outline");
                          $("#show_hide_password i").removeClass("mdi-eye-outline");
                      } else if (
                          $("#show_hide_password input").attr("type") == "password"
                      ) {
                          $("#show_hide_password input").attr("type", "text");
                          $("#show_hide_password i").removeClass("mdi-eye-off-outline");
                          $("#show_hide_password i").addClass("mdi-eye-outline");
                      }
                  });

              });

              $(document).ready(function() {
                  $("#show_hide_confirm_password a").on("click", function(event) {
                      event.preventDefault();
                      if ($("#show_hide_confirm_password input").attr("type") == "text") {
                          $("#show_hide_confirm_password input").attr("type", "password");
                          $("#show_hide_confirm_password i").addClass("mdi-eye-off-outline");
                          $("#show_hide_confirm_password i").removeClass("mdi-eye-outline");
                      } else if (
                          $("#show_hide_confirm_password input").attr("type") == "password"
                      ) {
                          $("#show_hide_confirm_password input").attr("type", "text");
                          $("#show_hide_confirm_password i").removeClass("mdi-eye-off-outline");
                          $("#show_hide_confirm_password i").addClass("mdi-eye-outline");
                      }
                  });

              });

          })();
      </script>
  @endsection
