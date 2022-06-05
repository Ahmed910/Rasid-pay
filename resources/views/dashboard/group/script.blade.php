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
    {{-- Ajax DataTable --}}
    <script>
        $(function() {
            var table = $("#ajaxTable").DataTable({
        responsive: true,
                ajax: {
                    url: "{{ route('dashboard.group.index') }}?",
                    data: function(data) {
                        data.is_active = $('#status').val();
                        data.name = $('#name').val();
                        data.admins_from = $('#userNumFrom').val();
                        data.admins_to = $('#userNumTo').val();
                    },
                    type: "GET",
                    dataSrc: 'data'
                },
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                processing: true,
                columns: [{
                        data: function(data, type, full, meta) {
                            return meta.row + 1;
                        },
                        name: 'id',
                        class: 'group_index'
                    },
                    {
                        data: function(data) {
                            return `${data.name} <i
                          class="mdi mdi-clipboard-list"
                          tabindex="1"
                              data-bs-toggle="popoverRoles"
                        ></i>`;
                        },
                        name: 'name'
                    },
                    {
                        data: "admins_count",
                        name: 'admins_count'
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
                        data: "created_at",
                        name: 'created_at'
                    },
                    {
                        class: "text-center",
                        data: function(data) {
                            let actions = ``;
                            if (data.show_route) {
                                actions += `<a href="${data.show_route}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ trans('dashboard.general.show') }}"
                                            ><i class="mdi mdi-eye-outline"></i>
                                            </a>`;
                            }
                            if (data.edit_route) {
                                actions += `<a href="${data.edit_route}"
                                    class="warningIcon"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ trans('dashboard.general.edit') }}"
                                    ><i class="mdi mdi-square-edit-outline"></i>
                                </a>`;
                            }
                            return actions;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
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
                    var groupTableSorting = document.getElementsByClassName('group_index');
                    for (var i = 0; i < groupTableSorting.length; i++) {
                        groupTableSorting[i].innerText = groupTableSorting[i].innerText.replace(
                            groupTableSorting[i].innerText, groupTableSorting[i].innerText
                            .toArabicUni());
                    }
                    //pagination
                    var groupTablePagination = document.getElementsByClassName('page-link');
                    for (var i = 1; i < groupTablePagination.length - 1; i++) {
                        groupTablePagination[i].innerText = groupTablePagination[i].innerText.replace(
                            groupTablePagination[i].innerText, groupTablePagination[i].innerText
                            .toArabicUni());
                    }
                    // info
                    var groupTableInfo = document.getElementById('ajaxTable_info').innerText;
                    document.getElementById('ajaxTable_info').innerText = groupTableInfo.replace(
                        groupTableInfo, groupTableInfo.toArabicUni());
                },
                createdRow: function(row, data) {
                    let span = ``;
                    $(`[data-bs-toggle="popoverRoles"]`, row).popover({
                        placement: "left",
                        trigger: "focus",
                        html: true,
                        content: `
                    ${(() => {
                        $.each( data.permissions, function( key, value) {
                        span +=`<span class='tooltipRole'>${value.name}</span>`
                        });
                        return span;
                    })()}`
                    });
                },
            });


            $('#status').on('select2:select', function(e) {
                table.draw();
            });

            $("#name").keyup(function() {
                table.draw();
            });
            $("#userNumFrom").keyup(function() {
                table.draw();
            });
            $("#userNumTo").keyup(function() {
                table.draw();
            });

            $('#search-form').on('reset', function(e) {
                e.preventDefault();
                $('#status').val(null).trigger('change');
                $('#name').val(null);
                $('#userNumFrom').val(null);
                $('#userNumTo').val(null);

                table.draw();
            });

            $("#search-form").submit(function(e) {
                e.preventDefault();
                table.draw();
            });

            $('.select2').select2({
                minimumResultsForSearch: Infinity
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

        function checkNumberFieldLength(elem) {
            if (elem.value.length > 4) {
                elem.value = elem.value.slice(0, 4);
            }
        }
    </script>
    {{-- End Ajax DataTable --}}
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
