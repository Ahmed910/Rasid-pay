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
          showClear: true,
          isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
          icons:{
            clear:"{{ trans('dashboard.general.delete') }}"
          }
        }).on('dp.change', function () {
        table.draw();
      });

      var table = $("#departmentTable").DataTable({
        responsive: true,
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.department.index') }}",
          data: function (data) {
            insertUrlParam('sort[column]', data.columns[data.order[0].column].name);
            insertUrlParam('sort[dir]',data.order[0].dir);

            data.name = $('#departmentName').val();
            data.created_from = $('#from-hijri-picker-custom').val();
            data.created_to = $('#to-hijri-picker-custom').val();
            data.is_active = $('#status').val();
            data.parent_id = $('#parent_id').val();
          },
          type: "GET",
          dataSrc: 'data'
        },
        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'department_index'
        },
          {
            data: function (data) {

              // TODO::change imgae to default value
              let image = 'default';
              if (data.image != null) {
                image = data.image;
              }

              return `<div class="d-flex align-items-center"><div class="flex-shrink-0">
                              <img src="${image}" data-toggle="popoverIMG" title='<img src="${image}" width="300" height="300" class="d-block rounded-3" alt="">' width="25" class="avatar brround cover-image" alt="..."/> </div><div class="flex-grow-1 ms-3">${data.name}</div>`
            },
            name: 'name'
          },
          {
            data: function (data) {
              return data.parent ? data.parent.name :
                "{{ trans('dashboard.department.without_parent') }}";
            },
            name: 'parent'
          },
          {
            data: "created_at",
            name: 'created_at'
          },
          {
            data: function (data) {
              if (data.is_active) {
                return ` <span class="badge bg-success-opacity py-2 px-4">${data.active_case}</span>`;
              } else {
                return ` <span class="badge bg-danger-opacity py-2 px-4">${data.active_case}</span>`;
              }
            },
            name: 'is_active'
          },
          {
            class: "text-center",
            data: function (data) {
              if (data.has_jobs) {
                fun_modal =
                  `notArchiveItem('@lang('dashboard.department.has_jobs_cannot_delete')')`;
              }else if (data.has_children) {
                fun_modal =
                  `notArchiveItem('@lang('dashboard.department.department_has_relationship_cannot_delete')')`;
              } else {
                fun_modal =
                  `archiveItem('${data.id}', '${data.delete_route}','${'#departmentTable'}')`;
              }

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
                            <a
                            href="#"
                            onclick="${fun_modal}"
                            class="primaryIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ trans('dashboard.general.archive') }}"
                            ><i class="mdi mdi-archive-arrow-down-outline"></i></a>`
            },
            orderable: false,
            searchable: false
          }
        ],
        createdRow: function (row, data) {
          $('[data-toggle="popoverIMG"]', row).popover({
            trigger: "hover",
            html: true,
            placement: "left",
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
          var departmentTableSorting = document.getElementsByClassName('department_index');
          for (var i = 0; i < departmentTableSorting.length; i++) {
            departmentTableSorting[i].innerText = departmentTableSorting[i].innerText.replace(departmentTableSorting[i].innerText, departmentTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var departmentTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < departmentTablePagination.length - 1; i++) {
            departmentTablePagination[i].innerText = departmentTablePagination[i].innerText.replace(departmentTablePagination[i].innerText, departmentTablePagination[i].innerText.toArabicUni());
          }
          // info
          var departmentTableInfo = document.getElementById('departmentTable_info').innerText;
          document.getElementById('departmentTable_info').innerText = departmentTableInfo.replace(departmentTableInfo, departmentTableInfo.toArabicUni());
        }
      });

      $('#status').on('select2:select', function (e) {
        insertUrlParam('is_active', $('#status').val());
        table.draw();
      });

      $('#parent_id').on('select2:select', function (e) {
        insertUrlParam('parent_id', $('#parent_id').val());
        table.draw();
      });

      $("#departmentName").keyup(function () {
        insertUrlParam('name', $('#departmentName').val());
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });

      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#status').val(null).trigger('change');
        $('#parent_id').val(null).trigger('change');
        $('#departmentName').val(null);
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
          if (location.href.includes('?')) {
            history.pushState({}, null, location.href.split('?')[0]);
          }
          table.column('').order('asc' ).search('').draw();
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
