/**
 * Created by iurik on 4/20/16.
 */
$(document).ready($(function () {
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px");

    $('#vodiaTable').dataTable({
        "paging": true,
        "ordering": true,
        "hover": true,
        "info": false,
        "processing": true,
        "serverSide": false,
        "stateSave": true,
        "filter": true,
        "destroy": true
        //"dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#vodiaTable').removeClass('display').addClass('table table-striped table-bordered');
    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
}));