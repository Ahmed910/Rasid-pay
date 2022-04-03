<div class="card py-7 px-7">
    <div class="row">

        <div class="col-12 col-md-{{ isset($rasidJob) ? 4 : 6 }} mb-5">
            {!! Form::label('jobName', trans('dashboard.job.job_name')) !!}
            @foreach ($locales as $locale)
                {!! Form::text("{$locale}[name]", isset($rasidJob) ? $rasidJob->name : null, ['class' => 'form-control' . ($errors->has("${locale}.name") ? ' is-invalid' : null), 'id' => 'jobName', 'placeholder' => trans('dashboard.job.job_name'), 'minlength' => '2', 'maxlength' => '100', 'pattern' => '^[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z]+[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z0-9-_ ]*$', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error("${locale}.name")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endforeach
        </div>

        <div class="col-12 col-md-{{ isset($rasidJob) ? 4 : 6 }} mb-5">
            {!! Form::label('department', trans('dashboard.department.department')) !!}
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search' . ($errors->has('department_id') ? ' is-invalid' : null), 'placeholder' => trans('dashboard.job.select_department'), 'id' => 'department']) !!}

            @error('department_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        @if (isset($rasidJob))
            <div class="col-12 col-md-4 mb-5">
                {!! Form::label('status', trans('dashboard.general.status')) !!}
                {!! Form::select('is_active', trans('dashboard.job.active_cases'), null, ['class' => 'form-control select2' . ($errors->has('is_active') ? ' is-invalid' : null), 'id' => 'status', 'placeholder' => trans('dashboard.general.select_status')]) !!}
                @error('is_active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 col-md-3 mb-5">
                {!! Form::label('jobType', trans('dashboard.general.type')) !!}
                {!! Form::text('is_vacant', trans('dashboard.general.job_type_cases')[$rasidJob->is_vacant], ['class' => 'form-control', 'disabled']) !!}
            </div>
        @endif


        @if (isset($rasidJob) && isset($rasidJob->employee))
            <div class="col-12 col-md-3 mb-5">
                {!! Form::label('employeName', trans('dashboard.rasid_job.employee_name')) !!}
                {!! Form::text('employeeName', $rasidJob->employee->user->fullname, ['class' => 'form-control', 'id' => 'employeName', 'disabled']) !!}
            </div>
        @endif


        <div class="col-12 col-md-{{ isset($rasidJob) && isset($rasidJob->employee) ? 9 : 12 }}">
            {!! Form::label('jobDesc', trans('dashboard.rasid_job.rasid_job_description'), ['class' => 'mb-3']) !!}
            @foreach ($locales as $locale)
                {!! Form::textarea("{$locale}[description]", isset($rasidJob) ? $rasidJob->description : null, ['class' => 'form-control' . ($errors->has("{$locale}[description]") ? ' is-invalid' : null), 'id' => 'jobDesc', 'rows' => '5', 'placeholder' => trans('dashboard.general.description'), 'maxlength' => '300', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error("{$locale}.description")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endforeach
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
    <!-- SELECT2 JS -->
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>

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
        })();
    </script>
@endsection
