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
        processing: true,
        ajax: {
          url: "{{ route('dashboard.transaction.show', $transaction->id) }}?" + $.param(
            @json(request()->query())),
          dataSrc: 'data',
          type: "GET",
        },

        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'transaction_show_index'
        },
          {
            data: function (data) {
              if (data.user !== null) {
                return data.user.fullname;
              } else {
                return "";
              }
            },
            name: "employee"
          },
          {
            data: "created_at",
            name: "created_at"

          },
          {
            data: function (data) {
              @include('dashboard.layouts.globals.datatable.activity_log_actions')
            }
          },
          {
            data: "reason",
            name: "reason"
          },


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
    });

    $('.select2').select2({
      minimumResultsForSearch: Infinity
    });
  </script>
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
