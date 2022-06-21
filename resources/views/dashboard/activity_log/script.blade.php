@section('datatable_script')
<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
<script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js">
</script>
{{-- Ajax DataTable --}}
<script>
  $(function () {
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
        });
    })
    $(document).ready(function () {
      var table = $("#activitylogtable").DataTable({
        responsive: true,
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.activity_log.index') }}?" + $.param(
            @json(request()->query())),
          data: function(data) {
                  insertUrlParam('sort[column]', data.columns[data.order[0].column].name);
                  insertUrlParam('sort[dir]',data.order[0].dir);
                  data.created_from = $('#from-hijri-picker-custom').val();
                  data.created_to = $('#to-hijri-picker-custom').val();
                  data.action = $('#activityName').val();
                  data.department_id = $('#mainDepartment').val();
                  data.main_program = $('#mainProgram').val();
                  data.sub_program = $('#branchProgram').val();
              },
          type: "GET",
          dataSrc: 'data'
        },
        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'activity_log_index'
        },
          {
            data: function (data) {
              return data.user ? data.user.fullname : "{{trans("dashboard.error.not_found")}}";
            },
            name: "employee"
          },

          {
            data: function (data) {
              if (data.user && data.user.department !== null) {
                return data.user.department.name;
              } else {
                return "{{ trans('dashboard.department.without_parent') }}";
              }
            },
            name: 'department'
          },

          {

            data: function (data) {
              return data.auditable_type ? data.auditable_type :
                " ";
            },
            name: "main_program"

          },
          {
            data: "type",
            name: "sub_program"
          },
          {
            data: "created_at",
            name: "created_at"

          },
          {
            data: "ip",
            name: "ip"
          },

          {
            data: function (data) {
              @include('dashboard.layouts.globals.datatable.activity_log_actions')
            },
            name: "type"
          },

          {
            "className": 'dt-control',
            "orderable": false,
            "data": '',
            "defaultContent": `<a
          class="azureIcon"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="${"@lang('dashboard.general.show')"}"
        ><i class="mdi mdi-eye-outline"></i
            ></a>`
          },
        ],
        createdRow: function (row, data) {
          $('[data-toggle="popoverIMG"]', row).popover({
            placement: "right",
            trigger: "hover",
            html: true,
          });
        },
        pageLength: 10,
        lengthMenu: [
          [1, 5, 10, 15, 20],
         [1, 5, 10, 15, 20]
        ],

        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },

      });
      var detailRows = [];

      $('#activitylogtable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
        } else {
          // Open this row
          row.child(format(row.data())).show();
          tr.addClass('shown');
        }
      });

      function format(d) {
        // `d` is the original data object for the row
        return '<table >' +
          '<tr>' +
          '<td>' + d.discription + '</td>' +
          '</tr>' +
          '</table>';
      }

      $('#activityName').on('select2:select', function (e) {
        table.draw();
        insertUrlParam('action', $('#activityName').val());
      });
      $("#mainDepartment").on('select2:select', function (e) {
        table.draw();
        insertUrlParam('department_id', $('#mainDepartment').val());

      });
      $('#mainProgram').on('select2:select', function (e) {
        table.draw();
        insertUrlParam('main_program', $('#mainProgram').val());
      });

      $('#branchProgram').on('select2:select', function (e) {
        table.draw();
        insertUrlParam('sub_program', $('#branchProgram').val());
      });

      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#activityName').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#mainProgram').val(null);
        $('#branchProgram').val(null);
        table.column('').order('asc' ).search('').draw();
        if (location.href.includes('?')) {
            history.pushState({}, null, location.href.split('?')[0]);
          }
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });
    })


</script>
@include('dashboard.activity_log.ajax_script')
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
