@section('datatable_script')
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
  <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
  <script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js">
  </script>
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
          minDate: '1900-01-01',
          maxDate: '2100-01-01',
          showClear:true,
          isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
          ignoreReadonly: true,
        });

      var table = $("#package-table").DataTable({
        responsive: true,
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.client_package.index') }}?" + $.param(
            @json(request()->query())),
           data: function (data) {
            data.id = $('#client_id').val();
          },
          type: "GET",
          dataSrc: 'data'
        },
        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'package_index'
        },
          {
            data: "fullname",
            name: "fullname"
          },

          {
            data: "basic_discount",
            name: 'basic_discount'
          },
          {
            data: "golden_discount",
            name: 'golden_discount'
          },
          {
            data: "platinum_discount",
            name: 'platinum_discount'
          },

          {
            class: "text-center",
            data: function (data) {
              return `<a
                            href="${data.edit_route}"
                            class="warningIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="@lang('dashboard.general.edit')"
                            ><i class="mdi mdi-square-edit-outline"></i
                            ></a>`

            },
            orderable: false,
            searchable: false
          }
        ],
        createdRow: function (row, data) {
          $('[data-toggle="popoverIMG"]', row).popover({
            placement: "right",
            trigger: "hover",
            html: true,
          });
        },
        pageLength: 10,
        lengthMenu: [
          [1, 5, 10, 15, 20],
          ["١", "٥","١٠","١٥", "٢٠"]
        ],

        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
        "drawCallback": function (settings, json) {
          // table sorting
          var activityLogTableSorting = document.getElementsByClassName('package_index');
          for (var i = 0; i < activityLogTableSorting.length; i++) {
            activityLogTableSorting[i].innerText = activityLogTableSorting[i].innerText.replace(activityLogTableSorting[i].innerText, activityLogTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var activityLogTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < activityLogTablePagination.length - 1; i++) {
            activityLogTablePagination[i].innerText = activityLogTablePagination[i].innerText.replace(activityLogTablePagination[i].innerText, activityLogTablePagination[i].innerText.toArabicUni());
          }
          // info
          var packageTableInfo = document.getElementById('package-table_info').innerText;
          document.getElementById('package-table_info').innerText = packageTableInfo.replace(packageTableInfo, packageTableInfo.toArabicUni());
        }
      });

      $("#client_id").on('select2:select', function (e) {
        insertUrlParam('id', $('#client_id').val());
        table.draw();

      });

      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#activityName').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#mainProgram').val(null);
        $('#branchProgram').val(null);
        table.draw();
        if (location.href.includes('?')) {
            history.pushState({}, null, location.href.split('?')[0]);
          }
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });

    });
  </script>

  {{-- <script>
      $(document).ready(function () {
         $("select")
           .change(function () {
             $(this)
               .find("option:selected")
               .each(function () {
                 var optionValue = $(this).attr("value");
                 if (optionValue) {
                   $(".hold")
                     .not("." + optionValue)
                     .hide();
                   $("." + optionValue).show();
                 } else {
                   $(".hold").hide();
                 }
               });
           })
           .change();
       });


  </script> --}}
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
