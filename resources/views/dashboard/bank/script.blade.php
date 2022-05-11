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
    $(function() {
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
                    showClear: true,
                    ignoreReadonly: true,
                });
                var table = $("#activitylogtable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                ajax: {
                    url: "{{ route('dashboard.activity_log.index') }}?" + $.param(
                        @json(request()->query()))
                },
                columns: [{
                  data: function (data, type, full, meta) {
                    return parseInt(meta.row) + parseInt(data.start_from) + 1;
                  },
                  name: 'id',
                  class: 'activity_log_index'
                    },
                    {
                        data: "user.fullname",
                        name : "employee"
                    },

                    {
                        data: function(data) {
                          if(data.user.department !== null){
                            return data.user.department.name;
                          }else{
                            return  "{{ trans('dashboard.department.without_parent') }}";
                              }
                        },
                        name: 'department'
                    },

                   {

                    data:function(data) {
                            return data.auditable_type ? data.auditable_type :
                                " ";
                        },
                    name : "main_program"

                   },
                   {
                    data:"type",
                   name : "subprogram"


                    },
                    {
                        data: "created_at",
                        name: "created_at"

                    },
                    {
                        data: "ip",
                        name: "ip"
                    },

                    {
                        data: function(data) {
                            if (data.type == 'created') {
                                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.create')"}</span>`;
                            }
                            if (data.type == 'updated') {
                                return `<span class="badge bg-warning-opacity py-2 px-4">${"@lang('dashboard.general.edit')"}</span>`;
                            }
                            if (data.type == 'destroy') {
                                return `<span class="badge bg-primary-opacity py-2 px-4">${"@lang('dashboard.general.archive')"}</span>`;
                            }
                            if (data.type == 'restored') {
                                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.restore')"}</span>`;
                            }
                            if (data.type == 'permanent_delete') {
                                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.force_delete')"}</span>`;
                            }
                            if (data.type == 'searched') {
                                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.search')"}</span>`;
                            }
                            if (data.type == 'deactivated') {
                                return `<span class="badge bg-default-opacity py-2 px-4">${"@lang('dashboard.general.unactivited')"}</span>`;
                            }
                            if (data.type == 'activated') {
                                return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.activited')"}</span>`;
                            }

                        },
                        name:"type"
                    },

                    {
                        class: "text-center",
                        data: function(data) {
                            return `<a
                  href="${data.show_route}"
                  class="azureIcon"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="${"@lang('dashboard.general.show')"}"
                  ><i class="mdi mdi-eye-outline"></i
                ></a>`

                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data) {
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

            $('#activityName').on('select2:select', function (e) {

          table.draw();
      });
      $("#mainDepartment").on('select2:select',function (e) {
        table.draw();

      });
      $('#mainProgram').on('select2:select', function(e) {
                table.draw();
            });

      $('#branchProgram').on('select2:select', function(e) {
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

            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
                //get subprogs from activity_logs script
      $("#mainProgram").change(function(e) {
                  e.preventDefault();
                  let mainprog_id = $("#mainProgram").val();
                  $('#branchProgram').empty();
                  $("#branchProgram").append('<option value=""> {{ trans('dashboard.activity_log.select_subprogram') }} </option>')
                  if (mainprog_id != '') {


                      //send ajax
                      $.ajax({
                          url: '{{ url('dashboard/activitylog/sub-programs') }}' + '/' + mainprog_id,
                          type: 'get',
                          success: function(data) {
                              if (data) {
                                  $.each(data.data, function(index, subprogram) {
                                      $("#branchProgram").append('<option value="' + subprogram.name +
                                          '">' + subprogram.name + '</option>')
                                  });
                              }
                          }
                      });
                  }

              });
 //get employees from Department
 $("#mainDepartment").change(function(e) {
                  e.preventDefault();
                  let maindep_id = $("#mainDepartment").val();
                  $('#employee').empty();
                  $("#employee").append('<option value=""> {{ trans('dashboard.activity_log.select_employee') }} </option>')
                  if (maindep_id != '') {


                      //send ajax
                      $.ajax({
                          url: '/dashboard/activitylog/all-employees/' + maindep_id,
                          type: 'get',
                          success: function(data) {
                              if (data) {
                                  $.each(data.data, function(index, user_id) {
                                      $("#employee").append('<option value="' + user_id.id +
                                          '">' + user_id.fullname + '</option>')
                                  });

                              }
                          }
                      });
                  }

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