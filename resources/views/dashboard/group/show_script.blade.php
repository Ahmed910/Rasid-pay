
@section('datatable_script')
<script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>
@endsection

@section('scripts')
    <script>
        $(function() {

            $("#activityTable").DataTable({
        responsive: true,
                sDom: "t<'domOption'lpi>",
                serverSide: true,

                ajax: {
                    url: "{{ route('dashboard.group.show', $group->id) }}?" + $.param(
                        @json(request()->query())),
                    dataSrc: 'data'
                },

                columns: [{
                  data: function (data, type, full, meta) {
                    return parseInt(meta.row) + parseInt(data.start_from) + 1;
                  },
                  name: 'id',
                  class: 'group_show_index'
                    },
                    {
                        data: "user.fullname",
                        name : 'user_name'
                    },
                    {
                        data: function(data) {
                            if (data.user.department !== null) {
                                return data.user.department.name;
                            } else {
                                return "@lang('dashboard.department.without_parent')";
                            }
                        },
                        name : 'department_name'
                    },
                    {
                        data: "created_at",
                        name : 'created_at'
                    },
                    {
                        data: function(data) {
                          @include('dashboard.layouts.globals.datatable.activity_log_actions')
                        },
                        name : 'action_type'
                    },
                    // {
                    //     data: "reason",
                    //     name : 'reason'
                    // },



                ],
                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 15, 20],
                  [1, 5, 10, 15, 20]
                ],
                  "language": {
                    @include('dashboard.layouts.globals.datatable.datatable_translation')
                },
              {{-- "drawCallback": function (settings, json) {
                // admin history table sorting
                var groupHistoryTableSorting = document.getElementsByClassName('group_show_index');
                for (var i = 0; i < groupHistoryTableSorting.length; i++) {
                  groupHistoryTableSorting[i].innerText = groupHistoryTableSorting[i].innerText.replace(groupHistoryTableSorting[i].innerText, groupHistoryTableSorting[i].innerText.toArabicUni());
                }

                //pagination
                var groupHistoryTablePagination = document.getElementsByClassName('page-link');
                for (var i = 1; i < groupHistoryTablePagination.length - 1; i++) {
                  groupHistoryTablePagination[i].innerText = groupHistoryTablePagination[i].innerText.replace(groupHistoryTablePagination[i].innerText, groupHistoryTablePagination[i].innerText.toArabicUni());
                }

                // admin history table show info
                var groupHistoryTableInfo = document.getElementById('groupTable_info').innerText;
                var groupActivityHistoryTableInfo = document.getElementById('activityTable_info').innerText;
                document.getElementById('groupTable_info').innerText = groupHistoryTableInfo.replace(groupHistoryTableInfo, groupHistoryTableInfo.toArabicUni());
                document.getElementById('activityTable_info').innerText = groupActivityHistoryTableInfo.replace(groupActivityHistoryTableInfo, groupActivityHistoryTableInfo.toArabicUni());
              } --}}
            });

            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
