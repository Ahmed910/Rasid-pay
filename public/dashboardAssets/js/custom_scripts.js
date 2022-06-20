
let datatableId ;
function archiveItem(itemId, route,tableId) {
    $("#modal_archive").modal('show');
    $('#item').attr('item-id', itemId);
    $('#item').attr('action', route);
    datatableId =tableId
}

function notArchiveItem(message = null) {
    $("#modal_not_archive").modal('show');
    $("#modal_not_archive #message").text(message);
}

function ForceDeleteItem(itemId, route,tableId) {
    $("#modal_force_delete").modal('show');
    $('#item').attr('item-id', itemId);
    $('#item').attr('action', route);
    datatableId =tableId

    // $("#modal_not_archive #message").text(message);
}

function unArchiveItem(itemId, route,tableId) {
    $("#modal_un_archive").modal('show');
    $('#items').attr('item-id', itemId);
    $('#items').attr('action', route);
    datatableId =tableId
    // $("#modal_not_archive #message").text(message);
}

function updatePhone(itemId, route,tableId,value) {
    $("#modal_phone").modal('show');
    $('#item').attr('item-id', itemId);
    $('#phone_value').attr('value', value);
    $('#item').attr('action', route);
    datatableId =tableId
}





$(function(){

    //close FormButton
    $(".closeBtn").on('click',function(){
        $('.reasonAction').val('').removeClass('is-invalid');
        $('.is-invalid').hide();
    });


    //validated Form
    $(".validForm").each(function(index,form)
    {
        $(form).validate({
            onfocusout: function(element) {$(element).valid()},

            rules: {
                reasonAction: {
                    required: true,
                    rangelength:[10,1000]
                },
            },
            messages: {
                reasonAction: {
                  required: ' السبب مطلوب',
                  rangelength: 'يجب ان يكون حقل السبب 10 حروف او اكثر '
                },
              },
            errorClass: "is-invalid",

            submitHandler: function (form) {
                var formData = $(form).serialize();
                action = $(form).attr('action');
                method = $(form).attr('method');

                $.ajax({
                    url:action,
                    type: method,
                    data: formData,

                    success: function (data) {
                        $(form).closest('.modal').modal('hide');
                        toastr.success(data.message);
                        $('.reasonAction').val('');
                        $(datatableId).DataTable().ajax.reload();
                    },
                    error: function(data) {
                        $('#alertReasonAction').text(data.responseJSON.errors.reasonAction);
                    }
                });
            }
        });
    });




});

function insertUrlParam(key, value,remove=false) {
    if (history.pushState) {
      let searchParams = new URLSearchParams(window.location.search);
    if(remove) value = "" ; searchParams.set(key, value);
      let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
      window.history.pushState({path: newurl}, '', newurl);
    }
}



$("#from-hijri-picker-custom").on('dp.change', function (event) {
    insertUrlParam('created_from', $('#from-hijri-picker-custom').val());
});

$("#to-hijri-picker-custom").on('dp.change', function (event) {
    insertUrlParam('created_to', $('#to-hijri-picker-custom').val());
});

$('.exportBtn').on('click',function(){
    ul = $(this).next('ul');
    $(ul).children().each(function(index,item){
        url = $(item).find("a").attr("href").split('?')[0];
        $(item).find('a').attr('href', url + window.location.search);
    });
});


if (performance.navigation.type == 1) {
    let uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        let clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
        $('#search-form input').val('');
        $('#search-form select').val('');
    }

}

