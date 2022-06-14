<div class="card py-7 px-7">
  <div class="row">
    <div class="col-12 col-md-{{ isset($department) ? 4 : 6 }}">
      {!! Form::label('departmentName', trans('dashboard.department.department_name')) !!}
      <span class="requiredFields">*</span>
      @foreach ($locales as $locale)
      {!! Form::text("{$locale}[name]", isset($department) ? $department->name : null, ['class' => 'form-control
      input-regex stop-copy-paste', 'id' => "{$locale}_name", 'placeholder' => trans('dashboard.general.enter_name'),'onkeyup'=>'removeValidation()','onblur'=>'validateData(this.id)',
      'minlength' => '2', 'maxlength' => '100']) !!}
      <span class="text-danger dd" id="{{ $locale }}.nameError" hidden></span>
      @endforeach
    </div>

    <div class="col-12 col-md-{{ isset($department) ? 4 : 6 }}">
      {!! Form::label('mainDepartment', trans('dashboard.department.main_department')) !!}
      {!! Form::select('parent_id', $appendArray + $departments, request()->routeIs('dashboard.department.edit') && ! $department->parent_id ? 'without' : null, ['class' => 'form-control select2-show-search' .
      ($errors->has('parent_id') ? ' border-danger' : null), 'data-placeholder' =>
      trans('dashboard.department.select_main_department'), 'id' => 'parent_id']) !!}
      <span class="text-danger" id="parent_idError" hidden></span>
    </div>

    @if (isset($department))
    <div class="col-12 col-md-{{ isset($department) ? 4 : 6 }}">
      {!! Form::label('status', trans('dashboard.general.status')) !!}
      <span class="requiredFields">*</span>
      {!! Form::select('is_active', trans('dashboard.department.active_cases'), null, ['class' => 'form-control
      select2', 'id' => 'status']) !!}
      <span class="text-danger" id="statusError" hidden></span>
    </div>
    @endif

    <div class="col-12 mb-3">
      {!! Form::label('departmentImg', trans('dashboard.department.department_image') . ' (JPG, PNG, JPEG)') !!}
      {!! Form::file('image', [
      'class' => 'dropify',
      'data-show-remove' => 'true',
      'data-default-file' => isset($department) ? $department->image : null,
      'data-bs-height' => '250',
      'id' => 'departmentImg',
      'data-errors-position' => 'inside',
      'data-show-errors' => 'true',
      'data-show-loader' => 'true',
      'data-allowed-file-extensions' => 'jpg png jpeg',
      'accept' => 'image/png, image/jpg, image/jpeg',
      ]) !!}

      <span class="text-danger" id="imageError" hidden></span>
    </div>

    <div class="col-12">
      {!! Form::label('departmentDes', trans('dashboard.general.description'), ['class' => 'mb-3']) !!}
      @foreach ($locales as $locale)
      {!! Form::textarea("{$locale}[description]", isset($department) ? $department->description : null, ['class' =>
      'form-control input-regex stop-copy-paste', 'id' => "$locale.description", 'rows' => '5', 'placeholder' =>
      trans('dashboard.general.enter_description'), 'maxlength' => '300', 'onpaste' => 'return false;', 'oncopy' =>
      'return false;', 'ondrop' => 'return false;']) !!}

      <span class="text-danger" id="{{ $locale }}.descriptionError" hidden></span>
      @endforeach
    </div>
  </div>

</div>

{!! Form::hidden('delete_image', 0, ['id' => 'imageStatus']) !!}
{!! Form::hidden('createStatus', $createVal, ['id' => 'createStatus']) !!}


<div class="row">
  <div class="col-12 mb-5 text-end">
    {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' =>
    'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
      <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
  </a>
  </div>
</div>

@include('dashboard.layouts.modals.confirm')
@include('dashboard.layouts.modals.back')
@include('dashboard.layouts.modals.alert')

@section('scripts')
<!-- SELECT2 JS -->
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
  integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $("#parent_id").on("select2:select", function (e) {
    $("#createStatus").val(1);
  });

</script>
@endsection
