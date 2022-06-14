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
          ["١", "٥", "١٠", "١٥", "٢٠"]
        ],
        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
        "drawCallback": function (settings, json) {
          // transaction history table sorting
          var transactionHistoryTableSorting = document.getElementsByClassName('transaction_show_index');
          for (var i = 0; i < transactionHistoryTableSorting.length; i++) {
            transactionHistoryTableSorting[i].innerText = transactionHistoryTableSorting[i].innerText.replace(transactionHistoryTableSorting[i].innerText, transactionHistoryTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var transactionHistoryTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < transactionHistoryTablePagination.length - 1; i++) {
            transactionHistoryTablePagination[i].innerText = transactionHistoryTablePagination[i].innerText.replace(transactionHistoryTablePagination[i].innerText, transactionHistoryTablePagination[i].innerText.toArabicUni());
          }
          // transaction history table show info
          var transactionHistoryTableInfo = document.getElementById('historyTable_info').innerText;
          document.getElementById('historyTable_info').innerText = transactionHistoryTableInfo.replace(transactionHistoryTableInfo, transactionHistoryTableInfo.toArabicUni());
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
