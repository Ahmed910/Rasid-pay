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
              if (data.type == 'created') {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.create')"}</span>`;
              }
              if (data.type == 'updated') {
                return `<span class="badge bg-warning-opacity py-2 px-4">${"@lang('dashboard.general.edit')"}</span>`;
              }
              if (data.type == 'destroy') {
                return `<span class="badge bg-primary-opacity py-2 px-4">${"@lang('dashboard.general.archive')"}</span>`;
              }
              if (data.type == 'restored') {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.restore')"}</span>`;
              }
              if (data.type == 'permanent_delete') {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.force_delete')"}</span>`;
              }
              if (data.type == 'searched') {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.search')"}</span>`;
              }
              if (data.type == 'deactivated') {
                return `<span class="badge bg-default-opacity py-2 px-4">${"@lang('dashboard.general.unactivited')"}</span>`;
              }
              if (data.type == 'activated') {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.activited')"}</span>`;
              }


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
          "lengthMenu": "@lang('dashboard.general.show') _MENU_",
          "emptyTable": "@lang('dashboard.datatable.no_data')",
          "info": "@lang('dashboard.datatable.showing') _START_ @lang('dashboard.datatable.to') _END_ @lang('dashboard.datatable.from') _TOTAL_ @lang('dashboard.datatable.entries')",
          "infoEmpty": "",
          "paginate": {
            "next": '<i class="mdi mdi-chevron-left"></i>',
            "previous": '<i class="mdi mdi-chevron-right"></i>'
          },
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
