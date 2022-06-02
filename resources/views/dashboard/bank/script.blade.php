@section('datatable_script')
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
  <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
  <script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>


  </script>
  {{-- Ajax DataTable --}}
  <script>
    $(function () {
      $("#transaction").DataTable({
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
          showClear: true,
          isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
          ignoreReadonly: true,
        });
      var table = $("#activitylogtable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.bank.index') }}?" + $.param(
            @json(request()->query())),
          data: function (data) {
            if ($('#branch_name').val() != "" && $('#branch_name').val() != null) data.branch_name = $('#branch_name').val();
            if ($('#code').val() != "" && $('#code').val() != null) data.code = $('#code').val();
            if ($('#is_active').val() != "" && $('#is_active').val() != null) data.is_active = $('#is_active').val();
            if ($('#type').val() != "" && $('#type').val() != null) data.type = $('#type').val();
            if ($('#site').val() != "" && $('#site').val() != null) data.site = $('#site').val();
            if ($('#transfer_amount').val() != "" && $('#transfer_amount').val() != null) data.transfer_amount = $('#transfer_amount').val();
            if ($('#transactions_count').val() != "" && $('#transactions_count').val() != null) data.transactions_count = $('#transactions_count').val();
            if ($('#name').val() != "" && $('#name').val() != null) data.name = $('#name').val();

          },
          type: "GET",
          dataSrc: 'data',
        },

        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'activity_log_index'
        },
          {
            data: "bank_name",
            name: "name"
          },

          {
            data: "type",
            name: 'type'
          },
          {

            data: "code",
            name: "code"

          },
          {
            data: "name",
            name: "branch_name"
          },
          {
            data: "site",
            name: "site"


          },
          {
            data: "transfer_amount",
            name: "transfer_amount"

          },
          {
            data: "transactions_count",
            name: "transactions_count"
          },
          {
            data: function (data) {
              if (data.active_case) {
                return ` <span class="badge bg-success-opacity py-2 px-4">${data.is_active}</span>`;
              } else {
                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.is_active}</span>`;
              }
            },
            name: 'is_active'
          },

          {
            data: function (data) {
              return `<a href="${data.show_route}" class="azureIcon" data-bs-toggle="tooltip"
                  data-bs-placement="top" title="@lang('dashboard.general.show')"><i
                    class="mdi mdi-eye-outline"></i></a>
                <a href="${data.edit_route}" class="warningIcon" data-bs-toggle="tooltip"
                  data-bs-placement="top" title="@lang('dashboard.general.edit')"><i
                    class="mdi mdi-square-edit-outline"></i></a>`
            },
            name: "actions"
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
          [1, 5, 10, 15, 20]
        ],

        "language": {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
        "drawCallback": function (settings, json) {
          // table sorting
          var activityLogTableSorting = document.getElementsByClassName('activity_log_index');
          for (var i = 0; i < activityLogTableSorting.length; i++) {
            activityLogTableSorting[i].innerText = activityLogTableSorting[i].innerText.replace(activityLogTableSorting[i].innerText, activityLogTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var activityLogTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < activityLogTablePagination.length - 1; i++) {
            activityLogTablePagination[i].innerText = activityLogTablePagination[i].innerText.replace(activityLogTablePagination[i].innerText, activityLogTablePagination[i].innerText.toArabicUni());
          }
          // info
          var activityLogTableInfo = document.getElementById('activitylogtable_info').innerText;
          document.getElementById('activitylogtable_info').innerText = activityLogTableInfo.replace(activityLogTableInfo, activityLogTableInfo.toArabicUni());
        }
      });

      $('#type').on('select2:select', function (e) {

        table.draw();
      });
      $("#is_active").on('select2:select', function (e) {
        table.draw();

      });
      $('#mainProgram').on('select2:select', function (e) {
        table.draw();
      });

      $('#branchProgram').on('select2:select', function (e) {
        table.draw();
      });
      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#activityName').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#mainProgram').val(null);
        $('#branchProgram').val(null);
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });
      $("#branch_name,#code,#is_active,#site,#transfer_amount,#transactions_count,#name").keyup(function () {
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });
      //get subprogs from activity_logs script
      $("#mainProgram").change(function (e) {
        e.preventDefault();
        let mainprog_id = $("#mainProgram").val();
        $('#branchProgram').empty();
        $("#branchProgram").append('<option value=""> {{ trans('dashboard.activity_log.select_subprogram') }} </option>')
        if (mainprog_id != '') {


          //send ajax
          $.ajax({
            url: '{{ url('dashboard/activitylog/sub-programs') }}' + '/' + mainprog_id,
            type: 'get',
            success: function (data) {
              if (data) {
                $.each(data.data, function (index, subprogram) {
                  $("#branchProgram").append('<option value="' + subprogram.name +
                    '">' + subprogram.name + '</option>')
                });
              }
            }
          });
        }

      });
      //get employees from Department
      $("#mainDepartment").change(function (e) {
        e.preventDefault();
        let maindep_id = $("#mainDepartment").val();
        $('#employee').empty();
        $("#employee").append('<option value=""> {{ trans('dashboard.activity_log.select_employee') }} </option>')
        if (maindep_id != '') {


          //send ajax
          $.ajax({
            url: '/dashboard/activitylog/all-employees/' + maindep_id,
            type: 'get',
            success: function (data) {
              if (data) {
                $.each(data.data, function (index, user_id) {
                  $("#employee").append('<option value="' + user_id.id +
                    '">' + user_id.fullname + '</option>')
                });

              }
            }
          });
        }

      });


    });

    // add bank branch function
    $(function () {
      jQuery.mark = {
        addNewBranch: function (options) {
          var defaults = {
            selector: '#addBranchBtn'
          };
          if (typeof options == 'string') defaults.selector = options;
          var options = jQuery.extend(defaults, options);
          return jQuery(options.selector).each(function () {
            var obj = jQuery(this);
            var geddit = $('.createBankBranch:first');
            var gedditUp = geddit.parent();
            obj.click(function (e) {
              geddit.clone(true, true).appendTo('#add-branch-form');
              e.preventDefault();
            });
          })
        },
        deleteBranch: function (options) {
          var defaults = {
            selector: '.deleteBranch'
          };
          if (typeof options == 'string') defaults.selector = options;
          var options = jQuery.extend(defaults, options);
          return jQuery(options.selector).each(function () {
            var obj = jQuery(this);
            obj.on("click", function (e) {
              jQuery(this).parent().remove();
              e.preventDefault();
            });
          })
        }
      }
    });

    jQuery(function () {
      jQuery.mark.addNewBranch();
      jQuery.mark.deleteBranch();
    });
    // end add bank branch function

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
