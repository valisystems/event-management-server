$(document).ready($(function () { 
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px");
    //$('input[name="Rooms[nb_room]"]').val('test');
    /*$('input[name="Rooms[nb_room]"]').keydown(function( event ) {alert(event)});*/
    $('#nb_room').autocomplete({
        'minLength':'2',
            'source':'/admin/rooms/autocomplete',
            'delay': 300,
            'showAnim':'fold',
            'focus':"js: function() { return false;}"
    });
    $('#nb_room').attr('autocomplete', 'off');
    //console.log($('#Rooms_nb_room').data("events"));
    $('#Rooms_nb_room').blur(function(){
        verifyIfRoomIsUnique();
    });
    $('#roomsTab').tab();

    getRoomsTable();

    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
}));

function addEvents(){
    var idRoom = $('#need_room').attr('id_room');
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var url = "/admin/rooms/addEventsRoom/id/"+idRoom;
    $.get(url, function(r){
        $("#addRoomEvents").html(r).dialog("open");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function saveEvents(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#rooms-event-form').serialize();
    var urlAction = $('#rooms-event-form').attr('action');
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
                $('#addRoomEvents').dialog('close');
                var url = "/admin/rooms/roomEvent/id/"+dd.id_room;
                $.get(url, function(r){
                    var divIdRoom = '<div id="need_room" id_room="'+dd.id_room+'"></div>'
                     $("#roomEvents").html(divIdRoom+r).dialog("open");
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
var generateOneTimeUpdate = 0;
function populateAfterPickEventSelect(vv){
    $.ajax({
            url: '/admin/rooms/generateAfterPickEvent',                   //
            timeout: 30000,
            type: "POST",
            data: 'EventsManage[event_type]='+$(vv).val()+'&genFirstTime=1&id_device='+$('#EventsManage_id_device').val(),
            //dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(data){                                                        
                 //Do stuff here on success such as modal info      
                     //$( this ).dialog( "close" );
                $('#contentEvent').html(data);
                if (typeof($('#id_global_event_tmp').attr('tochange')) != 'undefined'){
                    $('#EventsManage_global_event').val($('#id_global_event_tmp').attr('tochange'));
                }
                if (typeof($('#id_call_type_tmp').attr('tochange')) != 'undefined'){
                    $('#EventsManage_calls_type').val($('#id_call_type_tmp').attr('tochange'));
                }

            }
    });
    if ($(vv).val() == 'custom') {
        $('#eventAdditionalSettings').show();
        $('#EventsManage_auto_close').change(
            function(){
                changeAutoClose(this);
            }
        );
        changeAutoClose($('#EventsManage_auto_close'));
    } else {
        $('#eventAdditionalSettings').hide();
    }
}
function changeAutoClose(vv){
    if ($(vv).val() ==  'Y') {
        $('#divAutoCloseTime').show();
    } else {
        $('#divAutoCloseTime').hide();
    }
}
function populateAfterPickEventSelectUpdate(vv){
    $.ajax({
            url: '/admin/rooms/generateAfterPickEvent',                   //
            timeout: 30000,
            type: "POST",
            data: 'EventsManage[event_type]='+$(vv).val()+'&genFirstTime='+generateOneTimeUpdate+'&id_event='+$('#id_event').val()+'&id_device='+$('#EventsManage_id_device').val(),
            //dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(dd){                                                        
                 //Do stuff here on success such as modal info      
                     //$( this ).dialog( "close" );
                $('#contentEvent').html(dd);
                if (typeof($('#id_global_event_tmp').attr('tochange')) != 'undefined'){
                    $('#EventsManage_global_event').val($('#id_global_event_tmp').attr('tochange'));
                }
                if (typeof($('#id_call_type_tmp').attr('tochange')) != 'undefined'){
                    $('#EventsManage_calls_type').val($('#id_call_type_tmp').attr('tochange'));
                }
                generateOneTimeUpdate++;
            }
    });
    if ($(vv).val() == 'custom') {
        $('#eventAdditionalSettings').show();
        $('#EventsManage_auto_close').change(
            function(){
                changeAutoClose(this);
            }
        );
        changeAutoClose($('#EventsManage_auto_close'));
    } else {
        $('#eventAdditionalSettings').hide();
    }
}

function populateEmergencyContact(vv, idComponent) {
    $.ajax({
            url: '/admin/rooms/getEmergencyContactList',                   //
            timeout: 30000,
            type: "POST",
            data: 'EventsManage[event_type]='+$(vv).val()+'&id_device='+$('#EventsManage_id_device').val(),
            //dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(data){                                                        
                 //Do stuff here on success such as modal info      
                     //$( this ).dialog( "close" );
                $('#EventsManage_id_emergency_contact_'+idComponent).html(data);
            }
    });
}

function openUpdateEventsForm(id_event, id_room){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var url = "/admin/rooms/updateEventsRoom/id/"+id_event+"/id_room/"+id_room;
    $.get(url, function(r){
        $("#editRoomEvents").html(r).dialog("open");
        $('#EventsManage_event_type').attr('onchange','populateAfterPickEventSelectUpdate(this)');
        $('#EventsManage_event_type').change();
        clearUpdateFormDevice($('#EventsManage_id_device'));
        //$('#EventsManage_event_type').change();
        changeAutoClose($('#EventsManage_auto_close'));
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function updateEvents(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#rooms-event-form').serialize();
    var urlAction = $('#rooms-event-form').attr('action');
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
                //console.log(dd)
                $('#editRoomEvents').dialog('close');
                var url = "/admin/rooms/roomEvent/id/"+dd.id_room;
                $.get(url, function(r){
                    var divIdRoom = '<div id="need_room" id_room="'+dd.id_room+'"></div>'
                     $("#roomEvents").html(divIdRoom+r).dialog("open");
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
function deleteEvent(id_event, id_room, msgDelete) {
    if (confirm(msgDelete)){
        $("#ajax_loader").ajaxStart(function(){
            $(this).show();
        }); 
        $.ajax({
            url: '/admin/rooms/deleteEvents/id/'+id_event,                   //
            type: "POST",
            datatype: 'json',
            //dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(dd){                                                        
                 //Do stuff here on success such as modal info      
                 //$( this ).dialog( "close" );
                 if (dd.status == 'success') {
                    var url = "/admin/rooms/roomEvent/id/"+id_room;
                    $.get(url, function(r){
                        var divIdRoom = '<div id="need_room" id_room="'+id_room+'"></div>'
                         $("#roomEvents").html(divIdRoom+r).dialog("open");
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
}

function addEventReceiver(){
    $.ajax({
        url: '/admin/rooms/getNewEmergencyContact',             // ????????? URL ?
        type: "POST",
        //data: 'pick_event_type='+$('#GlobalEventTemplate_pick_event_type').val()+'&emptyDiv=yes',                     // ??? ??????????? ??????
        success: function (data) { // ?????? ???? ?????????? ?? ??????? success
            $("#receiverContent").append(data);
        }
    });
}
function delEventReceiver (vv) {
    $('#'+vv).remove();
}

function clearAfterChangeDevice(vv) {
    $('#EventsManage_event_type').val("");
    $('#EventsManage_event_type').change();
    $.ajax({
        url: '/admin/rooms/devInfoAreaPath/id/'+$(vv).val(),                   //
        type: "POST",
        datatype: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){  
            var json = jQuery.parseJSON(dd);
            //alert(json.comon_area+ ' - ' + json.id_patient)
            if (json.comon_area == 1) {
                $("#EventsManage_event_type option[value='custom']").hide();
            } else {
                $("#EventsManage_event_type option[value='custom']").show();
            }
            if (json.comon_area == 0 && json.id_patient == null){
                $("#EventsManage_event_type option[value='custom']").hide();
            } else if (json.comon_area == 0 && json.id_patient > 0 && json.emergency == 1) {
                $("#EventsManage_event_type option[value='custom']").show();
            } else if (json.comon_area == 0 && json.id_patient > 0 && json.emergency == null) {
                $("#EventsManage_event_type option[value='custom']").hide();
            }
        }
    });
}

function clearUpdateFormDevice(vv) {
    $('#EventsManage_event_type').change();
    $.ajax({
        url: '/admin/rooms/devInfoAreaPath/id/'+$(vv).val(),                   //
        type: "POST",
        datatype: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){  
            var json = jQuery.parseJSON(dd);
            //alert(json.comon_area+ ' - ' + json.id_patient)
            if (json.comon_area == 1) {
                $("#EventsManage_event_type option[value='custom']").hide();
            } else {
                $("#EventsManage_event_type option[value='custom']").show();
            }
            if (json.comon_area == 0 && json.id_patient == null){
                $("#EventsManage_event_type option[value='custom']").hide();
            } else if (json.comon_area == 0 && json.id_patient > 0 && json.emergency == 1) {
                $("#EventsManage_event_type option[value='custom']").show();
            } else if (json.comon_area == 0 && json.id_patient > 0 && json.emergency == null) {
                $("#EventsManage_event_type option[value='custom']").hide();
            }
        }
    });
}
function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}
function reinstallJsFilters(id, data){
    /*$('#Rooms_nb_room').autocomplete({
            'minLength':'2',
            'source':'/admin/rooms/autocomplete',
            'delay': 300,
            'showAnim':'fold',
            'focus':"js: function() { return false;}"
    
    });*/
}

function verifyIfRoomIsUnique(){
    var idBuilding = $('#Rooms_id_building').val();
    var idFloor = $('#Rooms_id_map').val();
    var nbRoom = $('#Rooms_nb_room').val();
    if (nbRoom != "") {
        $.ajax({
            url: '/admin/rooms/verifyRoomNumber',                   //
            type: "POST",
            data: {id_building: idBuilding, id_map: idFloor, id_room:nbRoom},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'exist'){
                    $('#Rooms_nb_room').focus();
                    $('#Rooms_nb_room_em_').show().html('This room number exist');
                    $('#submitRooms').attr('disabled','disabled').attr('class','btn');
                } else {
                    $('#submitRooms').removeAttr('disabled').attr('class','btn btn-primary');;
                }
            }
        });
    }
}

function getRoomsTable() {
    var urlAction = "/admin/rooms/informations";
    var rooms = $('#resultRooms').dataTable({
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
                d.id_building = id_building;
                d.id_map = id_map;
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
    $('#resultRooms').removeClass('display').addClass('table table-striped table-bordered');
    $(".popover").css("max-width", "750px");
}

function manageEvents(vv){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var url = $(vv).attr('url');
    $.get(url, function(r){
        var stArray = url.split("/");
        var idRoom = stArray[stArray.length-1];
        var divIdRoom = '<div id="need_room" id_room="'+idRoom+'"></div>'
        $("#roomEvents").html(divIdRoom+r).dialog("open");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}