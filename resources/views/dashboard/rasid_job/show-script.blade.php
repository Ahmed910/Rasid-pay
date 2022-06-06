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
          url: "{{ route('dashboard.rasid_job.show', $rasidJob->id) }}?" + $.param(
            @json(request()->query())),
          dataSrc: 'data'
        },

        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'rasid_job_show_index'
        },
          {
            data: "user.fullname"
          },
          {
            data: function (data) {
              return data.user.department ? data.user.department.name :
                "{{ trans('dashboard.department.without_parent') }}";
            },
            name: 'department'
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
          ["١", "٥","١٠","١٥", "٢٠"]
        ],
        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
        "drawCallback": function (settings, json) {
          var jobHistoryTableSorting = document.getElementsByClassName('rasid_job_show_index');
          for (var i = 0; i < jobHistoryTableSorting.length; i++) {
            jobHistoryTableSorting[i].innerText = jobHistoryTableSorting[i].innerText.replace(jobHistoryTableSorting[i].innerText, jobHistoryTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var jobHistoryTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < jobHistoryTablePagination.length - 1; i++) {
            jobHistoryTablePagination[i].innerText = jobHistoryTablePagination[i].innerText.replace(jobHistoryTablePagination[i].innerText, jobHistoryTablePagination[i].innerText.toArabicUni());
          }
          var jobHistoryTableInfo = document.getElementById('historyTable_info').innerText;
          document.getElementById('historyTable_info').innerText = jobHistoryTableInfo.replace(jobHistoryTableInfo, jobHistoryTableInfo.toArabicUni());
        }
      });
      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });
    });
  </script>
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
