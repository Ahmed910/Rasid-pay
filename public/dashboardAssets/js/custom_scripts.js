function archiveItem(itemId, route) {
    $("#modal_archive").modal('show');
    $('#item').attr('item-id', itemId);
    $('#item').attr('action', route);
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
        $(".archieveForm").on('submit',function(event){
                event.preventDefault();
                action = $(this).attr('action');
                method = $(this).attr('method');
                
                $.ajax({
                    url:action,
                    type: method,
                    data : $(this).serialize(),

                    success: function (data) {
                        $('#modal_archive').modal('hide');
                        toastr.success(data.message);
                        $('#departmentTable').DataTable().ajax.reload();

                    },
                    error: function(data) {
                    $('#alertReasonAction').text(data.responseJSON.errors.reasonAction);
                }
            });
        });
});
