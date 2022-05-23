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
            $("#orderTable").DataTable({
                sDom: "t<'domOption'lpi>",
                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 20, -1],
                    [1, 5, 10, 20, "الكل"],
                ],

                language: {
                    lengthMenu: "عرض _MENU_",
                    zeroRecords: "لا يوجد بيانات",
                    info: "عرض _PAGE_ من _PAGES_ عنصر",
                    infoEmpty: "لا يوجد نتائج بحث متاحة",
                    paginate: {
                        previous: '<i class="mdi mdi-chevron-right"></i>',
                        next: '<i class="mdi mdi-chevron-left"></i>',
                    },
                },
            });

            /******* Calendar *******/
            $("#from-created-at, #to-created-at, #from-end-at ,#to-end-at")
                .hijriDatePicker({
                    hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                    showSwitcher: false,
                    format: "YYYY-MM-DD",
                    hijriFormat: "iYYYY-iMM-iDD",
                    hijriDayViewHeaderFormat: "iMMMM iYYYY",
                    dayViewHeaderFormat: "MMMM YYYY",
                    ignoreReadonly: true,
                }).on('dp.change', function() {
                    table.draw();
                });

            $("#citizen-search").submit(function(e) {
                e.preventDefault();
                table.draw();
            });

            $("#citizen-search").on('reset', function(e) {
                e.preventDefault();
                $('#from-created-at').val("").trigger('change');
                $('#to-created-at').val("").trigger('change');
                $('#from-end-at').val("").trigger('change');
                $('#to-end-at').val("").trigger('change');
                $('#citizenName,#idNumber,#phone').val(null);
                $('#enabledcard').val(null).trigger('change');
                table.draw();
            });

            var table = $("#citizenTable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('dashboard.citizen.index') }}",
                    data: function(data) {
                        if ($('#enabledcard').val() !== '' && $('#enabledcard').val() !== null) data
                            .enabled_card = $('#enabledcard').val();
                        if ($('#citizenName').val() !== '' && $('#citizenName').val() !== null) data
                            .fullname = $('#citizenName').val();
                        if ($('#idNumber').val() !== '' && $('#idNumber').val() !== null) data
                            .identity_number = $('#idNumber').val();
                        if ($('#phone').val() !== '' && $('#phone').val() !== null) data.phone = $(
                            '#phone').val();
                        if ($('#from-created-at').val() !== '' && $('#from-created-at').val() !== null)
                            data.created_from = $('#from-created-at').val();
                        if ($('#to-created-at').val() !== '' && $('#to-created-at').val() !== null) data
                            .created_to = $('#to-created-at').val();
                        if ($('#from-end-at').val() !== '' && $('#from-end-at').val() !== null) data
                            .end_at_from = $('#from-end-at').val();
                        if ($('#to-end-at').val() !== '' && $('#to-end-at').val() !== null) data
                            .end_at_to = $('#to-end-at').val();
                    },
                    type: "GET",
                    dataSrc: 'data',
                },

                columns: [{
                        data: function(data, type, full, meta) {
                            return meta.row + 1;
                        },
                        name: 'id',
                        class: 'citizen_index'
                    },
                    {
                        data: "fullname",
                        name: 'fullname'
                    },
                    {
                        data: 'identity_number',
                        name: 'identity_number'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'enabled_card',
                        name: 'enabled_card'
                    },
                    {
                        data: 'card_end_at',
                        name: 'card_end_at'
                    },
                    {
                        data: "created_at",
                        name: 'created_at'
                    },
                    {
                        class: "text-center",
                        data: function(data) {
                            return `
                  <a href="#"
                     onclick=updatePhone('${data.id}','${data.update_route}','${'#citizenTable'}')
                     class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                     title="@lang('dashboard.general.edit')"><i class="mdi mdi-square-edit-outline" data-bs-toggle="modal"
                     data-bs-target="#modal_phone"></i></a>`
                        },
                        orderable: false,
                        searchable: false
                    }
                ],

                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 15, 20],
                    [1, 5, 10, 15, 20]
                ],

                "language": {
                  @include('dashboard.layouts.globals.datatable.datatable_translation')
                },
                "drawCallback": function(settings, json) {
                    // table sorting
                    var citizenTableSorting = document.getElementsByClassName('citizen_index');
                    for (var i = 0; i < citizenTableSorting.length; i++) {
                        citizenTableSorting[i].innerText = citizenTableSorting[i].innerText.replace(
                            citizenTableSorting[i].innerText, citizenTableSorting[i].innerText
                            .toArabicUni());
                    }
                    //pagination
                    var citizenTablePagination = document.getElementsByClassName('page-link');
                    for (var i = 1; i < citizenTablePagination.length - 1; i++) {
                        citizenTablePagination[i].innerText = citizenTablePagination[i].innerText
                            .replace(
                                citizenTablePagination[i].innerText, citizenTablePagination[i].innerText
                                .toArabicUni());
                    }
                    // info
                    var citizenTableInfo = document.getElementById('citizenTable_info').innerText;
                    document.getElementById('citizenTable_info').innerText = citizenTableInfo.replace(
                        citizenTableInfo, citizenTableInfo.toArabicUni());
                }
            });


            $('#enabledcard').on('select2:select', function(e) {
                table.draw();
            });

            $("#idNumber,#citizenName,#phone,#idNumber").keyup(function() {
                table.draw();
            });


            $('#citizen-search').on('reset', function(e) {
                e.preventDefault();
                $('#phone,#citizenName').val(null);
                $('#from-created-at').val("").trigger('change');
                $('#to-created-at').val("").trigger('change');
                $('#from-end-at').val("").trigger('change');
                $('#to-end-at').val("").trigger('change');
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
    </script>
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
