<!-- SELECT2 JS -->
@section('datatable_script')
    <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
    <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}">
    </script>

    <script>
        $(function() {


            /******* Calendar *******/
            $("#from-hijri-picker-custom, #to-hijri-picker-custom, #from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
                .hijriDatePicker({
                    hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                    showSwitcher: false,
                    format: "YYYY-MM-DD",
                    hijriFormat: "iYYYY-iMM-iDD",
                    hijriDayViewHeaderFormat: "iMMMM iYYYY",
                    dayViewHeaderFormat: "MMMM YYYY",
                    showClear: true,
                    ignoreReadonly: true,
                });

            $("#departmentTable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('dashboard.department.index') }}?" + $.param(
                        @json(request()->query())),
                    type: "GET",
                    dataSrc: 'data'
                },
                columns: [{
                        data: function(data, type, full, meta) {
                            return meta.row + 1;
                        },
                        name: 'id'
                    },
                    {
                        data: function(data) {
                            return `<div class="d-flex align-items-center"><div class="flex-shrink-0">
                              <img src="${data.image}" data-toggle="popoverIMG" title='<img src="${data.image}" width="300" height="300" class="d-block rounded-3" alt="">' width="25" class="avatar brround cover-image" alt="..."/> </div><div class="flex-grow-1 ms-3">${data.name}</div>`
                        }
                    },
                    {
                        data: function(data) {
                            return data.parent ? data.parent.name :
                                "{{ trans('dashboard.department.without_parent') }}";
                        },
                        name: 'parent'
                    },
                    {
                        data: "created_at",
                        name: 'created_at'
                    },
                    {
                        data: function(data) {
                            if (data.is_active) {
                                return ` <span class="badge bg-success-opacity py-2 px-4">${data.active_case}</span>`;
                            } else {
                                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.active_case}</span>`;
                            }
                        },
                        name: 'is_active'
                    },
                    {
                        class: "text-center",
                        data: function(data) {
                            fun_modal = data.has_jobs ? `notArchiveItem('@lang('dashboard.department.has_jobs_cannot_delete')')` :
                                `archiveItem('${data.id}', '${data.delete_route}')`;

                            return `<a
                    href="${data.show_route}"
                    class="azureIcon"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="@lang('dashboard.general.details')"
                    ><i class="mdi mdi-eye-outline"></i
                        ></a>
                        <a
                        href="${data.edit_route}"
                        class="warningIcon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="@lang('dashboard.general.edit')"
                        ><i class="mdi mdi-square-edit-outline"></i
                            ></a>
                            <a
                            href="#"
                            onclick="${fun_modal}"
                            class="primaryIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="@lang('dashboard.general.archive')"
                            ><i class="mdi mdi-archive-arrow-down-outline"></i></a>`
                        }
                    }
                ],
                createdRow: function(row, data) {
                    $('[data-toggle="popoverIMG"]', row).popover({
                        placement: "right",
                        trigger: "hover",
                        html: true,
                    });
                },
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "@lang('dashboard.general.all')"],
                ],

                "language": {
                    "lengthMenu": "@lang('dashboard.general.show') _MENU_",
                    "emptyTable": "@lang('dashboard.general.no_data')",
                    "info": "@lang('dashboard.general.showing') _START_ @lang('dashboard.general.to') _END_ @lang('dashboard.general.from') _TOTAL_ @lang('dashboard.general.entries')",
                    "infoEmpty": "@lang('dashboard.general.no_search_result')",
                    "paginate": {
                        "next": '<i class="mdi mdi-chevron-left"></i>',
                        "previous": '<i class="mdi mdi-chevron-right"></i>'
                    },
                }
            });
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
