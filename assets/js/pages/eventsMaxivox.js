/**
 * Created by iurik on 5/29/15.
 */
$(document).ready(function() {
    /* ---------- Choosen ---------- */
    $('[data-rel="chosen"],[rel="chosen"]').chosen();

    $('#EventsMaxivoxManage_id_building_chosen').change(function(){
       // $('[data-rel="chosen"],[rel="chosen"]').chosen();
    });
});

function clearAfterChangeDevice(vv) {
    $('#EventsMaxivoxManage_event_type').val("");
    $('#EventsMaxivoxManage_event_type').change();
    $.ajax({
        url: '/admin/eventsMaxivox/devInfoAreaPath/id/'+$(vv).val(),                   //
        type: "POST",
        datatype: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            var json = jQuery.parseJSON(dd);
            //alert(json.comon_area+ ' - ' + json.id_patient)
            if (json.comon_area == 1) {
                $("#EventsMaxivoxManage_event_type option[value='custom']").remove();
            } else {
                if ($("#EventsMaxivoxManage_event_type option[value='custom']").length == 0)
                    $("#EventsMaxivoxManage_event_type").append("<option value='custom'>Custom (Specific)</option>");
            }
            if (json.comon_area == 0 && json.id_patient == null){
                $("#EventsMaxivoxManage_event_type option[value='custom']").remove();
            } else if (json.comon_area == 0 && json.id_patient > 0 && json.emergency == 1) {
                if ($("#EventsMaxivoxManage_event_type option[value='custom']").length == 0)
                    $("#EventsMaxivoxManage_event_type").append("<option value='custom'>Custom (Specific)</option>");
            } else if (json.comon_area == 0 && json.id_patient > 0 && json.emergency == null) {
                $("#EventsMaxivoxManage_event_type option[value='custom']").remove();
            }
        }
    });
}

function populateAfterPickEventSelect(vv){
    $.ajax({
        url: '/admin/eventsMaxivox/generateAfterPickEvent',                   //
        timeout: 30000,
        type: "POST",
        data: 'EventsMaxivoxManage[event_type]='+$(vv).val()+'&genFirstTime=1&id_device='+$('#EventsMaxivoxManage_id_device').val(),
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(data){
            //Do stuff here on success such as modal info
            //$( this ).dialog( "close" );
            $('#contentEvent').html(data);
            if (typeof($('#id_global_event_tmp').attr('tochange')) != 'undefined'){
                $('#EventsMaxivoxManage_global_event').val($('#id_global_event_tmp').attr('tochange'));
            }
            if (typeof($('#id_maxivox_type_tmp').attr('tochange')) != 'undefined'){
                $('#EventsMaxivoxManage_calls_type').val($('#id_maxivox_type_tmp').attr('tochange'));
            }

            $(".noTransfer option[value='TRANSFER']").each(function() {
                $(this).remove();
            });

        }
    });
    if ($(vv).val() == 'custom') {
        $('#eventAdditionalSettings').show();
        $('#EventsMaxivoxManage_auto_close').change(
            function(){
                changeAutoClose(this);
            }
        );
        changeAutoClose($('#EventsMaxivoxManage_auto_close'));
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
function addEventReceiver(){
    $.ajax({
        url: '/admin/eventsMaxivox/getNewEmergencyContact',             // ????????? URL ?
        type: "POST",
        //data: 'pick_event_type='+$('#GlobalEventTemplate_pick_event_type').val()+'&emptyDiv=yes',                     // ??? ??????????? ??????
        success: function (data) { // ?????? ???? ?????????? ?? ??????? success
            $("#receiverContent").append(data);
            $(".noTransfer option[value='TRANSFER']").each(function() {
                $(this).remove();
            });
        }
    });
}
function populateEmergencyContact(vv, idComponent) {
    $.ajax({
        url: '/admin/eventsMaxivox/getEmergencyContactList',                   //
        timeout: 30000,
        type: "POST",
        data: 'EventsMaxivoxManage[event_type]='+$(vv).val()+'&id_device='+$('#EventsMaxivoxManage_id_maxivox_device').val(),
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(data){
            //Do stuff here on success such as modal info
            //$( this ).dialog( "close" );
            $('#EventsMaxivoxManage_id_emergency_contact_'+idComponent).unbind('change').attr('class', 'form-control');
            $('#EventsMaxivoxManage_id_emergency_contact_'+idComponent).html(data);
            if($(vv).val()=='IOPOS') {
                $('#EventsMaxivoxManage_id_emergency_contact_'+idComponent).change(receiverAction(idComponent)).attr('class', 'form-control EventsMaxivoxManage_receiver');
            }
        }
    });
}
var generateOneTimeUpdate = 0;

function populateAfterPickEventSelectUpdate(vv){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    $.ajax({
        url: '/admin/eventsMaxivox/generateAfterPickEvent',                   //
        timeout: 30000,
        type: "POST",
        data: 'EventsMaxivoxManage[event_type]='+$(vv).val()+'&genFirstTime='+generateOneTimeUpdate+'&id_event='+$('#id_event').val()+'&id_device='+$('#EventsMaxivoxManage_id_maxivox_device').val(),
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            //Do stuff here on success such as modal info
            //$( this ).dialog( "close" );
            $('#contentEvent').html(dd);
            if (typeof($('#id_global_event_tmp').attr('tochange')) != 'undefined'){
                $('#EventsMaxivoxManage_global_event').val($('#id_global_event_tmp').attr('tochange'));
            }
            if (typeof($('#id_call_type_tmp').attr('tochange')) != 'undefined'){
                $('#EventsMaxivoxManage_maxivox_type').val($('#id_maxivox_type_tmp').attr('tochange'));
            }
            generateOneTimeUpdate++;
        }
    });
    if ($(vv).val() == 'custom') {
        $('#eventAdditionalSettings').show();
        $('#EventsMaxivoxManage_auto_close').change(
            function(){
                changeAutoClose(this);
            }
        );
        changeAutoClose($('#EventsMaxivoxManage_auto_close'));
    } else {
        $('#eventAdditionalSettings').hide();
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function delEventReceiver (vv) {
    $('#'+vv).remove();
}

function receiverAction(idComponent){
    var pickEvent = $('#EventsManage_id_emergency_contact_'+idComponent).val();
    console.log(pickEvent+" - "+idComponent);
    var parrentDiv = $('#td_'+idComponent);
    $.ajax({
        url: '/admin/eventsMaxivox/commandList',             // указываем URL и
        type: "POST",
        data:{'randomNumber':idComponent},
        success: function (dd) { // вешаем свой обработчик на функцию success
            //parrentDiv.find('div.commandList').remove();
            parrentDiv.append(dd);
        }
    });
}