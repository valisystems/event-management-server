/**
 * Created by iurik on 6/10/15.
 */
$(document).ready(function(){
    //getNotificationPositioning();
});

function getNotificationPositioning(){
    if (typeof posDeviceId != 'undefined' && posDeviceId.length > 0) {
        refreshLivePanelPositioning();
    }
}
var timerPositioningNotif;
function refreshLivePanelPositioning(){
    var idBuilding = $('#id_building').val();
    var idMap = $('#id_map').val();
    var coordonatesPos = new Array();

    var url = '/livepanel/liveRequest/getLastNotificationPositioning';
    $.ajax({
        url: url,                   //
        timeout: 30000,
        type: "POST",
        data: {'listDevice':posDeviceId},
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
                //alert('Test')
            var notifyInfoPos = new Array();
            var lenNotify = 0;
            for(var key in dd){
                if(dd.hasOwnProperty(key)){
                    if (coordonatesPos.indexOf(dd[key].coordinate_on_map) == -1 && dd[key].coordinate_on_map.length > 0){
                        coordonatesPos[coordonatesPos.length] = dd[key].coordinate_on_map;
                    }
                    notifyInfoPos[lenNotify] = new Array();
                    notifyInfoPos[lenNotify]['id_log'] =  dd[key].id_log;
                    notifyInfoPos[lenNotify]['EventType'] =  dd[key].EventType;
                    notifyInfoPos[lenNotify]['color_hex'] =  dd[key].color_hex;
                    notifyInfoPos[lenNotify]['live_panel'] =  dd[key].live_panel;
                    notifyInfoPos[lenNotify]['require_acknowledge'] =  dd[key].require_acknowledge;
                    notifyInfoPos[lenNotify]['auto_close'] =  dd[key].auto_close;
                    notifyInfoPos[lenNotify]['flashing_toggle'] =  dd[key].flashing_toggle;
                    notifyInfoPos[lenNotify]['auto_close_duration'] =  dd[key].auto_close_duration;
                    notifyInfoPos[lenNotify]['position_popup'] =  dd[key].position_popup;
                    notifyInfoPos[lenNotify]['type_notification'] =  dd[key].type_notification;
                    notifyInfoPos[lenNotify]['receiver'] =  dd[key].receiver;
                    notifyInfoPos[lenNotify]['message_sent'] =  dd[key].message_sent;
                    notifyInfoPos[lenNotify]['response_message'] = dd[key].response_message;
                    notifyInfoPos[lenNotify]['current_time'] =  dd[key].current_time;
                    notifyInfoPos[lenNotify]['status_of_notification'] =  dd[key].status_of_notification;
                    notifyInfoPos[lenNotify]['device_description'] =  dd[key].device_description;
                    notifyInfoPos[lenNotify]['device_type'] =  dd[key].device_type;
                    notifyInfoPos[lenNotify]['comon_area'] =  dd[key].comon_area;
                    notifyInfoPos[lenNotify]['id_device'] =  dd[key].id_device;
                    notifyInfoPos[lenNotify]['id_patient'] =  dd[key].id_patient;
                    notifyInfoPos[lenNotify]['first_name'] =  dd[key].first_name;
                    notifyInfoPos[lenNotify]['last_name'] =  dd[key].last_name;
                    notifyInfoPos[lenNotify]['avatar_path'] =  (typeof(dd[key].avatar_path) != 'null') ? dd[key].avatar_path : "";
                    notifyInfoPos[lenNotify]['afliction'] =  dd[key].afliction;
                    notifyInfoPos[lenNotify]['nb_room'] =  dd[key].nb_room;
                    notifyInfoPos[lenNotify]['dev_coordonate'] =  dd[key].dev_coordonate;
                    notifyInfoPos[lenNotify]['io_name'] =  dd[key].io_name;
                    notifyInfoPos[lenNotify]['command'] =  dd[key].command;
                    //dev_coordonate

                    var coordArray = dd[key].coordinate_on_map.split(',');
                    var coordId = coordArray.join('-');

                    notifyInfoPos[lenNotify]['coordinate_id'] =  coordId;
                    lenNotify = notifyInfoPos.length;
                    //console.log('Nb array =', lenNotify);
                }
            }
            if (notifyInfoPos.length > 0 ){
                GeneratePopUpInfoPos(notifyInfoPos);
            }

        }
    });
    //console.log('idBuilding = ',idBuilding,' idMap = ', idMap);
    timerPositioningNotif = setTimeout(refreshLivePanelPositioning, 5000);
}

function GeneratePopUpInfoPos(notInfoArray){
    var selectedEffect = 'bounce';
    var options = {};
    for(var key in notInfoArray){
        var shortInfo = notInfoArray[key];
        var divInfo = '';
        var divPosition = '';
        var patientName = shortInfo['first_name'] + " " + shortInfo['last_name'];
        if($('#device_pos_'+shortInfo['id_device']).length == 0){
            var id_device = shortInfo['id_device'];

            if (shortInfo['position_popup'] == 'top')
                divPosition ='bottomFlash';
            else if (shortInfo['position_popup'] == 'left')
                divPosition = 'rightFlash';
            else if (shortInfo['position_popup'] == 'bottom')
                divPosition = 'topFlash';
            else if (shortInfo['position_popup'] == 'right')
                divPosition = 'leftFlash';
            else if (shortInfo['position_popup'] == 'topleft')
                divPosition = 'bottomRightFlash';
            else if (shortInfo['position_popup'] == 'topright')
                divPosition = 'bottomLeftFlash';
            else if (shortInfo['position_popup'] == 'bottomleft')
                divPosition = 'topRightFlash';
            else if (shortInfo['position_popup'] == 'bottomright')
                divPosition = 'topLeftFlash';

            divInfo += "<div id='device_pos_"+shortInfo['id_device']+"' class='deviceNotificationPos "+ divPosition +"' style='cursor:pointer;'>";

            /*if (shortInfo['id_patient'] != null && shortInfo['device_type'] != 'camera') {
                divInfo += "<div class='patient_profile'>";
                divInfo += "    <div class='userAvatar'>";
                if (typeof(shortInfo['avatar_path']) != null)
                    divInfo += "<img src='"+shortInfo['avatar_path']+"' border=0 id='avatar_"+shortInfo['id_patient']+"' width='200'/>";
                else
                    divInfo += "<img src='/images/no_avatar.jpg' border=0 id='avatar_"+shortInfo['id_patient']+"' width='200'/>";
                divInfo += "    </div>";
                divInfo += "    <div class='patientInfo'>";
                divInfo += "        <label class='patientName'>";
                divInfo += shortInfo['first_name'] + " " + shortInfo['last_name'];
                divInfo += "        </label>";
                divInfo += "        <label class='patientAfliction'>";
                divInfo += "( " + shortInfo['afliction'] + " )";
                divInfo += "        </label>";
                divInfo += "    </div>";
                divInfo += "</div>";
            } else if (shortInfo['device_type'] == 'camera') {
                divInfo += "<div class='imageCamera' id='imgCamera_"+id_device+"' dev_id='"+id_device+"' camera_id='"+shortInfo['response_message']+"'>";
                divInfo += "<img src='' border='0' width='205' height='100' />";
                divInfo += "";
                divInfo += "</div>";
            }*/

            var color = getRandomColor();
            if (shortInfo['device_type'] == 'camera')
                divInfo += "<div class='notificationsPos cameranotification' id='device_notif_pos_"+shortInfo['id_device']+"'>";
            else
                divInfo += "<div class='notificationsPos' id='device_notif_pos_"+shortInfo['id_device']+"'>";
            divInfo += "    <div class='notification_details' id='div_notification_details_pos_"+shortInfo['id_log']+"' style='background-color:"+shortInfo['color_hex']+";color:"+colorCorespond[shortInfo['color_hex']]+"'>";
            divInfo += "        <div class='toolbar'>";
            divInfo += "            <label class='type_notification'>";
            if (shortInfo['type_notification'] == 'EMAIL')
                divInfo += "<img src='/images/email-alert.png' border=0/>";
            if (shortInfo['type_notification'] == 'SMS')
                divInfo += "<img src='/images/sms.png' border=0/>";
            if (shortInfo['type_notification'] == 'VOIP')
                divInfo += "<img src='/images/telephone.png' border=0/>";
            if (shortInfo['type_notification'] == 'TRANSFER')
                divInfo += "<img src='/images/transfer-call.png' border=0/>";
            if (shortInfo['type_notification'] == 'IOPOS')
                divInfo += "<img src='/images/zones.png' border=0/>";

            divInfo += "            </label>";
            divInfo += "            <label class='time_notification'>";
            divInfo += shortInfo['current_time'];
            divInfo += "            </label>";
            divInfo += "<label class='patient_notification'>";
            divInfo += patientName;
            divInfo += "</label>";
            divInfo += "        </div>";
            divInfo += "        <div class='message_notification'>";
            if (shortInfo['type_notification'] == 'IOPOS')
                divInfo += shortInfo['io_name']+" - "+shortInfo['command'];
            else
                divInfo += shortInfo['receiver'];
            divInfo += "        </div>";
            divInfo += "    </div>";
            divInfo += "</div>";

            divInfo += "<div class='statusBar'>";
            divInfo += "<label class='roomNumber'></label>";
            divInfo += "<label class='currentTime'>currentTime</label>";
            divInfo += "</div>";
            /*
            if (shortInfo['position_popup'] == 'top')
                divInfo += "<div class='bottomFlash'></div>";
            else if (shortInfo['position_popup'] == 'left')
                divInfo += "<div class='rightFlash'></div>";
            else if (shortInfo['position_popup'] == 'bottom')
                divInfo += "<div class='topFlash'></div>";
            else if (shortInfo['position_popup'] == 'right')
                divInfo += "<div class='leftFlash'></div>";
            else if (shortInfo['position_popup'] == 'topleft')
                divInfo += "<div class='bottomRightFlash'>&nbsp;</div>";
            else if (shortInfo['position_popup'] == 'topright')
                divInfo += "<div class='bottomLeftFlash'>&nbsp;</div>";
            else if (shortInfo['position_popup'] == 'bottomleft')
                divInfo += "<div class='topRightFlash'>&nbsp;</div>";
            else if (shortInfo['position_popup'] == 'bottomright')
                divInfo += "<div class='topLeftFlash'>&nbsp;</div>";
                */
            divInfo += "</div>";
            $('#mapsInfo').after(divInfo);
            /**
             * Add method of Autoclose fore notification in popup on extension
             */
            if (shortInfo['auto_close_duration'] > 0 && shortInfo['auto_close'] == 'Y'){
                var timeAfterClose = shortInfo['auto_close_duration']*1000;
                $('#div_notification_details_pos_'+shortInfo['id_log']).delay(timeAfterClose).fadeOut(300);


                //setTimeout(function() { $('#div_notification_details_'+shortInfo['id_log']).remove(); }, timeAfterClose);
            }
            /**
             * End Method of auto close
             */


            changeCurrentTime();
            var devCoordonate = shortInfo['dev_coordonate'].split(';');
            //var str = "<div id='devicePosition_"+shortInfo['id_device']+"' class='btn btn-sm btn-danger draggable ui-widget-content'>"+ shortInfo['ext_number'] +"</div>";
            //$('#mapsInfo').append(str);
            var imgWidth = $('#mapsImages').width();
            var imgHeight = $('#mapsImages').height();

            var mapsParrentPosition = $('#mapsInfo').offset();
            var topPositionD = parseInt(devCoordonate[1])+parseInt(mapsParrentPosition.top);
            var leftPositionD = parseInt(devCoordonate[0])+parseInt(mapsParrentPosition.left);

            if (shortInfo['position_popup'] == 'top')
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD - 79, top: topPositionD - 205});
            else if (shortInfo['position_popup'] == 'left'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD - 223 - 15, top: topPositionD - 96});
            } else if (shortInfo['position_popup'] == 'bottom'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD - 100, top: topPositionD + 45});
            } else if (shortInfo['position_popup'] == 'right'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD + 86, top: topPositionD - 96});
            } else if (shortInfo['position_popup'] == 'topleft'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD - 202, top: topPositionD - 215});
            } else if (shortInfo['position_popup'] == 'topright'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD + 51, top: topPositionD - 213});
            } else if (shortInfo['position_popup'] == 'bottomleft'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD - 209, top: topPositionD + 55});
            } else if (shortInfo['position_popup'] == 'bottomright'){
                $('#device_pos_'+shortInfo['id_device']).offset({left:leftPositionD + 63, top: topPositionD + 55});
            }
            if ( listShortNotification.indexOf(shortInfo['id_log']) == -1) {
                listShortNotification.push(shortInfo['id_log']);
                var divNotification = "<div id='smallNotif_"+shortInfo['id_log']+"'>";
                divNotification += "";
                divNotification += "<div class='toolbarSmallNotif'>";
                divNotification += "<label class='type_notification'>";
                if (shortInfo['type_notification'] == 'EMAIL')
                    divNotification += "<img src='/images/email-alert.png' border=0/>";
                if (shortInfo['type_notification'] == 'SMS')
                    divNotification += "<img src='/images/sms.png' border=0/>";
                if (shortInfo['type_notification'] == 'VOIP')
                    divNotification += "<img src='/images/telephone.png' border=0/>";
                if (shortInfo['type_notification'] == 'TRANSFER')
                    divNotification += "<img src='/images/transfer-call.png' border=0/>";
                if (shortInfo['type_notification'] == 'CAMERA')
                    divNotification += "<img src='/images/transfer-call.png' border=0/>";
                if (shortInfo['type_notification'] == 'IOPOS')
                    divNotification += "<img src='/images/zones.png' border=0/>";
                divNotification += "</label>";
                divNotification += "<label class='time_notification'>";
                divNotification += shortInfo['current_time'];
                divNotification += "</label>";
                divNotification += "</div>";
                divNotification += "<div class='message_notification'>";
                if (shortInfo['type_notification'] == 'IOPOS')
                    divNotification += shortInfo['io_name']+" - "+shortInfo['command'];
                else
                    divNotification += shortInfo['receiver'];
                divNotification += "</div>";
                divNotification += "</div>"

                var classNameNotif = "";
                if (shortInfo['auto_close_duration'] > 0) {
                    if (shortInfo['status_of_notification'] == 1) {
                        classNameNotif = 'next';
                    } else {
                        classNameNotif = 'next error';
                    }
                    $.stickr({
                        note: divNotification,
                        className:classNameNotif,
                        //sticked:true,
                        position:{right:0,bottom:0},
                        time:shortInfo['auto_close_duration']*1000,
                        speed:300

                    });
                } else {
                    if (shortInfo['status_of_notification'] == 1) {
                        classNameNotif = 'classic';
                    } else {
                        classNameNotif = 'classic error';
                    }
                    $.stickr({
                        note: divNotification,
                        position:{right:0,bottom:0},
                        className:classNameNotif,
                        sticked:true,
                        speed:300

                    });
                }
                $('#jquery-stickers').css('z-index', '1000');
            }
            $('.deviceNotificationPos').click(function(){
                changePositionOfMineDivPos(this);
            });
        } else {
            var color = getRandomColor();
            divInfo += "<div class='notification_details' id='div_notification_details_pos_"+shortInfo['id_log']+"' style='background-color:"+shortInfo['color_hex']+";color:"+colorCorespond[shortInfo['color_hex']]+"'>";
            divInfo += "<div class='toolbar'>";
            divInfo += "<label class='type_notification'>";
            if (shortInfo['type_notification'] == 'EMAIL')
                divInfo += "<img src='/images/email-alert.png' border=0/>";
            if (shortInfo['type_notification'] == 'SMS')
                divInfo += "<img src='/images/sms.png' border=0/>";
            if (shortInfo['type_notification'] == 'VOIP')
                divInfo += "<img src='/images/telephone.png' border=0/>";
            if (shortInfo['type_notification'] == 'TRANSFER')
                divInfo += "<img src='/images/transfer-call.png' border=0/>";
            if (shortInfo['type_notification'] == 'CAMERA')
                divInfo += "<img src='/images/transfer-call.png' border=0/>";
            if (shortInfo['type_notification'] == 'IOPOS')
                divInfo += "<img src='/images/zones.png' border=0/>";
            divInfo += "</label>";
            divInfo += "<label class='avatar_notification'>";
            if (typeof(shortInfo['avatar_path']) != null && shortInfo['avatar_path'] != "")
                divInfo += "<img src='"+shortInfo['avatar_path']+"' border=0 id='avatar_"+shortInfo['id_patient']+"' width='30'/>";
            else
                divInfo += "<img src='/images/no_avatar.jpg' border=0 id='avatar_"+shortInfo['id_patient']+"' width='30'/>";
            divInfo += "</label>";
            divInfo += "<label class='time_notification'>";
            divInfo += shortInfo['current_time'];
            divInfo += "</label>";
            divInfo += "<label class='patient_pos_notification'>";
            divInfo += patientName;
            divInfo += "</label>";
            divInfo += "</div>";
            divInfo += "<div class='message_notification'>";
            if (shortInfo['type_notification'] == 'IOPOS')
                divInfo += shortInfo['io_name']+" - "+shortInfo['command'];
            else
                divInfo += shortInfo['receiver'];
            divInfo += "</div>";
            divInfo += "</div>";
            if ($("#div_notification_details_pos_"+shortInfo['id_log']).length == 0 ) {
                $("#device_notif_pos_"+shortInfo['id_device']).prepend(divInfo).show('clip');
                /**
                 * Add method of Autoclose fore notification in popup on extension
                 */
                if (shortInfo['auto_close_duration'] > 0 && shortInfo['auto_close'] == 'Y'){
                    var timeAfterClose = shortInfo['auto_close_duration']*1000;
                    $('#div_notification_details_pos_'+shortInfo['id_log']).delay(timeAfterClose).fadeOut(300);

                    //setTimeout(function() { $('#div_notification_details_'+shortInfo['id_log']).remove(); }, timeAfterClose);
                }
                /**
                 * End Method of auto close
                 */
                if (shortInfo['auto_close'] == 'Y' && shortInfo['auto_close_duration'] > 0) {
                    //$("#device_notif_"+shortInfo['id_device']).fadeOut(shortInfo['auto_close_duration']*1000);
                }
            }

            if ( listShortNotification.indexOf(shortInfo['id_log']) == -1) {
                listShortNotification.push(shortInfo['id_log']);
                var divNotification = "<div id='smallNotif_"+shortInfo['id_log']+"'>";
                divNotification += "";
                divNotification += "<div class='toolbarSmallNotif'>";
                divNotification += "<label class='type_notification'>";
                if (shortInfo['type_notification'] == 'EMAIL')
                    divNotification += "<img src='/images/email-alert.png' border=0/>";
                if (shortInfo['type_notification'] == 'SMS')
                    divNotification += "<img src='/images/sms.png' border=0/>";
                if (shortInfo['type_notification'] == 'VOIP')
                    divNotification += "<img src='/images/telephone.png' border=0/>";
                if (shortInfo['type_notification'] == 'TRANSFER')
                    divNotification += "<img src='/images/transfer-call.png' border=0/>";
                if (shortInfo['type_notification'] == 'CAMERA')
                    divNotification += "<img src='/images/transfer-call.png' border=0/>";
                if (shortInfo['type_notification'] == 'IOPOS')
                    divNotification += "<img src='/images/zones.png' border=0/>";
                divNotification += "</label>";
                divNotification += "<label class='avatar_notification'>";
                if (typeof(shortInfo['avatar_path']) != null && shortInfo['avatar_path'] != "")
                    divNotification += "<img src='"+shortInfo['avatar_path']+"' border=0 id='avatar_"+shortInfo['id_patient']+"' width='30'/>";
                else
                    divNotification += "<img src='/images/no_avatar.jpg' border=0 id='avatar_"+shortInfo['id_patient']+"' width='30'/>";
                divNotification += "</label>";
                divNotification += "<label class='time_notification'>";
                divNotification += shortInfo['current_time'];
                divNotification += "</label>";
                divNotification += "<label class='patient_notification'>";
                divNotification += patientName;
                divNotification += "</label>";
                divNotification += "</div>";
                divNotification += "<div class='message_notification'>";
                if (shortInfo['type_notification'] == 'IOPOS')
                    divNotification += shortInfo['io_name']+" - "+shortInfo['command'];
                else
                    divNotification += shortInfo['receiver'];
                divNotification += "</div>";
                divNotification += "</div>"

                var classNameNotif = "";

                if (shortInfo['auto_close_duration'] > 0) {
                    if (shortInfo['status_of_notification'] == 1) {
                        classNameNotif = 'next';
                    } else {
                        classNameNotif = 'next error';
                    }
                    $.stickr({
                        note: divNotification,
                        className:classNameNotif,
                        //sticked:true,
                        position:{right:0,bottom:0},
                        time:shortInfo['auto_close_duration']*1000,
                        speed:300

                    });
                } else {
                    if (shortInfo['status_of_notification'] == 1) {
                        classNameNotif = 'classic';
                    } else {
                        classNameNotif = 'classic error';
                    }
                    $.stickr({
                        note: divNotification,
                        position:{right:0,bottom:0},
                        className:classNameNotif,
                        sticked:true,
                        speed:300
                    });
                }
            }
            //console.log('suntem aici', shortInfo['id_device']);
        }
        //console.log('id log', notInfoArray[key]['id_log']);
    }
}