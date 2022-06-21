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
          minDate: '1900-01-01',
          maxDate: '2100-01-01',
          showClear:true,
          isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
        }).on('dp.change', function () {
        table.draw();
      });
      var table = $("#transactionsTable").DataTable({
        responsive: true,
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.transaction.index') }}",
          data: function(data) {
            insertUrlParam('sort[column]', data.columns[data.order[0].column].name);
            insertUrlParam('sort[dir]',data.order[0].dir);
            data.trans_number = $('#transactionNum').val();
            data.citizen = $('#transactionName').val();
            data.user_identity = $('#idNumber').val();
            data.client = $('#to_user_id').val();
            data.created_from = $('#from-hijri-picker-custom').val();
            data.created_to = $('#to-hijri-picker-custom').val();
            data.trans_type = $('#type').val();
            data.trans_status = $('#status').val();
            data.enabled_package = $('#enabled_package').val();
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
            data: "trans_number",
            name: 'trans_number'
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
            data: 'trans_type',
            name: 'trans_type'
          },

          {
            data: function(data) {
              if (data.trans_status ===
                "{{ trans('dashboard.transaction.status_cases.success') }}") {
                return ` <span class="badge bg-success-opacity py-2 px-4">${data.trans_status}</span>`;
              } else if (data.trans_status ===
                "{{ trans('dashboard.transaction.status_cases.fail') }}") {
                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.trans_status}</span>`;
              } else if (data.trans_status ===
                "{{ trans('dashboard.transaction.status_cases.pending') }}") {
                return ` <span class="badge bg-warning-opacity py-2 px-4">${data.trans_status}</span>`;
              } else if (data.trans_status ===
                "{{ trans('dashboard.transaction.status_cases.received') }}") {
                return ` <span class="badge bg-primary-opacity py-2 px-4">${data.trans_status}</span>`;
              } else {
                return ` <span class="badge bg-default-opacity py-2 px-4">${data.trans_status}</span>`;
              }
            },
            name: 'trans_status'
          },

          {
            data: 'enabled_package',
            name: 'enabled_package'
          },

          {
            class: "text-center",
            data: function (data) {
              return `<a
                    href="${data.show_route}"
                    class="azureIcon"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="@lang('dashboard.general.show')"
                    ><i class="mdi mdi-eye-outline"></i
                        ></a>`;
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


      $('#to_user_id').on('select2:select', function(e) {
        insertUrlParam('client', $('#to_user_id').val());
        table.draw();
      });
      $('#status').on('select2:select', function(e) {
        insertUrlParam('trans_status', $('#status').val());
        table.draw();
      });
      $('#status').on('select2:unselect', function(e) {
        insertUrlParam('trans_status', $('#status').val(),true);
        table.draw();
      });
      $('#type').on('select2:select', function(e) {
        insertUrlParam('trans_type', $('#type').val());
        table.draw();
      });
      $('#enabled_package').on('select2:select', function(e) {
        insertUrlParam('enabled_package', $('#enabled_package').val());
        table.draw();
      });
      $('#enabled_package').on('select2:unselect', function(e) {
        insertUrlParam('enabled_package', $('#enabled_package').val(),true);
        table.draw();
      });

      $("#transactionNum").keyup(function() {
        insertUrlParam('trans_number', $('#transactionNum').val());
        table.draw();
      });
      $("#transactionName").keyup(function() {
        insertUrlParam('citizen', $('#transactionName').val());
        table.draw();
      });

      $('#search-form').on('reset', function(e) {
        e.preventDefault();
        $('#status').val(null).trigger('change');
        $('#enabled_package').val(null).trigger('change');
        $('#type').val(null).trigger('change');
        $('#transactionNum').val(null);
        $('#transactionName').val(null);
        $('#idNumber').val(null);
        $('#from_user_id').val(null);
        $('#to_user_id').val(null);
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        $('#from-hijri-unactive-picker-custom').val("").trigger('change');
        $('#to-hijri-unactive-picker-custom').val("").trigger('change');
        table.column('').order('asc' ).search('').draw();
        if (location.href.includes('?')) {
          history.pushState({}, null, location.href.split('?')[0]);
        }
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
