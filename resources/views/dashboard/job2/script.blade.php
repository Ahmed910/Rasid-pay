
    <script>
        $(document).ready(function() {
            var ajaxUrl = "jobs";
            var data = [
               
                {data: 'name'},
                {data: 'department_id'},
                {data: 'created_at'},
                {data: 'is_active'},
                {data: 'is_vacant'},
                {data: 'actions'},
            ];

            _DataTableHandler(ajaxUrl,data);
        });
    </script>

