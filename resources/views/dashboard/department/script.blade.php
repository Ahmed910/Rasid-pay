<!-- SELECT2 JS -->
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/moment/moment@develop/min/moment-with-locales.min.js"></script>
<!-- DATE PICKER JS -->
<script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}">
</script>
<script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>

<script>
    $(function() {
        /******* Calendar *******/
        $("#from-hijri-picker, #to-hijri-picker, #from-hijri-unactive-picker ,#to-hijri-unactive-picker")
            .hijriDatePicker({
                hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                showSwitcher: false,
                format: "DD-MM-YYYY",
                hijriFormat:'iYYYY-iMMMM-iDD',
                hijriDayViewHeaderFormat:'iDD iMMMM iYYYY',
                showClear: true,
                ignoreReadonly: true,
                locale: 'ar-SA'
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
                    data: "name",
                    name: 'name'
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
                            return ` <span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.active')"}</span>`;
                        } else {
                            return ` <span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.general.inactive')"}</span>`;
                        }
                    },
                    name: 'is_active'
                },
                {
                    class: "text-center",
                    data: function(data) {
                        fun_modal = (data.has_jobs) ?
                            `archiveItem('${data.id}', '${data.delete_route}')` :
                            `notArchiveItem()`;

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
            pageLength: 10,
            lengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, "@lang('dashboard.general.all')"],
            ],
            "language": {
                "lengthMenu": "@lang('dashboard.datatable.show') _MENU_",
                "zeroRecords": "@lang('dashboard.general.no_data')",
                "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "infoEmpty": "@lang('dashboard.general.there_is_no_data')",
                "paginate": {
                    "previous": '<i class="mdi mdi-chevron-right"></i>',
                    "next": '<i class="mdi mdi-chevron-left"></i>',
                },
            }
        });
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
