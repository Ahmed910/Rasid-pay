function archiveItem(itemId, route) {
    $("#modal_archive").modal('show');
    $('#item').attr('item-id', itemId);
    $('#item').attr('action', route);
}


function notArchiveItem() {
    $("#modal_not_archive").modal('show');
}
