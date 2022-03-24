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
             $("#JobsTable").DataTable({
                 sDom: "t<'domOption'lpi>",
                 serverSide: true,
                 ajax: {
                     url: "{{ route('dashboard.job.index') }}?" + $.param(
                         @json(request()->query()))
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
                                 return `<div class="d-flex align-items-center"><div class="flex-shrink-0"> <img src="${data.image}" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" /> </div><div class="flex-grow-1 ms-3">${data.department_name}</div>`
                             }
                         }
                     },
                     {
                         data: "created_at"
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
                         data: function(data) {
                             if (data.is_vacant) {
                                 return ` <span class="occupied">${"@lang('dashboard.job.is_vacant.true')"}</span>`;
                             } else {
                                 return ` <span class="vacant">${"@lang('dashboard.job.is_vacant.false')"}</span>`;
                             }
                         }
                     },
                     {
                         class: "text-center",
                         data: function(data) {
                           fun_modal = !data.is_vacant ? `notArchiveItem()` :
                             `archiveItem('${data.id}', '${data.delete_route}')`;
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
                         }
                     }
                 ],
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
         });
     </script>
     <!-- SELECT2 JS -->
     <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
     <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
 @endsection
