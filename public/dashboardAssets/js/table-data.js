$(function(e) {

    $("#historyTable, #groupTable").DataTable({
        responsive: true,
      sDom: "t<'domOption'lpi>",
      pageLength: 10,
      lengthMenu: [
        [1,5, 10, 20],
        [1,5, 10, 20],
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

    $("#table-details").DataTable({
        responsive: true,
      sDom: "t<'domOption'lpi>",
      pageLength: 10,
      lengthMenu: [
        [1, 5, 10, 20, -1],
        [1, 5, 10, 20, "الكل"],
      ],
      responsive: {
        details: {
          type: "column",
          target: -1,
        },
      },
      columnDefs: [
        {
          className: "dtr-control",
          orderable: false,
          targets: -1,
        },
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
    //______Select2
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });

});
