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
        }).on('dp.change', function () {
        table.draw();
      });

      var table = $("#JobsTable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        ajax: {
          url: "{{ route('dashboard.rasid_job.index') }}",
          data: function (data) {
            data.name = $('#job_name').val();
            data.created_from = $('#from-hijri-picker-custom').val();
            data.created_to = $('#to-hijri-picker-custom').val();
            data.is_active = $('#status').val();
            data.is_vacant = $('#type').val();
            data.department_id = $('#mainDepartment').val();
          },
          type: "GET",
          dataSrc: 'data'
        },

        // ajax: {
        //     url: "{{ route('dashboard.rasid_job.index') }}?" + $.param(
        //         @json(request()->query()))
        // },

        columns: [{
          data: function (data, type, full, meta) {
            return parseInt(meta.row) + parseInt(data.start_from) + 1;
          },
          name: 'id',
          class: 'rasid_job_index'
        }
          ,
          {
            data: "name",
            name: "name"
          },
          {
            data: function (data) {
              if (data.department_name !== null) {

                // TODO::change imgae to default value
                let image = 'default';
                if (data.department_image != null) {
                  image = data.department_image;
                }

                return `<div class="d-flex align-items-center"><div class="flex-shrink-0"> <img src="${image}" data-toggle="popoverIMG" title='<img src="${image}" width="300" height="300" class="d-block rounded-3" alt="">' width="25" class="avatar brround cover-image" alt="..." /> </div><div class="flex-grow-1 ms-3">${data.department_name}</div>`
              } else {
                return "@lang('dashboard.department.without_parent')";
              }
            },
            name: "department"
          },
          {
            data: "created_at",
            name: "created_at"
          },
          {
            data: function (data) {
              if (data.is_active) {
                return ` <span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.rasid_job.active_cases.1')"}</span>`;
              } else {
                return ` <span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.rasid_job.active_cases.0')"}</span>`;
              }
            },

            name: "is_active"
          },
          {
            data: function (data) {
              if (data.is_vacant) {
                return ` <span class="occupied">${"@lang('dashboard.rasid_job.is_vacant.true')"}</span>`;
              } else {
                return ` <span class="vacant">${"@lang('dashboard.rasid_job.is_vacant.false')"}</span>`;
              }
            },
            name: "is_vacant"
          },
          {
            class: "text-center",
            data: function (data) {
              fun_modal = !data.is_vacant ?
                `notArchiveItem('@lang('dashboard.rasid_job.jobs_hired_archived')')` :
                `archiveItem('${data.id}', '${data.delete_route}','${'#JobsTable'}')`;
              return `<a
                  href="${data.show_route}"
                  class="azureIcon"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="${"@lang('dashboard.general.show')"}"
                  ><i class="mdi mdi-eye-outline"></i
                ></a>
                <a
                  href="${data.edit_route}"
                  class="warningIcon"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="${"@lang('dashboard.general.edit')"}"
                  ><i class="mdi mdi-square-edit-outline"></i
                ></a>
                <a
            href="#"
                            onclick="${fun_modal}"
                            class="primaryIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="@lang('dashboard.general.archive')"
                            ><i class="mdi mdi-archive-arrow-down-outline"></i></a>`
            },
            orderable: false,
            searchable: false
          }
        ],
        createdRow: function (row, data) {
          $('[data-toggle="popoverIMG"]', row).popover({
            placement: "left",
            trigger: "hover",
            html: true,
          });
          $('[data-toggle="popoverIMG"]', row).popover({
            placement: "left",
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
          var jobTableSorting = document.getElementsByClassName('rasid_job_index');
          for (var i = 0; i < jobTableSorting.length; i++) {
            jobTableSorting[i].innerText = jobTableSorting[i].innerText.replace(jobTableSorting[i].innerText, jobTableSorting[i].innerText.toArabicUni());
          }
          //pagination
          var jobTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < jobTablePagination.length - 1; i++) {
            jobTablePagination[i].innerText = jobTablePagination[i].innerText.replace(jobTablePagination[i].innerText, jobTablePagination[i].innerText.toArabicUni());
          }
          // info
          var jobTableInfo = document.getElementById('JobsTable_info').innerText;
          document.getElementById('JobsTable_info').innerText = jobTableInfo.replace(jobTableInfo, jobTableInfo.toArabicUni());
        }
      });
      $('.select2').select2({
        minimumResultsForSearch: Infinity,
        createSearchChoice: function (term) {
          if (term.match(/^[a-zA-Z0-9]+$/g))
            return {
              id: term,
              text: term
            };
        },
        formatNoMatches: "Enter valid format text"
      })


      $("#job_name").keyup(function () {
        table.draw();
      });

      $('#mainDepartment').on('select2:select', function (e) {
        table.draw();
      });

      $('#status').on('select2:select', function (e) {
        table.draw();
      });

      $('#type').on('select2:select', function (e) {
        table.draw();
      });

      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#job_name').val(null);
        $('#mainDepartment').val(null).trigger('change');
        $('#status').val(null).trigger('change');
        $('#type').val(null).trigger('change');
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
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
  <!-- SELECT2 JS -->
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
