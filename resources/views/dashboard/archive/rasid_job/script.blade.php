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
                    ignoreReadonly: true,
                    isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
                }).on('dp.change', function() {
                    table.draw();
                });
            var table = $("#jobTable").DataTable({
        responsive: true,
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                ajax: {
                    url: "{{ route('dashboard.rasid_job.archive') }}",
                    data: function(data) {
                        data.name = $('#job_name').val();
                        data.created_from = $('#from-hijri-picker-custom').val();
                        data.created_to = $('#to-hijri-picker-custom').val();
                        data.is_active = $('#status').val();
                        data.department_id = $('#mainDepartment').val();
                    },
                    type: "GET",
                    dataSrc: 'data'
                },
                columns: [{
                        data: function(data, type, full, meta) {
                            return parseInt(meta.row) + parseInt(data.start_from) + 1;
                        },
                        name: 'id',
                        class: 'archive_job_index'
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: function(data) {
                            if (data.department_name !== null) {
                                // TODO::change imgae to default value
                                let image = 'default';
                                if (data.department_image != null) {
                                    image = data.department_image;
                                }
                                return `<div class="d-flex align-items-center"><div class="flex-shrink-0"> <img src="${image}" data-toggle="popoverIMG" title='<img src="${image}" width="300" height="300" class="d-block rounded-3" alt="">' width="25" class="avatar brround cover-image" alt="..." /> </div><div class="flex-grow-1 ms-3">${data.department_name}</div>`
                            } else {
                                return "@lang('dashboard.department.without_parent')";
                            }
                        },
                        name: "department"
                    },
                    {
                        data: "deleted_at",
                        name: "deleted_at"
                    },
                    {
                        data: function(data) {
                            if (data.is_active) {
                                return ` <span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.rasid_job.active_cases.1')"}</span>`;
                            } else {
                                return ` <span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.rasid_job.active_cases.0')"}</span>`;
                            }
                        },
                        name: "is_active"
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
                              onclick=unArchiveItem('${data.id}','${data.restore_route}','${'#jobTable'}')
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
                              onclick=ForceDeleteItem('${data.id}','${data.forceDelete_route}','${'#jobTable'}')
                              class="errorIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="حذف"
                              ><i
                                data-bs-toggle="modal"
                                class="mdi mdi-trash-can-outline"
                              ></i
                            ></a>
                              `
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data) {
                    $('[data-toggle="popoverIMG"]', row).popover({
                        placement: "left",
                        trigger: "hover",
                        html: true,
                    });
                    $('[data-toggle="popoverIMG"]', row).popover({
                        placement: "left",
                        trigger: "hover",
                        html: true,
                    });
                },
                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 15, 20],
                  ["١", "٥","١٠","١٥", "٢٠"]
                ],
                "language": {
                  @include('dashboard.layouts.globals.datatable.datatable_translation')
                },
                "drawCallback": function(settings, json) {
                    // table sorting
                    var jobTableSorting = document.getElementsByClassName('archive_job_index');
                    for (var i = 0; i < jobTableSorting.length; i++) {
                        jobTableSorting[i].innerText = jobTableSorting[i].innerText.replace(
                            jobTableSorting[i].innerText, jobTableSorting[i].innerText.toArabicUni()
                            );
                    }
                    //pagination
                    var jobTablePagination = document.getElementsByClassName('page-link');
                    for (var i = 1; i < jobTablePagination.length - 1; i++) {
                        jobTablePagination[i].innerText = jobTablePagination[i].innerText.replace(
                            jobTablePagination[i].innerText, jobTablePagination[i].innerText
                            .toArabicUni());
                    }
                    // info
                    var jobTableInfo = document.getElementById('jobTable_info').innerText;
                    document.getElementById('jobTable_info').innerText = jobTableInfo.replace(
                        jobTableInfo, jobTableInfo.toArabicUni());
                }
            });
            $('.select2').select2({
                minimumResultsForSearch: Infinity,
                createSearchChoice: function(term) {
                    if (term.match(/^[a-zA-Z0-9]+$/g))
                        return {
                            id: term,
                            text: term
                        };
                },
                formatNoMatches: "Enter valid format text"
            })


            $("#job_name").keyup(function() {
                insertUrlParam('name', $('#job_name').val());
                table.draw();
            });

            $('#mainDepartment').on('select2:select', function(e) {
                insertUrlParam('department_id', $('#mainDepartment').val());
                table.draw();
            });

            $('#status').on('select2:select', function(e) {
                insertUrlParam('is_active', $('#status').val());
                table.draw();
            });

            $('#search-form').on('reset', function(e) {
                e.preventDefault();
                $('#job_name').val(null);
                $('#mainDepartment').val(null).trigger('change');
                $('#status').val(null).trigger('change');
                $('#from-hijri-picker-custom').val("").trigger('change');
                $('#to-hijri-picker-custom').val("").trigger('change');
                table.draw();
            });
            $("#search-form").submit(function(e) {
                e.preventDefault();
                table.draw();
            });
            table.on('draw', function() {
                var tooltipTriggerList = [].slice.call(
                    document.querySelectorAll('[data-bs-toggle="tooltip"]')
                );
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });

        // $('#job_name').on('keypress', function(event) {
        //     var regex = new RegExp("^[a-zA-Z0-9]+$");
        //     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        //     if (!regex.test(key)) {
        //         event.preventDefault();
        //         return false;
        //     }
        // });
    </script>
    <!-- SELECT2 JS -->
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
