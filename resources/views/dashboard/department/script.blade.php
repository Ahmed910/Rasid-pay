<script>
    $(function() {
      $("#departmentTable").DataTable({
            sDom: "t<'domOption'lpi>",
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.departments.index') }}?" + $.param(
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
                    ><i
                      data-bs-toggle="modal"
                      data-bs-target="#archiveModal"
                      class="mdi mdi-archive-arrow-down-outline"
                    ></i
                  ></a>`
                    }
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
