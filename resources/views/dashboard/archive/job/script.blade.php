<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>


<!-- SELECT2 JS -->
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>

<!-- DATE PICKER JS -->
<script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}">
</script>


<script>
    $(function() {
        /******* Calendar *******/
        $("#from-hijri-picker, #to-hijri-picker, #from-hijri-unactive-picker ,#to-hijri-unactive-picker")
            .hijriDatePicker({
                hijri: true,
                showSwitcher: false,
            });

        $("#jobTable").DataTable({
            sDom: "t<'domOption'lpi>",
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.job.archive') }}?" + $.param(
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
                        if (data.parent !== null) {
                            return data.parent.name;
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
                  data:"is_active"
                },
                {
                  class: "text-center",
                    data: function(data) {
                        tagInfo = (data.has_jobs) ?
                        `<i data-bs-toggle="modal" data-bs-target="#DeleteModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>`:
                            `<i data-bs-toggle="modal" data-bs-target="#unarchiveModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>` ;

                          return `<a
                                href="${data.show_route}"
                                class="azureIcon"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="التفاصيل"
                                ><i class="mdi mdi-eye-outline"></i
                              ></a>
                              <a
                              href="#"
                              class="successIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="استعادة"
                              ><i
                                data-bs-toggle="modal"
                                data-bs-target="#UnArchiveModal_${data.id}"
                                class="mdi mdi-backup-restore"
                              ></i
                            ></a>
                            <a
                              href="#"
                              class="errorIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="حذف"
                              ><i
                                data-bs-toggle="modal"
                                data-bs-target="#DeleteModal_${data.id}"
                                class="mdi mdi-trash-can-outline"
                              ></i
                            ></a>

                              <!-- DeleteModal Modal -->
      <div class="modal fade" id="DeleteModal_${data.id}">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0">
            <form method="post" action="${data.forceDelete_route}" class="needs-validation" novalidate>@csrf @method('delete')
            <div class="modal-body text-center p-0">
              <lottie-player
                autoplay
                loop
                mode="normal"
                src="{{ asset('dashboardAssets/images/lottie/delete.json') }}""
                style="width: 55%; display: block; margin: 0 auto 1em"
              >
              </lottie-player>
              <p>هل تريد إتمام عملية الحذف النهائي؟</p>
            </div>
            <div class="modal-footer justify-content-center mt-5 p-0">
                <button type="submit" class="btn btn-danger mx-3">
                  موافق
                </button>
                <button
                  type="button"
                  class="btn btn-outline-danger"
                  data-bs-dismiss="modal"
                >
                  غير موافق
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- UnArchiveModal -->
      <div class="modal fade" id="UnArchiveModal_${data.id}">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0">
            <form method="POST" action="${data.restore_route}" class="needs-validation" novalidate>@csrf
              <div class="modal-body text-center p-0">
                <lottie-player
                  autoplay
                  loop
                  mode="normal"
                  src="{{asset('dashboardassets/images/lottie/unarchive1.json')}}"
                  style="width: 55%; display: block; margin: 0 auto 1em"
                >
                </lottie-player>
                <p>هل تريد إتمام عملية الاستعادة؟</p>
                <div class="mt-3">
                  <textarea
                  name="reasonAction"
                    class="form-control"
                    placeholder="الرجاء ذكر السبب*"
                    rows="3"
                    required
                  ></textarea>

                  <div class="invalid-feedback">السبب مطلوب.</div>
                </div>
              </div>
              <div class="modal-footer justify-content-center mt-5 p-0">
                <button type="submit" class="btn btn-success mx-3">
                  موافق
                </button>
                <button
                  type="button"
                  class="btn btn-outline-success"
                  data-bs-dismiss="modal"
                >
                  غير موافق
                </button>
              </div>
            </form>
          </div>
        </div>
      </div> `
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
            language: {
                lengthMenu: "عرض _MENU_",
                zeroRecords: "لا يوجد بيانات",
                info: "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                infoEmpty: "لا يوجد نتائج بحث متاحة",
                paginate: {
                    previous: '<i class="mdi mdi-chevron-right"></i>',
                    next: '<i class="mdi mdi-chevron-left"></i>',
                },
            },
        });
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
