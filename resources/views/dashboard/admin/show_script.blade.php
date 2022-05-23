@section('datatable_script')
<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>
@endsection
@section('scripts')
<script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
{{-- Ajax DataTable --}}
<script>
  $(function () {

      $("#historyTableadmin").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.admin.show', $admin->id) }}?" + $.param(
            @json(request()->query())),
          dataSrc: 'data'
        },

        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'admin_show_index'
        },
          {
            data: "user.fullname"
          },
          {
            data: function (data) {
              if (data.user.department !== null) {
                return data.user.department.name;
              } else {
                return "@lang('dashboard.department.without_parent')";
              }
            }
          },

          {
            data: "created_at"
          },
          {
            data: function (data) {
              if (data.type == "{{App\Models\ActivityLog::CREATE}}") {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.create')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::UPDATE}}") {
                return `<span class="badge bg-warning-opacity py-2 px-4">${"@lang('dashboard.general.edit')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::DESTROY}}") {
                return `<span class="badge bg-primary-opacity py-2 px-4">${"@lang('dashboard.general.archive')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::RESTORE}}") {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.restore')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::PERMANENT}}") {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.force_delete')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::SEARCH}}") {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.search')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::DEACTIVE}}") {
                return `<span class="badge bg-default-opacity py-2 px-4">${"@lang('dashboard.general.unactivited')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::ACTIVE}}") {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.activited')"}</span>`;
              }
              if (data.type == "{{App\Models\ActivityLog::TEMPORARY}}") {
                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.temporary')"}</span>`;
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
          // admin history table sorting
          var adminHistoryTableSorting = document.getElementsByClassName('admin_show_index');
          for (var i = 0; i < adminHistoryTableSorting.length; i++) {
            adminHistoryTableSorting[i].innerText = adminHistoryTableSorting[i].innerText.replace(adminHistoryTableSorting[i].innerText, adminHistoryTableSorting[i].innerText.toArabicUni());
          }

          //pagination
          var adminHistoryTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < adminHistoryTablePagination.length - 1; i++) {
            adminHistoryTablePagination[i].innerText = adminHistoryTablePagination[i].innerText.replace(adminHistoryTablePagination[i].innerText, adminHistoryTablePagination[i].innerText.toArabicUni());
          }

          // admin history table show info
          var adminHistoryTableInfo = document.getElementById('historyTableadmin_info').innerText;
          document.getElementById('historyTableadmin_info').innerText = adminHistoryTableInfo.replace(adminHistoryTableInfo, adminHistoryTableInfo.toArabicUni());
        }
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });
    });
</script>
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js">
</script>
@endsection
