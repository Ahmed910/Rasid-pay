@section('scripts')
    <!-- SELECT2 JS -->
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>


    <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>

    <script>
        $(function() {

            $("#historyTable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                ajax: {
                    url: "{{ route('dashboard.department.show', $department->id) }}?" + $.param(
                        @json(request()->query())),
                    dataSrc: 'data'
                },

                columns: [{
                        data: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: "user.fullname"
                    },
                    {
                        data: function(data) {
                            if (data.user.department !== null) {
                                return data.user.department.name;
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
                            if (data.type == 'created') {
                                return '<span class="badge bg-success-opacity py-2 px-4">انشاء</span>';
                            }
                            if (data.type == 'updated') {
                                return '<span class="badge bg-warning-opacity py-2 px-4">تعديل</span>';
                            }
                            if (data.type == 'destroy') {
                                return '<span class="badge bg-primary-opacity py-2 px-4">أرشفة</span>';
                            }
                            if (data.type == 'restored') {
                                return '<span class="badge bg-success-opacity py-2 px-4">استلاجاع</span>';
                            }
                            if (data.type == 'permanent_delete') {
                                return '<span class="badge bg-success-opacity py-2 px-4">حذف</span>';
                            }
                            if (data.type == 'searched') {
                                return '<span class="badge bg-success-opacity py-2 px-4">بحث</span>';
                            }
                            if (data.type == 'deactivated') {
                                return '<span class="badge bg-default-opacity py-2 px-4">تعطيل</span>';
                            }
                            if (data.type == 'activated') {
                                return '<span class="badge bg-success-opacity py-2 px-4">تفعيل</span>';
                            }


                        }
                    },
                    {
                        data: "reason",
                    },



                ],
                pageLength: 10,
                lengthMenu: [
                    [ 1,5, 10, 20, -1],
                    [ 1,5, 10, 20, "الكل"],
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

            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@endsection
