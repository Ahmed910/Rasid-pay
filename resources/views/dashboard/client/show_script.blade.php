@section('datatable_script')
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/js/table-data.js') }}"></script>


@section('scripts')
  <script>
    $(function () {
      function format(d) {
      // `d` is the original data object for the row

      return '<table width="100%">' +
        '<tr>'+
        '<td></td>'+
        '<td colspan="0">' +'<label>البريد الالكتروني</label>'+
        '<p>test@test.com</p>'+
        '</td>'+
        '<td >' +'<label>العنوان</label>'+
        '<p>address</p>'+
        '</td>'+
        '<td >' +'<label>النوع</label>'+
        '<p>male</p>'+
        '</td>'+
        '<td >' +'<label>الحالة الاجتماعية</label>'+
        '<p>single</p>'+
        '</td>'+
        '<td >' +'<label>الجنسية</label>'+
        '<p>مصري</p>'+
        '</td>'+
        '<td></td>'+
        '</tr>'+
        '</table>';
      // return '<table width="100%">' +
      //   '<tr>'+
      //   '<td>' +'<label>البريد الالكتروني</label>'+
      //   '<p>test@test.com</p>'+
      //   '</td>'+
      //   '</tr>'+
      //   '<tr>'+
      //   '<td >' +'<label>العنوان</label>'+
      //   '<p>address</p>'+
      //   '</td>'+
      //   '</tr>'+
      //   '<tr>'+
      //   '<td >' +'<label>النوع</label>'+
      //   '<p>male</p>'+
      //   '</td>'+
      //   '</tr>'+
      //   '<tr>'+
      //   '<td >' +'<label>الحالة الاجتماعية</label>'+
      //   '<p>single</p>'+
      //   '</td>'+
      //   '</tr>'+
      //   '<tr>'+
      //   '<td >' +'<label>الجنسية</label>'+
      //   '<p>مصري</p>'+
      //   '</td>'+
      //   '</tr>'+
      //   '</table>';

    }

    var table = $('#collapsedTable').DataTable({
      responsive: true,
            sDom: "t<'domOption'lpi>",
        pageLength: 10,
        lengthMenu: [
          [1,5, 10, 20, -1],
          [1,5, 10, 20, "الكل"],
        ],
        language: {
          @include('dashboard.layouts.globals.datatable.datatable_translation')
        },
      // createdRow: function (row, data, dataIndex) {
      //   if (data[0] == "1") {
      //     $('td:eq(0)', row).attr('colspan', 0);
      //     this.api().cell($('td:eq(0)', row))
      //   }
      // }
    });
    // Add event listener for opening and closing details

    $('#collapsedTable tbody').on('click', 'td:last-child', function () {
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it.
        row.child.hide();
        tr.removeClass('shown');
      } else {
        // Open row.
        row.child(format(row.data())).show();
        tr.addClass('shown');
      }
    });
    });
  </script>
@endsection
@endsection
