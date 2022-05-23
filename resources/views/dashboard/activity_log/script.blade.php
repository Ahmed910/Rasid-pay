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
        });
    })
    $(document).ready(function () {
      var table = $("#activitylogtable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.activity_log.index') }}?" + $.param(
            @json(request()->query()))
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
            name: "subprogram"


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
              @include('dashboard.layouts.globals.activity_log_actions')
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
          @include('dashboard.layouts.globals.datatable_translation')
        },
        "drawCallback": function (settings, json) {
          // table sorting
          var activityLogTableSorting = document.getElementsByClassName('activity_log_index');
          for (var i = 0; i < activityLogTableSorting.length; i++) {
            activityLogTableSorting[i].innerText = activityLogTableSorting[i].innerText.replace(activityLogTableSorting[i].innerText, activityLogTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var activityLogTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < activityLogTablePagination.length - 1; i++) {
            activityLogTablePagination[i].innerText = activityLogTablePagination[i].innerText.replace(activityLogTablePagination[i].innerText, activityLogTablePagination[i].innerText.toArabicUni());
          }
          // info
          var activityLogTableInfo = document.getElementById('activitylogtable_info').innerText;
          document.getElementById('activitylogtable_info').innerText = activityLogTableInfo.replace(activityLogTableInfo, activityLogTableInfo.toArabicUni());
        }

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
      });
      $("#mainDepartment").on('select2:select', function (e) {
        table.draw();

      });
      $('#mainProgram').on('select2:select', function (e) {
        table.draw();
      });

      $('#branchProgram').on('select2:select', function (e) {
        table.draw();
      });
      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#activityName').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#mainProgram').val(null);
        $('#branchProgram').val(null);
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });
      //get subprogs from activity_logs script
      $("#mainProgram").change(function (e) {
        e.preventDefault();
        let mainprog_id = $("#mainProgram").val();
        $('#branchProgram').empty();
        $("#branchProgram").append('<option value=""> {{ trans('dashboard.activity_log.select_subprogram') }} </option>')
        if (mainprog_id != '') {


          //send ajax
          $.ajax({
            url: '{{ url('dashboard/activitylog/sub-programs') }}' + '/' + mainprog_id,
            type: 'get',
            success: function (data) {
              if (data) {
                $.each(data.data, function (index, subprogram) {
                  $("#branchProgram").append('<option value="' + subprogram.name +
                    '">' + subprogram.name + '</option>')
                });
              }
            }
          });
        }

      });
      //get employees from Department
      $("#mainDepartment").change(function (e) {
        e.preventDefault();
        let maindep_id = $("#mainDepartment").val();
        $('#employee').empty();
        $("#employee").append('<option value=""> {{ trans('dashboard.activity_log.select_employee') }} </option>')
        if (maindep_id != '') {


          //send ajax
          $.ajax({
            url: '/dashboard/activitylog/all-employees/' + maindep_id,
            type: 'get',
            success: function (data) {
              if (data) {
                $.each(data.data, function (index, user_id) {
                  $("#employee").append('<option value="' + user_id.id +
                    '">' + user_id.fullname + '</option>')
                });

              }
            }
          });
        }

      });

    })


  </script>

  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
