<div class="card py-7 px-7">
    <div class="row mt-3">
        <div class="col-12 col-md-4">
            {!! Form::label('mainDepartment', trans('dashboard.department.department_name')) !!} <span
                class="requiredFields">*</span>
            {!! Form::select('department_id', ['' => ''] + $departments, isset($admin) ?
            $admin->employee?->department_id :
            null, ['class' => 'form-control select2-show-search', 'data-placeholder' =>
            trans('dashboard.department.select_department'),'id' => 'mainDepartment', 'onchange' =>
            'getJobs(this.value)']) !!}
            <span class="text-danger" id="department_id_error"></span>

        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('rasid_job_id', trans('dashboard.rasid_job.rasid_job')) !!} <span
                class="requiredFields">*</span>
            @isset($admin)
            {!! Form::select('rasid_job_id', ['' => ''] + $rasid_jobs, $admin->employee?->rasid_job_id, ['class' =>
            'form-control select2-show-search', 'id' => 'rasid_job_id', 'data-placeholder' =>
            trans('dashboard.rasid_job.rasid_job')]) !!}
            @else
            {!! Form::select('rasid_job_id', ['' => ''], null, ['class' => 'form-control select2-show-search', 'id' =>
            'rasid_job_id', 'data-placeholder' => trans('dashboard.rasid_job.rasid_job')]) !!}
            @endisset
            <span class="text-danger" id="rasid_job_id_error"></span>
        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('fullname', trans('dashboard.general.name')) !!}
            <span class="requiredFields">*</span>
            {!! Form::text("fullname", null, ['class' => 'form-control input-regex', 'id' => "fullname", 'placeholder'
            => trans('dashboard.general.name'), 'minlength' => '2', 'maxlength' => '100']) !!}
            <span class="text-danger" id="fullname_error" hidden></span>
        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('email', trans('dashboard.general.email')) !!}
            <span class="requiredFields">*</span>
            {!! Form::email("email", null, ['class' => 'form-control', 'id' => "email", 'placeholder' =>
            trans('dashboard.general.email'), 'minlength' => '2', 'maxlength' => '100']) !!}
            <span class="text-danger" id="email_error" hidden></span>
        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('phone', trans('dashboard.general.phone')) !!}
            <span class="requiredFields">*</span>
            {!! Form::text("phone", null, ['class' => 'form-control input-regex', 'id' => "phone", 'placeholder' =>
            trans('dashboard.general.phone'), 'minlength' => '2', 'maxlength' => '100']) !!}
            <span class="text-danger" id="phone_error" hidden></span>
        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('userId', trans('dashboard.admin.login_id')) !!} <span class="requiredFields">*</span>

            @if (isset($admin))

            {!! Form::number('login_id', null, ['class' => 'form-control stop-copy-paste', 'oninput' => 'javascript: if
            (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'min' => '0',
            'maxlength'
            => '6', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)', 'id' => 'userId', 'placeholder' =>
            trans('dashboard.admin.login_id'),'disabled' => 'disabled']) !!}
            @else


            {!! Form::number('login_id', null, ['class' => 'form-control stop-copy-paste', 'oninput' => 'javascript: if
            (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'min' => '0',
            'maxlength'
            => '6', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)', 'id' => 'userId', 'placeholder' =>
            trans('dashboard.admin.login_id')]) !!}
            @endif

            <span class="text-danger" id="login_id_error"></span>
        </div>
    </div>

    <div class="row mt-3">
        {{-- <div class="col-12 col-md-8 mt-3">
            {!! Form::label('systemPermission', trans('dashboard.admin.permission_system')) !!}
            {!! Form::select('permission_list[]', $groups, null, ['class' => 'form-control select2', 'multiple' =>
            'multiple', 'data-placeholder' => trans('dashboard.general.select_permissions'), 'id' =>
            'systemPermission']) !!}
            @error('permission_list')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div> --}}

        <div class="col-12 col-md-8">
            <label for="permissions">{{ trans('dashboard.admin.permission_system') }}</label> <span
                class="requiredFields">*</span>
            <select class="form-control" name="permission_list[]" hidden multiple required></select>
            <select class="form-control" name="group_list[]" hidden multiple required></select>

            <select class="form-control select2" onchange="addPermissions(this.selectedOptions)"
                data-placeholder="{{ trans('dashboard.general.select_permissions') }}" multiple="multiple"
                id="permissions" required>


                <optgroup label="{{ trans('dashboard.group.groups') }}">
                    @foreach ($groups as $id => $name)
                    <option value="{{ $id }}" data-name="groups" {{ isset($admin) && in_array($id, $admin->group_list) ?
                        'selected' : null }}>
                        {{ $name }}</option>
                    @endforeach
                </optgroup>

                <optgroup label="{{ trans('dashboard.permission.permissions') }}">
                    @foreach ($permissions as $id => $name)
                    <option value="{{ $id }}" data-name="permissions" {{ isset($admin) && in_array($id, $admin->
                        permission_list) ? 'selected' : null }}>
                        {{ $name }}</option>
                    @endforeach
                </optgroup>

            </select>


            <span class="text-danger" id="permission_list_error"></span>
            <span class="text-danger" id="group_list_error"></span>


        </div>
        @if (isset($admin))
        <div class="col-12 col-md-4 mt-3">
            {!! Form::label('status', trans('dashboard.general.status')) !!}
            {!! Form::select('ban_status', trans('dashboard.admin.active_cases'), null, ['class' => 'form-control
            select2', 'id'
            => 'status']) !!}

            <span class="text-danger" id="ban_status_error"></span>
        </div>
        <div class="col-12 col-md-4 temporary mt-3">
            <label for="validationCustom02"> {{ trans('dashboard.admin.ban_from') }}</label>
            <div class="input-group">
                {!! Form::text('ban_from', null, ['class' => 'form-control ', 'readonly' => 'readonly', 'id' =>
                'from-hijri-unactive-picker-custom', 'placeholder' => trans('dashboard.general.day_month_year'), 'value'
                =>
                "old('ban_from')"]) !!}
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
            <span class="text-danger" id="ban_from_error"></span>
        </div>
        <div class="col-12 col-md-4 temporary mt-3">
            <label for="validationCustom02">{{ trans('dashboard.admin.ban_to') }}</label>
            <div class="input-group">
                {!! Form::text('ban_to', null, ['class' => 'form-control ', 'readonly' => 'readonly', 'id' =>
                'to-hijri-unactive-picker-custom', 'placeholder' => trans('dashboard.general.day_month_year'), 'value'
                =>
                "old('ban_to')"]) !!}
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
            <span class="text-danger" id="ban_to_error"></span>
        </div>
        @endif
        <div class="col-12 col-md-4 mt-3 d-flex align-items-end">
            <div class="col-12 col-md-6">

                <div class="form-check">
                    {!! Form::checkbox('is_login_code', '1', isset($admin) && $admin->is_login_code == 1 ? true : false,
                    ['class' => 'form-check-input', 'id' => 'verifyCode']) !!}
                    {!! Form::label('verifyCode', trans('dashboard.general.Send VerificationCode'), ['class' =>
                    'form-check-label']) !!}
                    <span class="text-danger" id="is_login_code_error"></span>
                </div>

            </div>
            @if (isset($admin))
            <div class="col-12 col-md-6">
                <div class="form-check">
                    {!! Form::checkbox('change_password', '1', false, ['class' => 'form-check-input', 'id' =>
                    'changePassword']) !!}
                    {!! Form::label('changePassword', trans('dashboard.general.change_password'), ['class' =>
                    'form-check-label']) !!}
                    <span class="text-danger" id="change_password_error"></span>
                </div>
            </div>
            @endif
        </div>


        <div class="col-12 col-md-4 mt-3 changePass" @if (isset($admin)) hidden @endif>
            {!! Form::label('newPassword', trans('dashboard.admin.password')) !!} <span class="requiredFields">*</span>
            <div class="input-group" id="show_hide_password">
                {!! Form::password('password', ['class' => 'form-control stop-copy-paste', 'maxlength' => '10',
                'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
                this.maxLength);', 'pattern' => '^[1-9]\d*$', 'onkeypress' => 'return /[0-9]/i.test(event.key)',
                'placeholder' => trans('dashboard.admin.new_password')]) !!}

                <div class="input-group-text border-start-0">
                    <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
                </div>
            </div>
            <span class="text-danger" id="password_error"></span>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' =>
        'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
        {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button',
        'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}
    </div>
</div>

@include('dashboard.layouts.modals.confirm')
@include('dashboard.layouts.modals.back')
@include('dashboard.layouts.modals.alert')

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
    //get users from department script
     function getJobs(department_id) {
          $('#rasid_job_id').empty();
          $('#rasid_job_id').append(new Option('', '', true, true)).trigger('change');
          if (department_id != '') {
              //send ajax
              $.ajax({
                  url: '{{ url('/dashboard/admin/all-jobs') }}' + '/' + department_id,
                  type: 'get',
                  success: function(data) {
                      if (data) {
                          $.each(data.data, function(index, job) {
                            let newOption = new Option(job.name, job.id, false, false);
                            $('#rasid_job_id').append(newOption).trigger('change');
                          });
                      }
                  }
              });
          }
      }
          function addPermissions(selected) {
              let group_options = '';
              let permission_options = '';
              $.each(selected, (index, item) => {
                  if (item.getAttribute('data-name') == 'groups') {
                      group_options += `<option value="${item.value}" selected class="group_select"></option>`;
                  }
                  if (item.getAttribute('data-name') == 'permissions') {
                      permission_options +=
                          `<option value="${item.value}" selected class="permission_select"></option>`;
                  }
              });
              $('[name="permission_list[]"]').html(permission_options);
              $('[name="group_list[]"]').html(group_options);
          }


          (function() {
            let validate = false;
            let saveButton = true;
            let permissions = @isset($admin)  @json($admin->permission_list) @else [] @endisset;
            let groups = @isset($admin)  @json($admin->group_list) @else [] @endisset;

              groups.forEach((item, i) => {
                  $('[name="group_list[]"]').append(
                      `<option value="${item}" selected class="group_select"></option>`);
              });
              permissions.forEach((item, i) => {
                  $('[name="permission_list[]"]').append(
                      `<option value="${item}" selected class="permission_select"></option>`);
              });

              $('#saveButton').on('click', function(e) {
                  e.preventDefault();

                  $('span[id*="_error"]').html('');
                  $('*input,select').removeClass('is-invalid');

                  let form = $('#formId')[0];
                  let data = new FormData(form);

                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $.ajax({
                      url: $('#formId').attr('action'),
                      type: "POST",
                      data: data,
                      beforeSend: toggleSaveButton(),
                      processData: false,
                      contentType: false,
                      cache: false,
                      success: function() {
                          $('#successModal').modal('show');
                          toggleSaveButton();
                      },
                      error: function(data) {
                          toggleSaveButton();

                          $.each(data.responseJSON.errors, function(name, message) {
                              let inputName = name;
                              let inputError = name + '_error';

                              $('input[name="' + inputName + '"]').addClass('is-invalid');
                              $('select[name="' + inputName + '"]').addClass('is-invalid');
                              $('span[id="' + inputError + '"]').html(
                                  `<small>${message}</small>`);
                          });
                      }
                  });
              });

              function toggleSaveButton() {
                  if (saveButton) {
                      saveButton = false;
                      $("#saveButton").html('<i class="spinner-border spinner-border-sm"></i>' + "{{ trans('dashboard.general.save') }}");
                      $('#saveButton').attr('disabled', true);
                  } else {
                      saveButton = true;
                      $("#saveButton").html('<i class="mdi mdi-content-save-outline"></i>' + "{{ trans('dashboard.general.save') }}");
                      $('#saveButton').attr('disabled', false);
                  }
              }
              $("#showBack").click(function() {
                  if (validate) {
                      $('#backModal').modal('show');
                      return false;
                  } else {
                      window.location.href = "{{ route('dashboard.backButton') }}";
                  }
              });

              $("input,select").change(function() {
                  validate = true;
              });


              $("#from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
                  .hijriDatePicker({
                      hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                      showSwitcher: false,
                      format: "YYYY-MM-DD",
                      hijriFormat: "iYYYY-iMM-iDD",
                      hijriDayViewHeaderFormat: "iMMMM iYYYY",
                      dayViewHeaderFormat: "MMMM YYYY",
                      ignoreReadonly: true,
                  });


              //change password checkbox
              $("#changePassword").change(function() {
                  if (this.checked) {
                      $(".changePass").attr('hidden', false);
                  } else {
                      $(".changePass").attr('hidden', true);
                  }
              });

              // temporary status appear date

              $("#status").change(function() {
                  if (this.value == 'temporary') {
                      $(".temporary").show();
                  } else {
                      $(".temporary").hide();
                      $('#from-hijri-unactive-picker-custom').val('');
                      $('#to-hijri-unactive-picker-custom').val('');
                  }
              }).change();

              //get users from department script
              $("#mainDepartment").change(function(e) {
                  e.preventDefault();
                  let department_id = $("#mainDepartment").val();

                  $('#userName').empty();
                  $('#userName').append(new Option('', '', true, true)).trigger('change');

                  if (department_id != '') {
                      //send ajax
                      $.ajax({
                          url: '{{ url('/dashboard/admin/all-employees') }}' + '/' + department_id,
                          type: 'get',
                          success: function(data) {
                              if (data) {
                                  $.each(data.data, function(index, user) {
                                    let newOption = new Option(user.fullname, user.id, false, false);
                                    $('#userName').append(newOption).trigger('change');
                                  });
                              }
                          }
                      });
                  }

              });

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
                  $('#userId').on('keypress', function(event) {
                      var key = event.charCode ? event.charCode : event.keyCode;
                      $("#userId").innerHTML = key;
                      if (key == 46) {
                          event.preventDefault();
                          return false;
                      }
                  });
          })();
</script>
@endsection
