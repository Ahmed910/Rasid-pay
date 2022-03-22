<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-4 mb-5">
            {!! Form::label('departmentName', trans('dashboard.department.department_name')) !!}
            @foreach ($locales as $locale)
                {!! Form::text("{$locale}[name]", isset($department) ? $department->name : null, ['class' => 'form-control ', 'id' => 'departmentName', 'placeholder' => trans('dashboard.department.department_name'), 'minlength' => '2', 'maxlength' => '100', 'pattern' => '^[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z]+[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z0-9-_ ]*$', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error ("${locale}.name")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endforeach
        </div>

        <div class="col-12 col-md-4 mb-5">
            {!! Form::label('mainDepartment', trans('dashboard.department.department_name')) !!}
            {!! Form::select('parent_id', $departments, null, ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.department.without_parent'), 'id' => 'mainDepartment']) !!}

            @error ("parent_id")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12 col-md-4 mb-5">
            {!! Form::label('status', trans('dashboard.general.status')) !!}
            {!! Form::select('is_active', trans('dashboard.general.active_cases'), null, ['class' => 'form-control select2', 'id' => 'status', 'placeholder' => trans('dashboard.general.select_status')]) !!}
            @error ("is_active")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12 mb-3">
            {!! Form::label('departmentImg', trans('dashboard.department.department_image') . ' (JPG, PNG, JPEG, WEBP)') !!}
            {!! Form::file('image', [
                'class' => 'dropify',
                'data-show-remove' => 'true',
                'data-default-file' => isset($department) && count($department->images) > 0 ? asset("{$department->images[0]->media}") : '', 'data-bs-height' => '250',
                'id' => 'departmentImg',
                'data-errors-position' => 'inside',
                'data-show-errors' => 'true',
                'data-show-loader' => 'true',
                'data-allowed-file-extensions' => 'jpg png jpeg webp',
                'accept' => 'image/png, image/jpg, image/jpeg, image/webp'
                ]) !!}
            @error ("image")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            {!! Form::label('departmentDes', trans('dashboard.general.description'), ['class' => 'mb-3']) !!}
            @foreach ($locales as $locale)
                {!! Form::textarea("{$locale}[description]", isset($department) ? $department->description : null, ['class' => 'form-control ', 'id' => 'departmentDes', 'rows' => '5', 'placeholder' => trans('dashboard.general.description'), 'maxlength' => '300', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error ("{$locale}.description")
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

    <!-- FILE UPLOADES JS -->
    <script src="{{ asset('dashboardAssets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/fileuploads/js/file-upload.js') }}"></script>

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
