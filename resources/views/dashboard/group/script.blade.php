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
        $("#ajaxTable").DataTable({
            ajax: {
                url: "{{ route('dashboard.group.index') }}?" + $.param(@json(request()->query())),
                type: "GET",
                dataSrc: 'data'
            },
            sDom: "t<'domOption'lpi>",
            serverSide: true,
            processing: true,
            columns: [
                {
                    data: function(data, type, full, meta) {
                        return meta.row + 1;
                    },
                    name: 'id'
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
                        if (data.show_route){
                            actions += `<a href="${data.show_route}" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ trans('dashboard.general.show') }}"
                                            ><i class="mdi mdi-eye-outline"></i>
                                            </a>`;
                        }
                        if (data.edit_route){
                            actions += `<a href="${data.edit_route}"
                                    class="warningIcon"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ trans('dashboard.general.edit') }}"
                                    ><i class="mdi mdi-square-edit-outline"></i>
                                </a>`;
                            }
                        return actions;
                    }
                }
            ],
            pageLength: 10,
            lengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, "{{ trans('dashboard.general.all') }}"],
            ],

            language: {
                lengthMenu : "{{ trans('dashboard.datatable.show')}} _MENU_",
                emptyTable : "{{ trans('dashboard.datatable.no_data') }}",
                info : "{{ trans('dashboard.datatable.showing') }}_START_ {{ trans('dashboard.datatable.to') }}_END_ {{ trans('dashboard.datatable.from') }}_TOTAL_ {{ trans('dashboard.datatable.entries') }}",
                infoEmpty : "{{ trans('dashboard.datatable.no_search_result') }}",
                paginate : {
                    next : '<i class="mdi mdi-chevron-left"></i>',
                    previous : '<i class="mdi mdi-chevron-right"></i>'
                },
            },
            createdRow: function(row, data) {
                let span = ``;
                $(`[data-bs-toggle="popoverRoles"]`,row).popover({
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
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
    });


</script>
{{-- End Ajax DataTable --}}
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
