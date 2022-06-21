<div class="card py-7 px-7">
    <div class="row mt-3">
        <div class="col-12 col-md-4">
            {!! Form::label('fullname', trans('dashboard.general.username')) !!}
            <span class="requiredFields">*</span>
            {!! Form::text("fullname", null, ['class' => 'form-control input-regex stop-copy-paste', 'id' => "fullname", 'placeholder'
            => trans('dashboard.general.user_name'),'onblur'=>'validateData(this)', 'minlength' => '2', 'maxlength' => '100']) !!}
            <span class="text-danger" id="fullnameError" hidden></span>
        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('mainDepartment', trans('dashboard.department.department_name')) !!} <span
                class="requiredFields">*</span>
            {!! Form::select('department_id', ['' => ''] + $departments, isset($admin) ?
            $admin->employee?->department_id :
            null, ['class' => 'form-control input-regex stop-copy-paste select2-show-search ', 'data-placeholder' =>
            trans('dashboard.department.select_department'),'id' => 'mainDepartment', 'onchange' =>
            'getJobs(this.value)' , (isset($admin) ? 'disabled' : '') ]) !!}
            <span class="text-danger" id="department_idError"></span>

        </div>
        <div class="col-12 col-md-4">
            {!! Form::label('rasid_job_id', trans('dashboard.rasid_job.rasid_job')) !!} <span
                class="requiredFields" id="new_admin">*</span>
                <div id="rasid_job_div">
                {!! Form::select('rasid_job_id', isset($admin) ? ['' => ''] + $rasid_jobs :['' => ''] , isset($admin) ? $admin->employee?->rasid_job_id :null, ['class' => 'form-control input-regex stop-copy-paste select2-show-search ', 'id' =>
                    'rasid_job_id', 'data-placeholder' => trans('dashboard.rasid_job.select_job'),(isset($admin) ? 'disabled' : '')]) !!}
                 </div>
            <span class="text-danger" id="rasid_job_idError"></span>
        </div>

        <div class="col-12 col-md-4 mt-3">
            {!! Form::label('userId', trans('dashboard.admin.login_id')) !!} <span class="requiredFields">*</span>

            @if (isset($admin))

            {!! Form::number('login_id', null, ['class' => 'form-control stop-copy-paste','onblur'=>'validateData(this)', 'oninput' => 'javascript: if
            (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'min' => '0',
            'maxlength'
            => '6', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)', 'id' => 'userId', 'placeholder' =>
            trans('dashboard.admin.enter_login_id'),'disabled' => 'disabled']) !!}
            @else


            {!! Form::number('login_id', null, ['class' => 'form-control stop-copy-paste', 'onblur'=>'validateData(this)','oninput' => 'javascript: if
            (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'min' => '0',
            'maxlength'
            => '6', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)', 'id' => 'userId', 'placeholder' =>
            trans('dashboard.admin.enter_login_id')]) !!}
            @endif

            <span class="text-danger" id="login_idError"></span>
        </div>
        <div class="col-12 col-md-4  mt-3">
            {!! Form::label('email', trans('dashboard.general.email')) !!}
            <span class="requiredFields">*</span>
            {!! Form::email("email", null, ['class' => 'form-control input-regex stop-copy-paste', 'id' => "email",'onblur'=>'validateData(this)' ,'placeholder' =>
            trans('dashboard.general.enter_email'),"autocomplete"=>"off","readonly","onfocus"=>"this.removeAttribute('readonly');", 'minlength' => '2', 'maxlength' => '100']) !!}
            <span class="text-danger" id="emailError" hidden></span>
        </div>
        <div class="col-12 col-md-4  mt-3">
            <label for="phone">{{ trans('dashboard.general.phone') }} </label><span
                class="requiredFields">*</span>
            <div class="input-group">
                <input id="phone" type="number" name="phone" onblur="validateData(this)"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="9"
                    class="form-control stop-copy-paste" placeholder="{{ trans('dashboard.citizens.enter_phone') }} "
                    class="form-control" value="{{ isset($admin) ? $admin->phone : old('phone') }}"/>
                <div class="input-group-text border-start-0">
                    966+
                </div>
            </div>
            <span class="text-danger" id="phoneError" hidden></span>
        </div>

  <div class="row mt-3">
    <div class="col-12">
      <label for="permissions">{{ trans('dashboard.admin.permission_system') }}</label> <span
          class="requiredFields">*</span>
      <div class="input-group permissions">
          <div class="input-group-text input-group-start border-end-0">
              <label>
                  <i class="mdi mdi-magnify tx-16 lh-0 op-6"></i></label>
          </div>
          <select name="permission_list[]" hidden multiple></select>
          <select name="group_list[]" hidden multiple></select>

          <select class="form-control select2 multipleSelect" onchange="addPermissions(this.selectedOptions)"
              data-placeholder="{{ trans('dashboard.general.select_permissions') }}" multiple="multiple"
              id="permissions" required>
                <option value="selectAll" class="selectAll">إختر الكل</option>
                <option value="unselectAll" class="unselectAll" >إلغاء تحديد الكل</option>
              @foreach ($groups as $id => $name)
                  <option value="{{ $id }}" data-name="groups"
                      {{ isset($group) && in_array($id, $group->group_list) ? 'selected' : null }}>
                      {{ $name }}</option>
              @endforeach
              @foreach ($permissions as $id => $name)
                  <option value="{{ $id }}" data-name="permissions"
                      {{ isset($group) && in_array($id, $group->permission_list) ? 'selected' : null }}>
                      {{ $name }}</option>
              @endforeach
          </select>
          <div class="input-group-text border-start-0">
              <label>
                  <b class="select-arrow"></b>
              </label>
          </div>
      </div>
      <span class="text-danger" id="group_listError" hidden></span>
      <span class="text-danger" id="permission_listError" hidden></span>
    </div>

    @if (isset($admin))
    <div class="col-12 col-md-4 mt-3">
      {!! Form::label('status', trans('dashboard.general.status')) !!}
      {!! Form::select('ban_status', trans('dashboard.admin.active_cases'), null, ['class' => 'form-control select2',
      'id' => 'status']) !!}

      <span class="text-danger" id="ban_statusError"></span>
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
      <span class="text-danger" id="ban_fromError"></span>
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
      <span class="text-danger" id="ban_toError"></span>
    </div>
    @endif
    @if (request()->routeIs('dashboard.admin.create'))
    <div class="col-12 col-md-4 mt-3 changePass" @if (isset($admin)) hidden @endif>
      {!! Form::label('newPassword', trans('dashboard.admin.password')) !!} <span class="requiredFields">*</span>
      <div class="input-group" id="show_hide_password">
        {!! Form::password('password', ['class' => 'form-control stop-copy-paste', 'maxlength' => '10', 'onblur'=>'validateData(this)',
        'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
        this.maxLength);', 'pattern' => '^[1-9]\d*$',
        "autocomplete"=>"off",'id'=>'password',"readonly","onfocus"=>"this.removeAttribute('readonly');",'onkeypress' => 'return
        /[0-9]/i.test(event.key)',
        'placeholder' => trans('dashboard.admin.enter_password')]) !!}

        <div class="input-group-text border-start-0">
          <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
        </div>
      </div>
      <span class="text-danger" id="passwordError"></span>
    </div>
    <div class="col-12 col-md-4 mt-3 changePass" @if (isset($admin)) hidden @endif>
      {!! Form::label('newPassword', trans('dashboard.admin.confirmed_password')) !!} <span class="requiredFields">*</span>
      <div class="input-group" id="show_hide_password">
        {!! Form::password('password_confirmation', ['class' => 'form-control stop-copy-paste', 'maxlength' => '10',
        'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
        this.maxLength);', 'pattern' => '^[1-9]\d*$',
        "autocomplete"=>"off","readonly","onfocus"=>"this.removeAttribute('readonly');",'onkeypress' => 'return
        /[0-9]/i.test(event.key)',
        'placeholder' => trans('dashboard.admin.enter_password')]) !!}

        <div class="input-group-text border-start-0">
          <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
        </div>

      </div>
<span class="text-danger" id="password_confirmation_error"></span>
    </div>

    @endif
    <div class="col-12 col-md-8 mt-3 align-items-end">
      <div class="row">
        <div class="col-12 col-md-6 mt-5">

          <div class="form-check mt-5">
            {!! Form::checkbox('is_login_code', '1', isset($admin) && $admin->is_login_code == 1 ? true : false,
            ['class' => 'form-check-input', 'autocomplete'=>'off', 'autocorrect'=>'off', 'autofocus'=>'', 'id' =>
            'verifyCode']) !!}
            {!! Form::label('verifyCode', trans('dashboard.general.Send VerificationCode'), ['class' =>
            'form-check-label']) !!}
            <span class="text-danger" id="is_login_codeError"></span>
          </div>

        </div>
        @if (isset($admin))
        <div class="col-12 col-md-6 mt-5">
          <div class="form-check mt-5">
            {!! Form::checkbox('change_password', '1', false, ['class' => 'form-check-input', 'id' =>
            'changePassword']) !!}
            {!! Form::label('changePassword', trans('dashboard.general.change_password'), ['class' =>
            'form-check-label']) !!}
            <span class="text-danger" id="change_passwordError"></span>
          </div>
        </div>
        @endif
      </div>
    </div>
    @if (request()->routeIs('dashboard.admin.edit'))
    <div class="col-12 col-md-4 mt-3 changePass" @if (isset($admin)) hidden @endif>
      {!! Form::label('newPassword', trans('dashboard.admin.password')) !!} <span class="requiredFields">*</span>
      <div class="input-group" id="show_hide_password">
        {!! Form::password('password', ['class' => 'form-control stop-copy-paste', 'maxlength' => '10',
        'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
        this.maxLength);', 'pattern' => '^[1-9]\d*$', 'onkeypress' => 'return /[0-9]/i.test(event.key)',
        'placeholder' => trans('dashboard.admin.enter_password')]) !!}

        <div class="input-group-text border-start-0">
          <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
        </div>
      </div>
      <span class="text-danger" id="passwordError"></span>
    </div>
    <div class="col-12 col-md-4 mt-3 changePass" @if (isset($admin)) hidden @endif>
      {!! Form::label('newPassword', trans('dashboard.admin.confirmed_password')) !!} <span
        class="requiredFields">*</span>
      <div class="input-group">
        {!! Form::password('password_confirmation', ['class' => 'form-control stop-copy-paste', 'maxlength' => '10',
        'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
        this.maxLength);', 'pattern' => '^[1-9]\d*$', 'onkeypress' => 'return /[0-9]/i.test(event.key)',
        'placeholder' => trans('dashboard.admin.enter_password')]) !!}

        <div class="input-group-text border-start-0">
          <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
<div class="row">
  <div class="col-12 mb-5 text-end">
    {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' =>
    'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
   <a href="{{ url()->previous() }}" class="btn btn-outline-primary" id="showBack">
    <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
</a>
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
@include('dashboard.admin.form_script')
@endsection
