/**
 * Created by iurik on 2/25/16.
 */
$(document).ready($(function () {
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px");

    $('#extensionInventoryTab').tab();

    getExtInventoryTable();

    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
    //$('.datepicker').datepicker();
    //$('.cleditor').cleditor();
}));

function getExtInventoryTable() {
    var urlAction = "/admin/extensionInventory/informations";
    var rooms = $('#resultExtensionInventory').dataTable({
        "paging": true,
        "ordering": true,
        "hover": true,
        "info": false,
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        //"filter": false,
        "destroy": true,
        "createdRow": function ( row, data, index ) {

        },
        "ajax": {
            "url": urlAction,
            "type": "POST",
            "datatype": 'json',
            "searching": true,
            "data": function (d) {
                d.id_building = id_building;
                d.id_map = id_map;
            },
            "columns": [
                {"data": "ext_number"},
                {"data": "caller_id_internal"},
                {"data": "caller_id_external"},
                {"data": "caller_id_name"},
                {"data": "action"}
            ]
        }
        //"dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    /*$("[data-toggle='popover']").live("popover",function()
     {
     html:true,
     trigger:"hover"
     }
     );*/
    $('#resultExtensionInventory').removeClass('display').addClass('table table-striped table-bordered');
    $(".popover").css("max-width", "750px");
}

function getSipServer(){
    $.ajax({
        url: '/admin/extensionInventory/sipServer',                   //
        type: "POST",
        data: {id_building: $('#ExtensionInventory_id_building').val()},
        datatype: 'json',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function (dd) {
            $('#ExtensionInventory_id_sip_server').html(dd);
        }
    });
}

