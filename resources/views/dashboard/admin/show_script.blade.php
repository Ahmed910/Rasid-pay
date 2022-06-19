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
        responsive: true,
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
              @include('dashboard.layouts.globals.datatable.activity_log_actions')
            }
          },
          // {
          //   data: "reason",
          // },

        ],
        pageLength: 10,
        lengthMenu: [
            [1, 5, 10, 15, 20],
           [1, 5, 10, 15, 20]
        ],
        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
      //   "drawCallback": function (settings, json) {
      //     // admin history table sorting
      //     var adminHistoryTableSorting = document.getElementsByClassName('admin_show_index');
      //     for (var i = 0; i < adminHistoryTableSorting.length; i++) {
      //       adminHistoryTableSorting[i].innerText = adminHistoryTableSorting[i].innerText.replace(adminHistoryTableSorting[i].innerText, adminHistoryTableSorting[i].innerText.toArabicUni());
      //     }

      //     //pagination
      //     var adminHistoryTablePagination = document.getElementsByClassName('page-link');
      //     for (var i = 1; i < adminHistoryTablePagination.length - 1; i++) {
      //       adminHistoryTablePagination[i].innerText = adminHistoryTablePagination[i].innerText.replace(adminHistoryTablePagination[i].innerText, adminHistoryTablePagination[i].innerText.toArabicUni());
      //     }

      //     // admin history table show info
      //     var adminHistoryTableInfo = document.getElementById('historyTableadmin_info').innerText;
      //     document.getElementById('historyTableadmin_info').innerText = adminHistoryTableInfo.replace(adminHistoryTableInfo, adminHistoryTableInfo.toArabicUni());
      //   }
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
