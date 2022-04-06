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

             $("#jobTable").DataTable({
                 sDom: "t<'domOption'lpi>",
                 serverSide: true,
                 ajax: {
                     url: "{{ route('dashboard.rasid_job.archive') }}?" + $.param(
                         @json(request()->query())),
                     dataSrc: 'data'
                 },
                 columns: [{
                         data: function(data, type, full, meta) {
                             return meta.row + 1;
                         }
                     },
                     {
                         data: "name"
                     },
                     {
                         data: function(data) {
                             if (data.department_name !== null) {
                                 return data.department_name;
                             } else {
                                 return "@lang('dashboard.department.without_parent')";
                             }
                         }
                     },
                     {
                         data: "deleted_at"
                     },
                     {
                         data: function(data) {
                             if (data.is_active) {
                                 return ` <span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.general.active')"}</span>`;
                             } else {
                                 return ` <span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.general.inactive')"}</span>`;
                             }
                         }
                     },
                     {
                         class: "text-center",
                         data: function(data) {
                             tagInfo = (data.has_jobs) ?
                                 `<i data-bs-toggle="modal" data-bs-target="#DeleteModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>` :
                                 `<i data-bs-toggle="modal" data-bs-target="#unarchiveModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>`;

                             return `<a
                                href="${data.show_route}"
                                class="azureIcon"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="@lang('dashboard.general.show')"
                                ><i class="mdi mdi-eye-outline"></i
                              ></a>
                              <a
                              href="#"
                              onclick=unArchiveItem('${data.id}','${data.restore_route}')
                              class="successIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="استعادة"
                              ><i
                                data-bs-toggle="modal"
                                class="mdi mdi-backup-restore"
                              ></i
                            ></a>
                            <a
                              href="#"
                              onclick=ForceDeleteItem('${data.id}','${data.forceDelete_route}')
                              class="errorIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="حذف"
                              ><i
                                data-bs-toggle="modal"
                                class="mdi mdi-trash-can-outline"
                              ></i
                            ></a>

                              `
                         },
                         orderable: false,
                         searchable: false
                     }
                 ],
                 pageLength: 10,
                 lengthMenu: [
                     [1, 5, 10, 20, -1],
                     [1, 5, 10, 20, "الكل"],
                 ],
                 "language": {
                     "lengthMenu": "@lang('dashboard.general.show') _MENU_",
                     "emptyTable": "@lang('dashboard.general.no_data')",
                     "info": "@lang('dashboard.general.showing') _START_ @lang('dashboard.general.to') _END_ @lang('dashboard.general.from') _TOTAL_ @lang('dashboard.general.entries')",
                     "infoEmpty": "",
                     "paginate": {
                         "next": '<i class="mdi mdi-chevron-left"></i>',
                         "previous": '<i class="mdi mdi-chevron-right"></i>'
                     },
                 }
             });
             $('.select2').select2({
                 minimumResultsForSearch: Infinity
             });
         });
     </script>
     <!-- SELECT2 JS -->
     <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
     <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
 @endsection
