<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-{{ isset($department) ? 4 : 6 }} mb-5">
            {!! Form::label('departmentName', trans('dashboard.department.department_name')) !!}
            <p class="requiredFields">*</p>
            @foreach ($locales as $locale)
                {!! Form::text("{$locale}[name]", isset($department) ? $department->name : null, ['class' => 'form-control' . ($errors->has("${locale}.name") ? ' is-invalid' : null), 'id' => 'departmentName', 'placeholder' => trans('dashboard.general.enter_name'), 'minlength' => '2', 'maxlength' => '100', 'pattern' => '^[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z]+[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z0-9-_ ]*$', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error("${locale}.name")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endforeach
        </div>

        <div class="col-12 col-md-{{ isset($department) ? 4 : 6 }} mb-5">
            {!! Form::label('mainDepartment', trans('dashboard.department.department_main')) !!}
            {!! Form::select('parent_id', $departments, null, ['class' => 'form-control select2-show-search', 'placeholder' => isset($department) ? trans('dashboard.department.without_parent') : trans('dashboard.department.select_main_department'), 'id' => 'mainDepartment']) !!}

            @error('parent_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        @if (isset($department))
            <div class="col-12 col-md-4 mb-5">
                {!! Form::label('status', trans('dashboard.general.status')) !!}
                {!! Form::select('is_active', trans('dashboard.general.active_cases'), null, ['class' => 'form-control select2', 'id' => 'status']) !!}

                @error('is_active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            {!! Form::label('departmentDes', trans('dashboard.general.description'), ['class' => 'mb-3']) !!}
            @foreach ($locales as $locale)
                {!! Form::textarea("{$locale}[description]", isset($department) ? $department->description : null, ['class' => 'form-control ', 'id' => 'departmentDes', 'rows' => '5', 'placeholder' => trans('dashboard.general.enter_description'), 'maxlength' => '300', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error("{$locale}.description")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endforeach
        </div>
    </div>

</div>

{!! Form::hidden('delete_image', 0, ['id' => 'imageStatus']) !!}

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

            let drEvent = $(".dropify").dropify({
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

            drEvent.on('dropify.afterClear', function(event, element) {
                $('#imageStatus').val(1);
            });

        })();
    </script>
@endsection
