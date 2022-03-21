<!-- SELECT2 JS -->
<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>

<!-- DATE PICKER JS -->
<script src="{{ asset('dashboardAssets/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js') }}"></script>


<script>
    $(function() {
        /******* Calendar *******/
        $("#from-hijri-picker, #to-hijri-picker, #from-hijri-unactive-picker ,#to-hijri-unactive-picker")
            .hijriDatePicker({
                hijri: true,
                showSwitcher: false,
            });

        $("#departmentTable").DataTable({
            sDom: "t<'domOption'lpi>",
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.department.index') }}?" + $.param(
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
                    class: "text-center",
                    data: function(data) {
                        tagInfo = (data.has_jobs) ?
                            `<i data-bs-toggle="modal" data-bs-target="#notArchiveModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>` :
                            `<i data-bs-toggle="modal" data-bs-target="#archiveModal_${data.id}" class="mdi mdi-archive-arrow-down-outline"></i>`;

                        return `<a
                                href="${data.show_route}"
                                class="azureIcon"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="التفاصيل"
                                ><i class="mdi mdi-eye-outline"></i
                              ></a>
                              <a
                                href="${data.edit_route}"
                                class="warningIcon"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="تعديل"
                                ><i class="mdi mdi-square-edit-outline"></i
                              ></a>
                              <a
                              href="#"
                              class="primaryIcon"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="أرشفة"
                              >${tagInfo}</a>

                            <!-- archiveModal -->
                            <div class="modal fade" id="archiveModal_${data.id}">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">
                                  <form method="post" action="${data.delete_route}" class="needs-validation" novalidate>@csrf
                                    <div class="modal-body text-center p-0">
                                      <lottie-player
                                        autoplay
                                        loop
                                        mode="normal"
                                        src="{{ asset('dashboardAssets/images/lottie/archive.json') }}"
                                        style="width: 55%; display: block; margin: 0 auto 1em"
                                      >
                                      </lottie-player>
                                      <p>هل تريد إتمام عملية الأرشفة؟</p>
                                      <div class="mt-3">
                                        <textarea
                                          class="form-control"
                                          placeholder="الرجاء ذكر السبب*"
                                          rows="3"
                                          required
                                        ></textarea>

                                        <div class="invalid-feedback">السبب مطلوب.</div>
                                      </div>
                                    </div>
                                    <div class="modal-footer justify-content-center mt-5 p-0">
                                      <button type="submit" class="btn btn-primary mx-3">
                                        موافق
                                      </button>
                                      <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        data-bs-dismiss="modal"
                                      >
                                        غير موافق
                                      </button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <!-- notArchiveModal Modal -->
                            <div class="modal fade" id="notArchiveModal_${data.id}">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">
                                  <div class="modal-body text-center p-0">
                                    <lottie-player
                                      autoplay
                                      loop
                                      mode="normal"
                                      src="{{ asset('dashboardAssets/images/lottie/unarchive.json') }}"
                                      style="width: 55%; display: block; margin: 0 auto 1em"
                                    >
                                    </lottie-player>
                                    <p>لا يمكن أرشفة قسم مرتبط بوظائف</p>
                                  </div>
                                  <div class="modal-footer justify-content-center mt-5 p-0">
                                    <button type="button" class="btn btn-warning mx-3" data-bs-dismiss="modal">إغلاق</button>
                                  </div>
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
