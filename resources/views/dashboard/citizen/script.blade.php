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
                     onclick=setCitizenPhoneModal('${data.phone}','${data.update_route}')
                     class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                     title="@lang('dashboard.general.edit')"><i class="mdi mdi-square-edit-outline"></i></a>`
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
                }
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

        function setCitizenPhoneModal(phone, route) {
            $('#update-phone').attr('action',route);
            $('#update-phone').find('input[name=phone]').val(phone);
            $('#modal_phone').modal('show');
        }
        $('#update-phone').on('submit',function (e) {
            e.preventDefault();
            var btn_submit = $('#btn-submit');
            $.ajax({
                url: $('#update-phone').attr('action'),
                type: 'POST',
                beforeSend: function () {
                    btn_submit.html(`<span class="spinner-border text-light" style="width: 1rem; height: 1rem;" role="status"></span>`);
                },
                data: $(this).serialize(),
                success: function(data) {
                    btn_submit.html('{{ trans('dashboard.general.save') }}');
                    toast('success',data.message ,"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}");
                    $('#citizenTable').DataTable().ajax.reload();
                    $('#modal_phone').modal('hide');
                },
                error: function (data) {
                    btn_submit.html('{{ trans('dashboard.general.save') }}');
                    $.each(data.responseJSON.errors, function(input, errors) {
                        $('input[name="' + input + '"]').addClass('border-danger');
                        $.each(errors, function(name, message) {
                            $('#' + input + '_error').append(`<small class='text-danger'>${message}</small><br/>`);
                        });
                    });
                }
            });
        });

       var disappearError = function() {
            $('#phone_error').html('');
            $('input[name="phone"]').removeClass('border-danger');
       }

        $("#modal_phone").on("hidden.bs.modal", disappearError);
        $('#phone_value').focus(disappearError);

</script>
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
