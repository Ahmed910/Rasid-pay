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
                    ignoreReadonly: true,
                }).on('dp.change', function() {
                    table.draw();
                });

            var table = $("#transactionsTable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('dashboard.transaction.index') }}",
                    data: function(data) {
                        data.transaction_number = $('#transactionNum').val();
                        data.citizen = $('#transactionName').val();
                        data.user_identity = $('#idNumber').val();
                        data.client = $('#to_user_id').val();
                        data.created_from = $('#from-hijri-picker-custom').val();
                        data.created_to = $('#to-hijri-picker-custom').val();
                        data.transaction_value_from = $('#transactionValueFrom').val();
                        data.transaction_value_to = $('#transactionValueTo').val();
                        data.type = $('#type').val();
                        data.enabled_card = $('#enabled_card').val();
                        data.status = $('#status').val();
                    },
                    type: "GET",
                    dataSrc: 'data'
                },
                columns: [{
                        data: function(data, type, full, meta) {
                            return parseInt(meta.row) + parseInt(data.start_from) + 1;
                        },
                        name: 'id',
                        class: 'transaction_index'
                    },
                    {
                        data: "number",
                        name: 'number'
                    },
                    {
                        data: "created_at",
                        name: 'created_at'
                    },
                    {
                        data: 'user_from',
                        name: 'user_from'
                    },

                    {
                        data: "user_identity",
                        name: 'user_identity'
                    },

                    {
                        data: 'user_to',
                        name: 'user_to'
                    },

                    {
                        data: 'amount',
                        name: 'amount'
                    },

                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },

                    {
                        data: 'gift_balance',
                        name: 'gift_balance'
                    },

                    {
                        data: 'type',
                        name: 'type'
                    },

                    {
                        data: function(data) {
                            if (data.status ===
                                "{{ trans('dashboard.transaction.status_cases.success') }}") {
                                return ` <span class="badge bg-success-opacity py-2 px-4">${data.status}</span>`;
                            } else if (data.status ===
                                "{{ trans('dashboard.transaction.status_cases.fail') }}") {
                                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.status}</span>`;
                            } else if (data.status ===
                                "{{ trans('dashboard.transaction.status_cases.pending') }}") {
                                return ` <span class="badge bg-warning-opacity py-2 px-4">${data.status}</span>`;
                            } else if (data.status ===
                                "{{ trans('dashboard.transaction.status_cases.received') }}") {
                                return ` <span class="badge bg-primary-opacity py-2 px-4">${data.status}</span>`;
                            } else {
                                return ` <span class="badge bg-default-opacity py-2 px-4">${data.status}</span>`;
                            }
                        },
                        name: 'status'
                    },

                    {
                        // data: 'discount_percent',
                        // name: 'discount_percent'

                        data: 'enabled_card',
                        name: 'enabled_card'

                    },
                ],

                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 15, 20],
                    [1, 5, 10, 15, 20]
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
                    var transactionTableSorting = document.getElementsByClassName('transaction_index');
                    for (var i = 0; i < transactionTableSorting.length; i++) {
                        transactionTableSorting[i].innerText = transactionTableSorting[i].innerText
                            .replace(
                                transactionTableSorting[i].innerText, transactionTableSorting[i]
                                .innerText
                                .toArabicUni());
                    }
                    //pagination
                    var transactionTablePagination = document.getElementsByClassName('page-link');
                    for (var i = 1; i < transactionTablePagination.length - 1; i++) {
                        transactionTablePagination[i].innerText = transactionTablePagination[i]
                            .innerText.replace(
                                transactionTablePagination[i].innerText, transactionTablePagination[i]
                                .innerText
                                .toArabicUni());
                    }
                    // info
                    var transactionTableInfo = document.getElementById('transactionsTable_info')
                        .innerText;
                    document.getElementById('transactionsTable_info').innerText = transactionTableInfo
                        .replace(
                            transactionTableInfo, transactionTableInfo.toArabicUni());
                }
            });


            $('#to_user_id').on('select2:select', function(e) {
                table.draw();
            });
            $('#status').on('select2:select', function(e) {
                table.draw();
            });
            $('#type').on('select2:select', function(e) {
                table.draw();
            });
            $('#enabled_card').on('select2:select', function(e) {
                table.draw();
            });

            $("#transactionNum").keyup(function() {
                table.draw();
            });
            $("#transactionName").keyup(function() {
                table.draw();
            });
            $("#idNumber").keyup(function() {
                table.draw();
            });
            $("#transactionValueFrom").keyup(function() {
                table.draw();
            });
            $("#transactionValueTo").keyup(function() {
                table.draw();
            });

            $('#search-form').on('reset', function(e) {
                e.preventDefault();
                $('#status').val(null).trigger('change');
                $('#card_package_id').val(null).trigger('change');
                $('#type').val(null).trigger('change');
                $('#transactionNum').val(null);
                $('#transactionName').val(null);
                $('#idNumber').val(null);
                $('#from_user_id').val(null);
                $('#to_user_id').val(null);
                $('#transactionValueFrom').val(null);
                $('#transactionValueTo').val(null);
                $('#from-hijri-picker-custom').val("").trigger('change');
                $('#to-hijri-picker-custom').val("").trigger('change');
                $('#from-hijri-unactive-picker-custom').val("").trigger('change');
                $('#to-hijri-unactive-picker-custom').val("").trigger('change');
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
