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
          ignoreReadonly: true,
          minDate: '1900-01-01',
          maxDate: '2100-01-01',
          showClear:true,
          isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
        }).on('dp.change', function () {
        table.draw();
      });

      var table = $("#adminTable").DataTable({
        responsive: true,
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.admin.index') }}",
          data: function (data) {
            insertUrlParam('sort[column]', data.columns[data.order[0].column].name);
            insertUrlParam('sort[dir]',data.order[0].dir);
            data.ban_status = $('#status').val();
            data.department_id = $('#mainDepartment').val();
            data.name = $('#userName').val();
            data.phone = $('#phone').val();
            data.email = $('#email').val();
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
          name: 'id',
          class: 'admin_index'
        },
          {
            data: "login_id",
            name: 'login_id'
          },
          {
            data: "fullname",
            name: 'fullname'
          },
          {
            data: "phone",
            name: 'phone'
          },
          {
            data: "email",
            name: 'email'
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
              if (data.ban_status == "{{trans('dashboard.admin.active_cases.active')}}") {
                return ` <span class="badge bg-success-opacity py-3 w-50">${data.ban_status}</span>`;
              } else {
                if (data.ban_from !=null ) {
                  return `<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="من  ${data.ban_from} <br><br> إلى  ${data.ban_to} " class="badge bg-danger-opacity py-3 w-50">${data.ban_status}</span>`;
                } else {
                  return ` <span class="badge bg-danger-opacity py-3 w-50">${data.ban_status}</span>`;
                }
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
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        }

      });


      $("#status").change(function () {
        insertUrlParam('ban_status', $('#status').val());
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
        insertUrlParam('department_id', $('#mainDepartment').val());
        table.draw();
      });

      $("#userName,#phone,#email").keyup(function () {
        insertUrlParam($(this).attr('id'), $(this).val());
        table.draw();
      });
      $("#userId").keyup(function () {
        insertUrlParam('login_id', $('#userId').val());
        table.draw();
      });

      $("#from-hijri-unactive-picker-custom").on('dp.change', function (event) {
          insertUrlParam('ban_to', $('#from-hijri-unactive-picker-custom').val());
       });

      $("#to-hijri-unactive-picker-custom").on('dp.change', function (event) {
          insertUrlParam('ban_from', $('#to-hijri-unactive-picker-custom').val());
       });

      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#status').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#userName').val(null);
        $('#email').val(null);
        $('#phone').val(null);
        $('#userId').val(null);
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        $('#from-hijri-unactive-picker-custom').val("").trigger('change');
        $('#to-hijri-unactive-picker-custom').val("").trigger('change');
        table.column('').order('asc' ).search('').draw();
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
