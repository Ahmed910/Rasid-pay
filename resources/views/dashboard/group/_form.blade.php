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
        @if (request()->routeIs('dashboard.group.edit'))
            <div class="col-12 col-md-6 mb-5">
                {!! Form::label('status', trans('dashboard.general.status')) !!}
                {!! Form::select('is_active', trans('dashboard.general.active_cases'), null, ['class' => 'form-control select2', 'id' => 'status', 'required' => 'required', 'placeholder' => trans('dashboard.general.select_status')]) !!}
                @error("is_active")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endif
        <div class="col-12 col-md-12 mb-5">
            <label for="permissions">صلاحيات النظام</label>
            <select name="permission_list[]" hidden multiple></select>
            <select name="group_list[]" hidden multiple></select>

            <select class="form-control select2" onchange="addPermissions(this.selectedOptions)" data-placeholder="اختر الصلاحيات" multiple="multiple" id="permissions"
                required>
                @foreach ($groups as $id => $name)
                    <option value="{{ $id }}" data-name="groups" {{ isset($group) && in_array($id,$group->group_list) ? 'selected' : null }}>{{ $name }}</option>
                @endforeach
                @foreach ($permissions as $id => $name)
                    <option value="{{ $id }}" data-name="permissions" {{ isset($group) && in_array($id,$group->permission_list) ? 'selected' : null }}>{{ $name }}</option>
                @endforeach
            </select>
            @error("group_list",'permission_list')
                <span class="text-danger">{{ $message }}</span>
            @enderror
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
            let permissions = @isset($group)  @json($group->permission_list) @else [] @endisset;
            let groups = @isset($group)  @json($group->group_list) @else [] @endisset;
            groups.forEach((item, i) => {
                $('[name="group_list[]"]').append(`<option value="${item}" selected></option>`);
            });
            permissions.forEach((item, i) => {
                $('[name="permission_list[]"]').append(`<option value="${item}" selected></option>`);
            });
        });

        function addPermissions(selected) {
            let group_options = '';
            let permission_options = '';
            $.each(selected,(index,item) => {
                if (item.getAttribute('data-name') == 'groups') {
                    group_options += `<option value="${item.value}" selected></option>`;
                }
                if (item.getAttribute('data-name') == 'permissions') {
                    permission_options += `<option value="${item.value}" selected></option>`;
                }
            });
            $('[name="permission_list[]"]').html(permission_options);
            $('[name="group_list[]"]').html(group_options);
        }
    </script>
@endsection
