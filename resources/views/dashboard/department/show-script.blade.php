@section('datatable_script')
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
  <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
  <script>
    $(function () {

      $("#historyTable").DataTable({
        responsive: true,
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.department.show', $department->id) }}?" + $.param(
            @json(request()->query())),
          dataSrc: 'data'
        },

        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class:'department_show_index'
        },
          {
            data: "user.fullname"
          },
          {
            data: function (data) {
              if (data.user.department !== null) {
                return data.user.department.name;
              } else {
                return "@lang('dashboard.department.without')";
              }
            }
          },

          {
            data: "created_at"
          },
          {
            data: function (data) {
              @include('dashboard.layouts.globals.datatable.activity_log_actions')
            }
          },
          {
            data: "reason",
          },


        ],
        pageLength: 10,
        lengthMenu: [
            [1, 5, 10, 15, 20],
            [1, 5, 10, 15, 20]
        ],
        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
        "drawCallback": function (settings, json) {
          // department history table sorting
          var departmentHistoryTableSorting = document.getElementsByClassName('department_show_index');
          for (var i = 0; i < departmentHistoryTableSorting.length; i++) {
            departmentHistoryTableSorting[i].innerText = departmentHistoryTableSorting[i].innerText.replace(departmentHistoryTableSorting[i].innerText, departmentHistoryTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var departmentHistoryTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < departmentHistoryTablePagination.length - 1; i++) {
            departmentHistoryTablePagination[i].innerText = departmentHistoryTablePagination[i].innerText.replace(departmentHistoryTablePagination[i].innerText, departmentHistoryTablePagination[i].innerText.toArabicUni());
          }
          // department history table show info
          var departmentHistoryTableInfo = document.getElementById('historyTable_info').innerText;
          document.getElementById('historyTable_info').innerText = departmentHistoryTableInfo.replace(departmentHistoryTableInfo, departmentHistoryTableInfo.toArabicUni());
        }
      });
    });

    $('.select2').select2({
      minimumResultsForSearch: Infinity
    });
  </script>
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
