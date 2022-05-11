<!-- SELECT2 JS -->
@section('datatable_script')
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
<script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}">
</script>


<script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
<!-- INTERNAL File-Uploads Js-->
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.ui.widget.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.fileupload.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.iframe-transport.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/fancyuploder/fancy-uploader.js"></script>
<script>
  $(function () {

      function format(d) {
        // `d` is the original data object for the row
        return '<table width="100%">' +
          '<tr>' +
          '<td></td>' +
          '<td colspan="0">' + '<label>البريد الالكتروني</label>' +
          '<p>test@test.com</p>' +
          '</td>' +
          '<td >' + '<label>العنوان</label>' +
          '<p>address</p>' +
          '</td>' +
          '<td >' + '<label>النوع</label>' +
          '<p>male</p>' +
          '</td>' +
          '<td >' + '<label>الحالة الاجتماعية</label>' +
          '<p>single</p>' +
          '</td>' +
          '<td >' + '<label>الجنسية</label>' +
          '<p>مصري</p>' +
          '</td>' +
          '<td></td>' +
          '</tr>' +
          '</table>';
      }

      var collapsedTable = $('#collapsedTable').DataTable({
        sDom: "t<'domOption'lpi>",
        pageLength: 10,
        lengthMenu: [
          [1, 5, 10, 20, -1],
          [1, 5, 10, 20, "الكل"],
        ],
        language: {
          lengthMenu: "عرض _MENU_",
          zeroRecords: "لا يوجد بيانات",
          info: "عرض _PAGE_ من _PAGES_ عنصر",
          infoEmpty: "لا يوجد نتائج بحث متاحة",
          paginate: {
            previous: '<i class="mdi mdi-chevron-right"></i>',
            next: '<i class="mdi mdi-chevron-left"></i>',
          },
        },
      });
      // Add event listener for opening and closing details

      $('#collapsedTable tbody').on('click', 'td:last-child', function () {
        var tr = $(this).closest('tr');
        var row = collapsedTable.row(tr);

        if (row.child.isShown()) {
          // This row is already open - close it.
          row.child.hide();
          tr.removeClass('shown');
        } else {
          // Open row.
          row.child(format(row.data())).show();
          tr.addClass('shown');
        }
      });


      var accounts_table = $("#orderTable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.bank_account.index') }}",
          data:
            function (data) {
              if ($('#bank_id').val() !== '' && $('#bank_id').val() !== null) data.bank_id = $('#bank_id').val();
              if ($('#client_type').val() !== '' && $('#client_type').val() !== null) data.client_type = $('#client_type').val();
              if ($('#clientName').val() !== '' && $('#clientName').val() !== null) data.fullname = $('#clientName').val();
              if ($('#tax_number').val() !== '' && $('#tax_number').val() !== null) data.tax_number = $('#tax_number').val();
              if ($('#commercial_number').val() !== '' && $('#commercial_number').val() !== null) data.commercial_number = $('#commercial_number').val();
              if ($('#from-hijri-picker-custom').val() !== '' && $('#from-hijri-picker-custom').val() !== null) data.created_from = $('#from-hijri-picker-custom').val();
              if ($('#to-hijri-picker-custom').val() !== '' && $('#to-hijri-picker-custom').val() !== null) data.created_to = $('#to-hijri-picker-custom').val();
              if ($('#account_status').val() !== '' && $('#account_status').val() !== null) data.account_status = $('#account_status').val();
              if ($('#transactionFrom').val() !== '' && $('#transactionFrom').val() !== null) data.trans_count_from = $('#transactionFrom').val();
              if ($('#transactionTo').val() !== '' && $('#transactionTo').val() !== null) data.trans_count_to = $('#transactionTo').val();
            },
          type: "GET",
          dataSrc: 'data',
        },

        columns: [{
          data: function (data, type, full, meta) {
            return meta.row + 1;
          },
          name: 'id',
          class: 'bank_account_index'
        },
          {
            data: "order_number",
            name: 'order_number'
          },
          {
            data: "fullname",
            name: 'fullname'
          },
          {
            data: 'client_type',
            name: 'client_type'
          },
          {
            data: 'commercial_number',
            name: 'commercial_number'
          },
          {
            data: 'tax_number',
            name: 'tax_number'
          },
{
data: 'created_at',
name: 'created_at'
},
          {
            data: "bank_name",
            name: 'bank_name'
          },
          {
            data: 'account_status',
            name: 'account_status'
          },

          {
            class: "text-center",
            data: function (data) {
              return `<a href="${data.show_route}" class="successIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="@lang('dashboard.general.accept')"><i class="mdi mdi-check"></i></a>
              <a href="${data.show_route}" class="errorIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="@lang('dashboard.general.refuse')"><i class="mdi mdi-close"></i></a>
              `
            },
            orderable: false,
            searchable: false
          }
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
          // table sorting
          var clientTableSorting = document.getElementsByClassName('client_index');
          for (var i = 0; i < clientTableSorting.length; i++) {
            clientTableSorting[i].innerText = clientTableSorting[i].innerText.replace(
              clientTableSorting[i].innerText, clientTableSorting[i].innerText
                .toArabicUni());
          }
          //pagination
          var clientTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < clientTablePagination.length - 1; i++) {
            clientTablePagination[i].innerText = clientTablePagination[i].innerText.replace(
              clientTablePagination[i].innerText, clientTablePagination[i].innerText
                .toArabicUni());
          }
          // info
          var clientTableInfo = document.getElementById('clientTable_info').innerText;
          document.getElementById('clientTable_info').innerText = clientTableInfo.replace(
            clientTableInfo, clientTableInfo.toArabicUni());
        }
      });
      accounts_table.draw();
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
        }).on('dp.change', function () {
        table.draw();
      });
      $("#client-search,#account-search").submit(function (e) {
        e.preventDefault();
        table.draw();
        accounts_table.draw();

      });
      $("#client-search,#account-search").on('reset', function (e) {
        e.preventDefault();
        $('#client_type,#account_status,#bank_id').val(null).trigger('change');
        $('#tax_number,#commercial_number,#clientName,#transactionFrom,#transactionTo').val(null);
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        $('#from-hijri-unactive-picker-custom').val("").trigger('change');
        $('#to-hijri-unactive-picker-custom').val("").trigger('change');
        table.draw();
        accounts_table.draw();

      });

      var table = $("#clientTable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.client.index') }}",
          data:
            function (data) {
              if ($('#bank_id').val() !== '' && $('#bank_id').val() !== null) data.bank_id = $('#bank_id').val();
              if ($('#client_type').val() !== '' && $('#client_type').val() !== null) data.client_type = $('#client_type').val();
              if ($('#clientName').val() !== '' && $('#clientName').val() !== null) data.fullname = $('#clientName').val();
              if ($('#tax_number').val() !== '' && $('#tax_number').val() !== null) data.tax_number = $('#tax_number').val();
              if ($('#commercial_number').val() !== '' && $('#commercial_number').val() !== null) data.commercial_number = $('#commercial_number').val();
              if ($('#from-hijri-picker-custom').val() !== '' && $('#from-hijri-picker-custom').val() !== null) data.created_from = $('#from-hijri-picker-custom').val();
              if ($('#to-hijri-picker-custom').val() !== '' && $('#to-hijri-picker-custom').val() !== null) data.created_to = $('#to-hijri-picker-custom').val();
              if ($('#account_status').val() !== '' && $('#account_status').val() !== null) data.account_status = $('#account_status').val();
              if ($('#transactionFrom').val() !== '' && $('#transactionFrom').val() !== null) data.trans_count_from = $('#transactionFrom').val();
              if ($('#transactionTo').val() !== '' && $('#transactionTo').val() !== null) data.trans_count_to = $('#transactionTo').val();
            },
          type: "GET",
          dataSrc: 'data',
        },

        columns: [{
          data: function (data, type, full, meta) {
            return meta.row + 1;
          },
          name: 'id',
          class: 'client_index'
        },

          {
            data: "fullname",
            name: 'fullname'
          },
          {
            data: 'client_type',
            name: 'client_type'
          },
          {
            data: 'commercial_number',
            name: 'commercial_number'
          },
          {
            data: 'tax_number',
            name: 'tax_number'
          },
          {
            data: 'transactions_done',
            name: 'transactions_done'
          },

          {
            data: "bank_name",
            name: 'bank_name'
          },
          {
            data: function (data) {
              if (data.account_status_name == 'pending') {
                return ` <span class="badge bg-success-opacity py-2 px-4">${data.account_status}</span>`;
              } else {
                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.account_status}</span>`;
              }
            },
            name: 'account_status'
          },

          {
            class: "text-center",
            data: function (data) {
              return `<a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="عرض"><i class="mdi mdi-eye-outline"></i></a>
              <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>
              <a href="#" class="successIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تأكيد الحساب "><i
                  class="mdi mdi-check"></i></a>
              <a href="#" class="primaryIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعليق الحساب "><i
                  class="mdi mdi-account-clock-outline"></i></a>`
            },
            orderable: false,
            searchable: false
          }
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
          // table sorting
          var clientTableSorting = document.getElementsByClassName('client_index');
          for (var i = 0; i < clientTableSorting.length; i++) {
            clientTableSorting[i].innerText = clientTableSorting[i].innerText.replace(
              clientTableSorting[i].innerText, clientTableSorting[i].innerText
                .toArabicUni());
          }
          //pagination
          var clientTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < clientTablePagination.length - 1; i++) {
            clientTablePagination[i].innerText = clientTablePagination[i].innerText.replace(
              clientTablePagination[i].innerText, clientTablePagination[i].innerText
                .toArabicUni());
          }
          // info
          var clientTableInfo = document.getElementById('clientTable_info').innerText;
          document.getElementById('clientTable_info').innerText = clientTableInfo.replace(
            clientTableInfo, clientTableInfo.toArabicUni());
        }
      });


      $("#status").change(function () {
        if (this.value == 'temporary') {
          $(".temporary").show();
        } else {
          $(".temporary").hide();
          $('#from-hijri-unactive-picker-custom').val(null);
          $('#to-hijri-unactive-picker-custom').val(null);
        }
        table.draw();
      }).change();

      $('#client_type,#account_status,#bank_id').on('select2:select', function (e) {
        table.draw();
        accounts_table.draw();

      });

      $("#tax_number,#commercial_number,#clientName,#transactionFrom,#transactionTo").keyup(function () {
        table.draw();
        accounts_table.draw();

      });


      $('#client-search').on('reset', function (e) {
        e.preventDefault();
        $('#client_type,#account_status,#bank_id').val(null).trigger('change');
        $('#tax_number,#commercial_number,#clientName,#transactionFrom,#transactionTo').val(null);
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        $('#from-hijri-unactive-picker-custom').val("").trigger('change');
        $('#to-hijri-unactive-picker-custom').val("").trigger('change');
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });

      table.on('draw', function () {
        var tooltipTriggerList = [].slice.call(
          document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
      });

    });
  </script>
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
