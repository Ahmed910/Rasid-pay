<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-6">
            {!! Form::label('departmentName', trans('dashboard.group.group_name')) !!} <span class="requiredFields">*</span>
            @foreach ($locales as $locale)
            {!! Form::text("{$locale}[name]", isset($group) ? $group->name : null, ['class' => 'form-control input-regex stop-copy-paste', 'placeholder' => trans('dashboard.general.enter_name'),'onkeyup'=>'removeValidation()', 'minlength' => '2', 'maxlength' => '100', 'required' => 'required','onblur'=>'validateData(this)','id'=>"{$locale}_name"]) !!}
            <span class="text-danger dd" id="{{ $locale }}.nameError" hidden></span>
            @endforeach
        </div>
        @if (request()->routeIs('dashboard.group.edit'))
            <div class="col-12 col-md-6">
                {!! Form::label('status', trans('dashboard.general.status')) !!}
                {!! Form::select('is_active', trans('dashboard.general.active_cases'), null, ['class' => 'form-control select2', 'id' => 'status', 'required' => 'required']) !!}

                <span class="text-danger" id="statusError" hidden></span>
            </div>
        @endif

        <div class="col-12 col-md-6">
            <label for="permissions">{{ trans('dashboard.admin.permission_system') }}</label> <span
                class="requiredFields">*</span>
            <div class="input-group permissions">
                <div class="input-group-text input-group-start border-end-0">
                    <label>
                        <i class="mdi mdi-magnify tx-16 lh-0 op-6"></i></label>
                </div>


                <select class="form-control select2 multipleSelect select2-show-search" name="permission_list[]" onchange="addPermissions(this.selectedOptions)"
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
        <input type="hidden" name="previous_url" value="{{ $previousUrl }}">

    </div>
</div>
<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
        {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button', 'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}
    </div>
</div>
{{-- <i class="mdi mdi-clipboard-list"  data-bs-toggle="popoverRoles" tabindex="1"
                                    data-bs-placement="right" data-bs-html="true"
                                    title="<span class='tooltipRole'> hesham</span>"></i> --}}

@include('dashboard.layouts.modals.confirm')
@include('dashboard.layouts.modals.back')
@include('dashboard.layouts.modals.alert')


<!-- ROW CLOSED -->
@section('scripts')
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>

    <script>
        $(function() {
            let permissions =
                @isset($group)
                    @json($group->permission_list)
                @else
                    []
                @endisset ;
            let groups =
                @isset($group)
                    @json($group->group_list)
                @else
                    []
                @endisset ;
            groups.forEach((item, i) => {
                $('[name="group_list[]"]').append(
                    `<option value="${item}" selected class="group_select"></option>`);
            });
            permissions.forEach((item, i) => {
                $('[name="permission_list[]"]').append(
                    `<option value="${item}" selected class="permission_select"></option>`);
            });
        });



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


        $(document).ready(function() {
            $(".multipleSelect").select2({
                closeOnSelect: false
            });
            $(".multipleSelect").select2({
                closeOnSelect: false,
                templateResult: formatState
            });

            $('.multipleSelect').on("select2:select", function(e) {
                var data = e.params.data.text;
                if (data == 'إختر الكل'){
                    $(".multipleSelect > option").prop("selected", "selected");
                    $(".multipleSelect").trigger("change");
                    $(".custom-checkbox input").prop("checked", "checked");
                    // $("label[for='selectAll']").parent().hide();
                    // $("label[for='unselectAll']").parent().show();
                }
                else if (data == 'إلغاء تحديد الكل'){
                    $(".multipleSelect > option").prop("selected", "");
                    $(".multipleSelect").trigger("change");
                    $(".custom-checkbox input").prop("checked", "");
                    $("label[for='unselectAll']").parent().hide();
                    $("label[for='selectAll']").parent().show();
                }
            });
        });


        function formatState(state) {

            if (!state.id) {
                return state.text;
            }
            var $state = $(
                `<label for="${state.id}" class="d-flex justify-content-between align-items-center m-0">
                  <div class="">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="${state.id}" />
                      <label class="custom-control-label m-0" for="${state.id}">${state.text}</label>
                    </div>
                   </div>

                    <div class="tooltip-container">
                        <i class="mdi mdi-clipboard-list"></i>
                        <div class="tooltip-content">
                            <ul>
                                <li class="tooltipRole">المجموعة الاولي</li>
                                <li class="tooltipRole">المجموعة الثانية</li>
                            </ul>
                        </div>
                    </div>

                   </label>`
            );
            return $state;


            //    <i class="mdi mdi-clipboard-list"  data-bs-toggle="popoverRoles" tabindex="1"
            //                         data-bs-placement="right" data-bs-html="true"
            //                         title="<span class='tooltipRole'> hesham</span>"></i>


            //             <span  title="tooltip text goes here"><i class="mdi mdi-clipboard-list"  data-bs-toggle="popoverRoles" tabindex="1"
            //              data-bs-placement="right" data-bs-html="true"></i>
            //             </span>


        };
    </script>
@endsection
