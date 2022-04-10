<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>

<script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>


<!-- DATE PICKER JS -->
<script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}">
</script>

<script>
    $(function() {
        /******* Calendar *******/
        $("#from-hijri-picker, #to-hijri-picker, #from-hijri-unactive-picker ,#to-hijri-unactive-picker")
            .hijriDatePicker({
                hijri: true,
                showSwitcher: false,
            });

        $("#departmentTable").DataTable({
            sDom: "t<'domOption'lpi>",
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.department.archive') }}?" + $.param(
                    @json(request()->query())),
                dataSrc: 'data'
            },
            columns: [{
                    data: function(data, type, full, meta) {
                        return parseInt(meta.row) + parseInt(data.start_from) + 1;
                    },
                    name: 'id'
                },
                {
                    data: "name"
                },
                {
                    data: function(data) {
                        if (data.parent !== null) {
                            return data.parent.name;
                        } else {
                            return "@lang('dashboard.department.without_parent')";
                        }
                    }
                },
                {
                    data: "deleted_at"
                }, {
                    data: function(data) {
                        if (data.is_active) {
                            return ` <span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.active')"}</span>`;
                        } else {
                            return ` <span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.general.inactive')"}</span>`;
                        }
                    }
                },
                {
                    class: "text-center",
                    data: function(data) {
                        tagInfo = (data.has_jobs) ?
                            `<i data-bs-toggle="modal" data-bs-target="#DeleteModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>` :
                            `<i data-bs-toggle="modal" data-bs-target="#unarchiveModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>`;

                        return `<a
                                href="${data.show_route}"
                                class="azureIcon"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="@lang('dashboard.general.show')"
                                ><i class="mdi mdi-eye-outline"></i
                              ></a>
                              <a
                              href="#"
                              onclick=unArchiveItem('${data.id}','${data.restore_route}','${'#departmentTable'}')
                              class="successIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="استعادة"
                              ><i
                                data-bs-toggle="modal"
                                class="mdi mdi-backup-restore"
                              ></i
                            ></a>
                            <a
                              href="#"
                              onclick=ForceDeleteItem('${data.id}','${data.forceDelete_route}','${'#departmentTable'}')
                              class="errorIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="حذف"
                              ><i
                                data-bs-toggle="modal"
                                class="mdi mdi-trash-can-outline"
                              ></i
                            >
                            </a>`

                    },
                    orderable: false,
                    searchable: false
                }
            ],
            pageLength: 10,
            lengthMenu: [
                [1, 5, 10, 20, -1],
                [1, 5, 10, 20, "الكل"],
            ],
            "language": {
                "lengthMenu": "@lang('dashboard.general.show') _MENU_",
                "emptyTable": "@lang('dashboard.datatable.no_data')",
                "info": "@lang('dashboard.datatable.showing') _START_ @lang('dashboard.datatable.to') _END_ @lang('dashboard.datatable.from') _TOTAL_ @lang('dashboard.datatable.entries')",
                "infoEmpty": "",
                "paginate": {
                    "next": '<i class="mdi mdi-chevron-left"></i>',
                    "previous": '<i class="mdi mdi-chevron-right"></i>'
                },
            },
            "drawCallback": function(settings, json) {
                // table sorting
                var departmentTableSorting = document.getElementsByClassName('sorting_1');
                for (var i = 0; i < departmentTableSorting.length; i++) {
                    departmentTableSorting[i].innerText = departmentTableSorting[i].innerText
                        .replace(departmentTableSorting[i].innerText, departmentTableSorting[i]
                            .innerText.toArabicUni());
                }
                //pagination
                var departmentTablePagination = document.getElementsByClassName('page-link');
                for (var i = 1; i < departmentTablePagination.length - 1; i++) {
                    departmentTablePagination[i].innerText = departmentTablePagination[i].innerText
                        .replace(departmentTablePagination[i].innerText, departmentTablePagination[
                            i].innerText.toArabicUni());
                }
                // info
                var departmentTableInfo = document.getElementById('departmentTable_info').innerText;
                document.getElementById('departmentTable_info').innerText = departmentTableInfo
                    .replace(departmentTableInfo, departmentTableInfo.toArabicUni());
            }
        });
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
