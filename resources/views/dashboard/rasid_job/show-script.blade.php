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
            [1, 5, 10, 15, 20]
        ],
        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },

      });
      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });
    });
  </script>
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
