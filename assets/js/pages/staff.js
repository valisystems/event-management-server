/**
 * Created by iurik on 2/25/16.
 */
$(document).ready($(function () {
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px");

    $('#staffTab').tab();

    getStaffTable();

    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
    $('.datepicker').datepicker();
    $('.cleditor').cleditor();
}));

function getStaffTable() {
    var urlAction = "/admin/staff/informations";
    var rooms = $('#resultStaff').dataTable({
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
            },
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
    $('#resultStaff').removeClass('display').addClass('table table-striped table-bordered');
    $(".popover").css("max-width", "750px");
}

/**
 * Notes
 */
function addNotes(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var url = '/admin/staff/addNotes';
    $.get(url, function(r){
        $("#addNotes").html(r).dialog("open");
        $('.notesEditor').cleditor();
        $('#StaffNotes_id_staff').val($("#needInfo").attr('id_staff'));
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}

function addInsertNotes(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var url = '/admin/staff/addInsertUpdateNotes';
    $.get(url, function(r){
        //$("#addNotes").html(r).dialog("open");
        $('#divNotes').append(r);
        $('.cleditor').cleditor();
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}

function addNoteToDb(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var dataForm = $('#staff-form').serialize();
    var urlAction = $('#staff-form').attr('action');

    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            //Do stuff here on success such as modal info
            //$( this ).dialog( "close" );
            if (dd.status == 'success') {
                $('#addNotes').dialog('close');
                var url = "/admin/staff/manageNotes/id/"+dd.id_staff;
                $.get(url, function(r){
                    $("#manageNotes").html(r);
                    $("[data-toggle='popover']").popover(
                        {
                            html:true,
                            trigger:"hover"
                        }
                    );
                    $(".popover").css("max-width", "350px");
                });
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function manageNotes(vv) {
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var url = $(vv).attr('url');
    $.get(url, function(r){
        $("#manageNotes").html(r).dialog("open");
        $("[data-toggle='popover']").popover(
            {
                html:true,
                trigger:"hover"
            }
        );
        var urlAux = url.split('/');
        $("#needInfo").attr('id_staff',urlAux[urlAux.length -1]);
        $(".popover").css("max-width", "350px");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}
function updateNotes(id_note_staff){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var url = "/admin/staff/updateNotes/id/"+id_note_staff;
    $.get(url, function(r){
        $("#editNotes").html(r).dialog("open");
        $('.notesEditor').cleditor();
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function deleteNotes(id_note_staff, id_staff, delMsg) {
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    if (confirm(delMsg)) {
        var url = '/admin/staff/deleteNotes/id/'+id_note_staff;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(dd){
                if (dd.status == 'success') {
                    var url = "/admin/staff/manageNotes/id/"+id_staff;
                    $.get(url, function(r){
                        $("#manageNotes").html(r);
                        $("[data-toggle='popover']").popover(
                            {
                                html:true,
                                trigger:"hover"
                            }
                        );
                        $(".popover").css("max-width", "350px");
                    });
                }
            }
        });
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function editNotes(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var dataForm = $('#staff-form').serialize();
    var urlAction = $('#staff-form').attr('action');

    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            //Do stuff here on success such as modal info
            //$( this ).dialog( "close" );
            if (dd.status == 'success') {
                $('#editNotes').dialog('close');
                var url = "/admin/staff/manageNotes/id/"+dd.id_staff;
                $.get(url, function(r){
                    $("#manageNotes").html(r);
                    $("[data-toggle='popover']").popover(
                        {
                            html:true,
                            trigger:"hover",
                        }
                    );
                    $(".popover").css("max-width", "350px");
                });
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
/**
 * Notes END
 */