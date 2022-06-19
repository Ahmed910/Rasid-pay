$(function(e) {
    'use strict'

    // Select2

    $('.select2').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
        language: { noResults: () => "لاتوجد نتائج متاحة"}
    })
    // Select2 by showing the search
    $('.select2-show-search').select2({
        minimumResultsForSearch: '',
        width: '100%',
        language: { noResults: () => "لاتوجد نتائج متاحة"}
    }).on("select2:closing", function(e) {
        validateData(this)
      });
    $('.select2').on('click', () => {
        let selectField = document.querySelectorAll('.select2-search__field')
        selectField.forEach((element, index) => {
            element.focus();
        })
    });
});
