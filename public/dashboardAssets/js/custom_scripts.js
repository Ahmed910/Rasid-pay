
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
                  required: 'حقل السبب مطلوب',
                  rangelength: 'يجب ان يكون حقل السبب 10 حروفا او اكثر '
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
