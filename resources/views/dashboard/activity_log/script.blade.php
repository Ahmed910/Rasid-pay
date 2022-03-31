@section('datatable_script')
<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
<script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
<script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js"></script>
{{-- Ajax DataTable --}}
<script>
        $(function() {
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
            $("#activitylogtable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                ajax: {
                    url: "{{ route('dashboard.activity_log.index') }}?" + $.param(
                        @json(request()->query()))
                },
                columns: [{
                        data: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
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


                        }
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

                        }
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
                    [5, 10, 20, -1],
                    [5, 10, 20, "@lang('dashboard.general.all')"],
                ],

                "language": {
                    "lengthMenu": "@lang('dashboard.general.show') _MENU_",
                    "emptyTable": "@lang('dashboard.general.no_data')",
                    "info": "@lang('dashboard.general.showing') _START_ @lang('dashboard.general.to') _END_ @lang('dashboard.general.from') _TOTAL_ @lang('dashboard.general.entries')",
                    "infoEmpty": "@lang('dashboard.general.no_search_result')",
                    "paginate": {
                        "next": '<i class="mdi mdi-chevron-left"></i>',
                        "previous": '<i class="mdi mdi-chevron-right"></i>'
                    },
                }
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
