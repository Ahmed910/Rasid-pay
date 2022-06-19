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
            $("#from-created-at, #to-created-at, #from-end-at ,#to-end-at")
                .hijriDatePicker({
                    hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                    showSwitcher: false,
                    format: "YYYY-MM-DD",
                    hijriFormat: "iYYYY-iMM-iDD",
                    hijriDayViewHeaderFormat: "iMMMM iYYYY",
                    dayViewHeaderFormat: "MMMM YYYY",
                    ignoreReadonly: true,
                    minDate: '1900-01-01',
                    maxDate: '2100-01-01',
                    showClear:true,
                    isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
                  }).on('dp.change', function() {
                      table.draw();
                });

            var table = $("#citizenTable").DataTable({
                responsive: true,
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('dashboard.citizen.index') }}",
                    data: function(data) {
                        insertUrlParam('sort[column]', data.columns[data.order[0].column].name);
                        insertUrlParam('sort[dir]',data.order[0].dir);
                        if ($('#enabledpackage').val()) data.enabled_package = $('#enabledpackage').val();
                        if ($('#citizenName').val()) data.fullname = $('#citizenName').val();
                        if ($('#idNumber').val()) data.identity_number = $('#idNumber').val();
                        if ($('#phone').val()) data.phone = $('#phone').val();
                        if ($('#from-created-at').val()) data.created_from = $('#from-created-at').val();
                        if ($('#to-created-at').val()) data.created_to = $('#to-created-at').val();
                        if ($('#from-end-at').val()) data.end_at_from = $('#from-end-at').val();
                        if ($('#to-end-at').val()) data.end_at_to = $('#to-end-at').val();
                    },
                    type: "GET",
                    dataSrc: 'data',
                },

                columns: [{
                        data: function(data, type, full, meta) {
                            return meta.row + 1;
                        },
                        name: 'id',
                        class: 'citizen_index',
                    },
                    {
                        data: "fullname",
                        name: 'fullname',
                    },
                    {
                        data: 'identity_number',
                        name: 'identity_number',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'enabled_package',
                        name: 'enabled_package',
                    },
                    {
                        data: 'card_end_at',
                        name: 'card_end_at',
                    },
                    {
                        data: "created_at",
                        name: 'created_at',
                    },
                    {
                        data: function(data) {
                            return `
                  <a href="#"
                     onclick=updatePhone('${data.id}','${data.update_route}','${'#citizenTable'}',${ data.phone_without_cc})
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
                    [-1, 1, 5, 10, 15, 20],
                    ["All",1, 5, 10, 15, 20]
                ],

                "language": {
                  @include('dashboard.layouts.globals.datatable.datatable_translation')
                },
                {{-- "drawCallback": function(settings, json) {
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
                } --}}
            });

 $("#reset").click(function (){
            showAll(table)
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
                $('#enabledpackage').val(null).trigger('change');
                table.column('').order('asc' ).search('').draw();
                if (location.href.includes('?')) {
                  history.pushState({}, null, location.href.split('?')[0]);
                }
            });

            $('#enabledpackage').on('select2:select', function(e) {
                insertUrlParam($(this).attr('id'), $(this).val());
                table.draw();
            });

            $("#idNumber,#citizenName,#phone").keyup(function() {
                insertUrlParam($(this).attr('id'), $(this).val());
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
