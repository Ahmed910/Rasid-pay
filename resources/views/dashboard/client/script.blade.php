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

      /******* Calendar *******/
      $("#from-hijri-picker-custom, #to-hijri-picker-custom, #from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
        .hijriDatePicker({
          hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
          showSwitcher: false,
          format: "YYYY-MM-DD",
          hijriFormat: "iYYYY-iMM-iDD",
          hijriDayViewHeaderFormat: "iMMMM iYYYY",
          dayViewHeaderFormat: "MMMM YYYY",
          showClear: true,
          ignoreReadonly: true,
        }).on('dp.change', function () {
        table.draw();
      });

      var table = $("#adminTable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.admin.index') }}?",
          data: function (data) {
            data.ban_status = $('#status').val();
            data.department_id = $('#mainDepartment').val();
            data.name = $('#userName').val();
            data.login_id = $('#userId').val();
            data.created_from = $('#from-hijri-picker-custom').val();
            data.created_to = $('#to-hijri-picker-custom').val();
            data.ban_from = $('#from-hijri-unactive-picker-custom').val();
            data.ban_to = $('#to-hijri-unactive-picker-custom').val();
          },
          type: "GET",
          dataSrc: 'data'
        },
        columns: [{
          data: function (data, type, full, meta) {
            return meta.row + 1;
          },
          name: 'id'
        },
          {
            data: "fullname",
            name: 'fullname'
          },
          {
            data: "login_id",
            name: 'login_id'
          },
          {
            data: function (data) {
              return data.department ? data.department.name :
                "{{ trans('dashboard.department.without_parent') }}";
            },
            name: 'department'
          },

          {
            data: "created_at",
            name: 'created_at'
          },
          {
            data: function (data) {
              if (data.ban_status == 'مفعل') {
                return ` <span class="badge bg-success-opacity py-2 px-4">${data.ban_status}</span>`;
              } else {
                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.ban_status}</span>`;
              }
            },
            name: 'ban_status'
          },
          {
            class: "text-center",
            data: function (data) {


              return `<a
                    href="${data.show_route}"
                    class="azureIcon"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="@lang('dashboard.general.show')"
                    ><i class="mdi mdi-eye-outline"></i
                        ></a>
                        <a
                        href="${data.edit_route}"
                        class="warningIcon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="@lang('dashboard.general.edit')"
                        ><i class="mdi mdi-square-edit-outline"></i
                            ></a>
                            `
            }
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
          var adminTableSorting = document.getElementsByClassName('sorting_1');
          for (var i = 0; i < adminTableSorting.length; i++) {
            adminTableSorting[i].innerText = adminTableSorting[i].innerText.replace(
              adminTableSorting[i].innerText, adminTableSorting[i].innerText
                .toArabicUni());
          }
          //pagination
          var adminTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < adminTablePagination.length - 1; i++) {
            adminTablePagination[i].innerText = adminTablePagination[i].innerText.replace(
              adminTablePagination[i].innerText, adminTablePagination[i].innerText
                .toArabicUni());
          }
          // info
          var adminTableInfo = document.getElementById('adminTable_info').innerText;
          document.getElementById('adminTable_info').innerText = adminTableInfo.replace(
            adminTableInfo, adminTableInfo.toArabicUni());
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

      $('#mainDepartment').on('select2:select', function (e) {
        table.draw();
      });

      $("#userName").keyup(function () {
        table.draw();
      });
      $("#userId").keyup(function () {
        table.draw();
      });

      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#status').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#userName').val(null);
        $('#userId').val(null);
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
<script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js"></script>
@endsection
