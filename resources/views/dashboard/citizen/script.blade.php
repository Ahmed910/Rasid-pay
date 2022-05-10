<!-- SELECT2 JS -->
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
    $(function () {
$("#orderTable").DataTable({
sDom: "t<'domOption'lpi>",
  pageLength: 10,
  lengthMenu: [
  [1, 5, 10, 20, -1],
  [1, 5, 10, 20, "الكل"],
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
      /******* Calendar *******/
      $("#from-hijri-picker-custom, #to-hijri-picker-custom, #from-hijri-picker-card ,#to-hijri-picker-card")
        .hijriDatePicker({
          hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
          showSwitcher: false,
          format: "YYYY-MM-DD",
          hijriFormat: "iYYYY-iMM-iDD",
          hijriDayViewHeaderFormat: "iMMMM iYYYY",
          dayViewHeaderFormat: "MMMM YYYY",
          ignoreReadonly: true,
        }).on('dp.change', function () {
        table.draw();
      });
      $("#citizen-search").submit(function (e) {
        e.preventDefault();
        table.draw();
      });
      $("#citizen-search").on('reset', function (e) {
        e.preventDefault();
        $('#status').val(null).trigger('change');
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        table.draw();
      });

      var table = $("#citizenTable").DataTable({
        sDom: "t<'domOption'lpi>",
        serverSide: true,
        processing: true,
        ajax: {
          url: "{{ route('dashboard.citizen.index') }}",
          data:
            function (data) {
              if ($('#citizenName').val() !== '' && $('#citizenName').val() !== null) data.fullname = $('#citizenName').val();
              if ($('#idNumber').val() !== '' && $('#idNumber').val() !== null) data.identity_number = $('#idNumber').val();
              if ($('#phone').val() !== '' && $('#phone').val() !== null) data.phone = $('#phone').val();
              if ($('#from-hijri-picker-custom').val() !== '' && $('#from-hijri-picker-custom').val() !== null) data.created_from = $('#from-hijri-picker-custom').val();
              if ($('#to-hijri-picker-custom').val() !== '' && $('#to-hijri-picker-custom').val() !== null) data.created_to = $('#to-hijri-picker-custom').val(); 
              if ($('#from-hijri-picker-card').val() !== '' && $('#from-hijri-picker-card').val() !== null) data.end_at_from = $('#from-hijri-picker-card').val();
              if ($('#to-hijri-picker-card').val() !== '' && $('#to-hijri-picker-card').val() !== null) data.end_at_to = $('#to-hijri-picker-card').val();
            },
          type: "GET",
          dataSrc: 'data',
        },

        columns: [{
          data: function (data, type, full, meta) {
            return meta.row + 1;
          },
          name: 'id',
          class: 'citizen_index'
        },
          {
            data: "fullname",
            name: 'fullname'
          },
          {
            data: 'identity_number',
            name: 'identity_number'
          },
          {
            data: 'phone',
            name: 'phone'
          },
          {
            data: 'enabled_card',
            name: 'enabled_card'
          },
          {
            data: 'card_end_at',
            name: 'card_end_at'
          },

          {
            data: "created_at",
            name: 'created_at'
          },
     

          {
            class: "text-center",
            data: function (data) {
              return `
              <a href="#"
              onclick=updatePhone('${data.id}','${data.update_route}','${'#citizenTable'}')
              class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" 
                                title="@lang('dashboard.general.edit')"><i class="mdi mdi-square-edit-outline" data-bs-toggle="modal"
                                data-bs-target="#modal_phone"></i></a>`
            },
            orderable: false,
            searchable: false
          }
        ],

        pageLength: 10,
        lengthMenu: [
          [1, 5, 10, 15, 20],
          [1, 5, 10, 15, 20]
        ],

        "language": {
          "lengthMenu": "@lang('dashboard.general.show') _MENU_",
          "emptyTable": "@lang('dashboard.datatable.no_data')",
          "info": "@lang('dashboard.datatable.showing') _START_ @lang('dashboard.datatable.to') _END_ @lang('dashboard.datatable.from') _TOTAL_ @lang('dashboard.datatable.entries')",
          "infoEmpty": "",
          "paginate": {
            "next": '<i class="mdi mdi-chevron-left"></i>',
            "previous": '<i class="mdi mdi-chevron-right"></i>'
          },
        },
        "drawCallback": function (settings, json) {
          // table sorting
          var citizenTableSorting = document.getElementsByClassName('citizen_index');
          for (var i = 0; i < citizenTableSorting.length; i++) {
            citizenTableSorting[i].innerText = citizenTableSorting[i].innerText.replace(
              citizenTableSorting[i].innerText, citizenTableSorting[i].innerText
                .toArabicUni());
          }
          //pagination
          var citizenTablePagination = document.getElementsByClassName('page-link');
          for (var i = 1; i < citizenTablePagination.length - 1; i++) {
            citizenTablePagination[i].innerText = citizenTablePagination[i].innerText.replace(
              citizenTablePagination[i].innerText, citizenTablePagination[i].innerText
                .toArabicUni());
          }
          // info
          var citizenTableInfo = document.getElementById('citizenTable_info').innerText;
          document.getElementById('citizenTable_info').innerText = citizenTableInfo.replace(
            citizenTableInfo, citizenTableInfo.toArabicUni());
        }
      });


      $("#status").change(function () {
        if (this.value == 'temporary') {
          $(".temporary").show();
        } else {
          $(".temporary").hide();
          $('#from-hijri-picker-card').val(null);
          $('#to-hijri-picker-card').val(null);
        }
        table.draw();
      }).change();

  

      $("#idNumber,#citizenName").keyup(function () {
        table.draw();
      });


      $('#citizen-search').on('reset', function (e) {
        e.preventDefault();
        $('#phone,#citizenName').val(null);
        $('#from-hijri-picker-custom').val("").trigger('change');
        $('#to-hijri-picker-custom').val("").trigger('change');
        $('#from-hijri-picker-card').val("").trigger('change');
        $('#to-hijri-picker-card').val("").trigger('change');
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

      $('.select2').select2({
        minimumResultsForSearch: Infinity
      });

      table.on('draw', function () {
        var tooltipTriggerList = [].slice.call(
          document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
      });

    });
  </script>
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
