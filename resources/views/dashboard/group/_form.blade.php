<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('departmentName', trans('dashboard.department.department_name')) !!}
            @foreach ($locales as $locale)
                {!! Form::text("{$locale}[name]", isset($group) ? $group->name : null, ['class' => 'form-control ', 'placeholder' => trans('dashboard.department.department_name'), 'minlength' => '2', 'maxlength' => '100', 'required' => 'required', 'pattern' => '^[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z]+[\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFa-zA-Z0-9-_ ]*$', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}
                @error("${locale}.name")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endforeach
        </div>
        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('status', trans('dashboard.general.status')) !!}
            {!! Form::select('is_active', trans('dashboard.general.active_cases'), null, ['class' => 'form-control select2', 'id' => 'status', 'required' => 'required', 'placeholder' => trans('dashboard.general.select_status')]) !!}
            <div class="invalid-feedback">الحالة مطلوبة.</div>
        </div>
        <div class="col-12 col-md-12 mb-5">
            <label for="permissions">صلاحيات النظام</label>
            <select name="permission_list[]" hidden multiple></select>
            <select name="group_list[]" hidden multiple></select>

            <select class="form-control select2" data-placeholder="اختر الصلاحيات" multiple="multiple" id="permissions"
                required>
                <optgroup label="@lang('dashboard.group.groups')">
                    @foreach ($groups as $id => $name)
                        <option value="{{ $id }}" data-name="groups">{{ $name }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="@lang('dashboard.permission.permissions')">
                    @foreach ($permissions as $id => $name)
                        <option value="{{ $id }}" data-name="permissions">{{ $name }}</option>
                    @endforeach
                </optgroup>
            </select>
            <div class="invalid-feedback">الصلاحيات مطلوبة.</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-content-save-outline"></i> حفظ
        </button>
        <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
    </div>
</div>
<!-- ROW CLOSED -->
@section('scripts')
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>

    <script>
        $(function() {
            let permissions = [];
            let groups = [];

            $('#permissions').on('change', function() {
                let optgroupId = $('#permissions option:selected').last().attr('data-name');

                if (optgroupId == 'groups') {
                    groups.push($('#permissions option:selected').last().attr('value'));
                }

                if (optgroupId == 'permissions') {
                    permissions.push($('#permissions option:selected').last().attr('value'));
                }

                $('[name="permission_list[]"]').empty();
                $('[name="group_list[]"]').empty();

                permissions.map(function(item, i) {
                    $('[name="permission_list[]"]').append(
                        `<option value="${item}" selected></option>`);
                })

                groups.map(function(item, i) {
                    $('[name="group_list[]"]').append(
                        `<option value="${item}" selected></option>`);
                })

            });

        });
    </script>
@endsection
