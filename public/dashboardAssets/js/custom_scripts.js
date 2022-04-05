
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

function ForceDeleteItem(itemId, route) {
    $("#modal_force_delete").modal('show');
    $('#item').attr('item-id', itemId);
    $('#item').attr('action', route);
    // $("#modal_not_archive #message").text(message);
}

function unArchiveItem(itemId, route) {
    $("#modal_un_archive").modal('show');
    $('#items').attr('item-id', itemId);
    $('#items').attr('action', route);
    // $("#modal_not_archive #message").text(message);
}
$(function(){

            $(".archieveForm").validate({
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
                submitHandler: function (form) {
                    var formData = $(form).serialize();
                    action = $(form).attr('action');
                    method = $(form).attr('method');

                    $.ajax({
                        url:action,
                        type: method,
                        data: formData,

                        success: function (data) {
                            $('#modal_archive').modal('hide');
                            toastr.success(data.message);
                            $(datatableId).DataTable().ajax.reload();

                        },
                        error: function(data) {
                            $('#alertReasonAction').text(data.responseJSON.errors.reasonAction);
                        }
                    });
                }
            });



});
