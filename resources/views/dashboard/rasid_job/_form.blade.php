<div class="card py-7 px-7">
    <div class="row">

        <div class="col-12 col-md-{{ isset($rasidJob) ? 4 : 6 }}">
            {!! Form::label('jobName', trans('dashboard.rasid_job.job_name')) !!}
            <span class="requiredFields">*</span>
            @foreach ($locales as $locale)
                {!! Form::text("{$locale}[name]", isset($rasidJob) ? $rasidJob->name : null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("${locale}.name") ? ' is-invalid' : null), 'id' => "{$locale}_name", 'placeholder' => trans('dashboard.general.enter_name'), 'minlength' => '2', 'maxlength' => '100','onblur'=>'validateData(this)']) !!}

                <span class="text-danger" id="{{ $locale }}.nameError" hidden></span>
            @endforeach
        </div>

        <div class="col-12 col-md-{{ isset($rasidJob) ? 4 : 6 }}">
            {!! Form::label('department', trans('dashboard.department.department')) !!}
            <span class="requiredFields">*</span>

            {!! Form::select('department_id', [''=>'']+$departments, null, ['class' => 'form-control select2-show-search' . ($errors->has('department_id') ? ' is-invalid' : null), 'dir' => 'rtl', 'data-placeholder' => trans('dashboard.rasid_job.select_department'), 'id' => 'department']) !!}

            <span class="text-danger" id="department_idError"></span>

        </div>

        @if (isset($rasidJob))
            <div class="col-12 col-md-4">
                {!! Form::label('status', trans('dashboard.general.status')) !!}
                <span class="requiredFields">*</span>

                {!! Form::select('is_active', [''=>'']+trans('dashboard.rasid_job.active_cases'), null, ['class' => 'form-control select2' . ($errors->has('is_active') ? ' is-invalid' : null), 'id' => 'status', 'data-placeholder' => trans('dashboard.general.select_status')]) !!}

                <span class="text-danger" id="is_activeError"></span>


            </div>

            <div class="col-12 col-md-3">
                {!! Form::label('jobType', trans('dashboard.general.type')) !!}
                {!! Form::text('is_vacant', trans('dashboard.general.job_type_cases')[$rasidJob->is_vacant], ['class' => 'form-control', 'disabled']) !!}
            </div>
        @endif


        @if (isset($rasidJob) && isset($rasidJob->employee))
            <div class="col-12 col-md-3">
                {!! Form::label('employeName', trans('dashboard.rasid_job.employee_name')) !!}
                {!! Form::text('employeeName', $rasidJob->employee->user->fullname, ['class' => 'form-control', 'id' => 'employeName', 'disabled']) !!}
            </div>
        @endif


        <div class="col-12 col-md-{{ isset($rasidJob) && isset($rasidJob->employee) ? 9 : 12 }}">
            {!! Form::label('jobDesc', trans('dashboard.rasid_job.rasid_job_description'), ['class' => 'mb-3']) !!}
            @foreach ($locales as $locale)
                {!! Form::textarea("{$locale}[description]", isset($rasidJob) ? $rasidJob->description : null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("{$locale}[description]") ? ' is-invalid' : null), 'id' => 'jobDesc', 'rows' => '5', 'placeholder' => trans('dashboard.general.enter_description'), 'maxlength' => '300', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}

                <span class="text-danger" id="{{ $locale }}.descriptionError"></span>
            @endforeach
        </div>

    </div>
</div>

<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary showBack">
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

    <script>
    </script>
@endsection
