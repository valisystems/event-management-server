/**
 * Created by iurik on 11/9/15.
 */
$(document).ready(function(){
    //$('.cleditor').cleditor();
    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
    /*$('body').editable({
        selector: ".custom_edit",
        mode: 'inline'
    });*/
    $(".popover").css("max-width", "750px");
    getCustomLinkTable();

    $('#CustomLinks_target_type').each(function(){
         addAditionalInfo(this);
    })
   
});
var customLocation = "";
function getCustomLocation(){
    $.ajax({
        url: '/admin/customCommands/customLocation',                   //
        type: "POST",
        datatype: 'json',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function (dd) {
            return  JSON.parse(JSON.stringify(dd));
        }
    });
}

function getCustomLinkTable() {
    var urlAction = "/admin/customLinks/informations";
    var rooms = $('#resultCustomLinks').dataTable({
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
            /*"success": function ( json) {
             //Make your callback here.
             $("[data-toggle='popover']").unbind('popover');
             $("[data-toggle='popover']").popover(
             {
             html:true,
             trigger:"hover"
             }
             );
             return json;
             },*/
            "data": function (d) {
            },
            //"success":function(data){
            //    $("[data-toggle='popover']").unbind('popover');
            //    $("[data-toggle='popover']").popover(
            //        {
            //            html:true,
            //            trigger:"hover"
            //        }
            //    );
            //},
            "columns": [
                {"data": "time"},
                {"data": "deviceDesc"},
                {"data": "patient"},
                {"data": "room"},
                {"data": "receiver"},
                {"data": "serialNumber"},
                {"data": "code"},
                {"data": "typeNotif"}
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
    $('#resultCustomLinks').removeClass('display').addClass('table table-striped table-bordered');
    $(".popover").css("max-width", "750px");
}

function addAditionalInfo(vv){
    if($(vv).val() == 'self'){
        $('#additionalForm').show();
    } else {
        $('#additionalForm').hide();
    }
}