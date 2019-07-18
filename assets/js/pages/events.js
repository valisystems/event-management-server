/**
 * Created by iurik on 5/21/15.
 */
$(document).ready(function() {
    /* ---------- Choosen ---------- */
    $('[data-rel="chosen"],[rel="chosen"]').chosen();
});

$(document).ready($(function () {
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px");
    $('#roomsTab').tab();

    $('#EventsManage_id_room').change(function(){
       var url = "/admin/events/devicesList";
        var id_room = $(this).val();
        $.ajax({
            url: url,                   //
            timeout: 30000,
            type: "POST",
            data: 'id_room='+id_room,
            //dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(data){
                //Do stuff here on success such as modal info
                //$( this ).dialog( "close" );
                $('#EventsManage_id_device').html(data);
            }
        });
    });
}));

function clearAfterChangeDevice(vv) {
    $('#EventsManage_event_type').val("");
    $('#EventsManage_event_type').change();
    $.ajax({
        url: '/admin/events/devInfoAreaPath/id/'+$(vv).val(),                   //
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

function populateAfterPickEventSelect(vv){
    $.ajax({
        url: '/admin/events/generateAfterPickEvent',                   //
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

function addEventReceiver(){
    $.ajax({
        url: '/admin/events/getNewEmergencyContact',             // ????????? URL ?
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

function populateEmergencyContact(vv, idComponent) {
    $.ajax({
        url: '/admin/events/getEmergencyContactList',                   //
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
            $('#EventsManage_id_emergency_contact_'+idComponent).unbind('change').attr('class', 'form-control');
            $('#EventsManage_id_emergency_contact_'+idComponent).html(data);
            if($(vv).val()=='IOPOS') {
                $('#EventsManage_id_emergency_contact_'+idComponent).change(receiverAction(idComponent)).attr('class', 'form-control EventsManage_receiver');
            }
        }
    });
}
function changeAutoClose(vv){
    if ($(vv).val() ==  'Y') {
        $('#divAutoCloseTime').show();
    } else {
        $('#divAutoCloseTime').hide();
    }
}
var generateOneTimeUpdate = 0;

function populateAfterPickEventSelectUpdate(vv){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    $.ajax({
        url: '/admin/events/generateAfterPickEvent',                   //
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
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function receiverAction(idComponent){
    var pickEvent = $('#EventsManage_id_emergency_contact_'+idComponent).val();
    var parrentDiv = $('#td_'+idComponent);
    $.ajax({
        url: '/admin/events/commandList',             // указываем URL и
        type: "POST",
        data:{'randomNumber':idComponent},
        success: function (dd) { // вешаем свой обработчик на функцию success
            //parrentDiv.find('div.commandList').remove();
            parrentDiv.append(dd);
        }
    });
}