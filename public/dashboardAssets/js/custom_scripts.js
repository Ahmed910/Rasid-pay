function archiveItem(itemId, route) {
    $("#modal_archive").modal('show');
    $('#item').attr('item-id', itemId);
    $('#item').attr('action', route);
}

function notArchiveItem(message = null) {
    $("#modal_not_archive").modal('show');
    $("#modal_not_archive #message").text(message);
}
