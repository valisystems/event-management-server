/**
 * Created by iurik on 6/10/15.
 */
$(document).ready(function(){
    //getNotificationPositioning();
});

function getNotificationMaxiVox(){
    if (typeof maxiDeviceId != 'undefined' && maxiDeviceId.length > 0) {
        refreshLivePanelMaxiVox();
    }
}
var timerMaxiVoxNotif;
function refreshLivePanelMaxiVox(){
    var idBuilding = $('#id_building').val();
    var idMap = $('#id_map').val();
    var coordonatesPos = new Array();

    var url = '/livepanel/liveRequest/getLastNotificationMaxiVox';
    $.ajax({
        url: url,                   //
        timeout: 30000,
        type: "POST",
        data: {'listDevice':maxiDeviceId},
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
                //alert('Test')
            var notifyInfoMax = new Array();
            var lenNotify = 0;
            for(var key in dd){
                if(dd.hasOwnProperty(key)){
                   if (dd[key].coordinate_on_map!= null) {
                       if (coordonatesPos.indexOf(dd[key].coordinate_on_map) == -1 && dd[key].coordinate_on_map.length > 0) {
                           coordonatesPos[coordonatesPos.length] = dd[key].coordinate_on_map;
                       }
                   }
                    notifyInfoMax[lenNotify] = new Array();
                    notifyInfoMax[lenNotify]['id_log'] =  dd[key].id_log;
                    notifyInfoMax[lenNotify]['EventType'] =  dd[key].DeviceLabel;
                    notifyInfoMax[lenNotify]['color_hex'] =  dd[key].color_hex;
                    notifyInfoMax[lenNotify]['live_panel'] =  dd[key].live_panel;
                    notifyInfoMax[lenNotify]['require_acknowledge'] =  dd[key].require_acknowledge;
                    notifyInfoMax[lenNotify]['auto_close'] =  dd[key].auto_close;
                    notifyInfoMax[lenNotify]['flashing_toggle'] =  dd[key].flashing_toggle;
                    notifyInfoMax[lenNotify]['auto_close_duration'] =  dd[key].auto_close_duration;
                    notifyInfoMax[lenNotify]['position_popup'] =  dd[key].position_popup;
                    notifyInfoMax[lenNotify]['type_notification'] =  dd[key].type_notification;
                    notifyInfoMax[lenNotify]['receiver'] =  dd[key].receiver;
                    notifyInfoMax[lenNotify]['message_sent'] =  dd[key].message_sent;
                    notifyInfoMax[lenNotify]['response_message'] = dd[key].response_message;
                    notifyInfoMax[lenNotify]['current_time'] =  dd[key].current_time;
                    notifyInfoMax[lenNotify]['status_of_notification'] =  dd[key].status_of_notification;
                    notifyInfoMax[lenNotify]['device_description'] =  dd[key].device_description;
                    notifyInfoMax[lenNotify]['device_type'] =  dd[key].device_type;
                    notifyInfoMax[lenNotify]['comon_area'] =  dd[key].comon_area;
                    notifyInfoMax[lenNotify]['id_device'] =  dd[key].id_maxivox_device;
                    notifyInfoMax[lenNotify]['id_patient'] =  dd[key].id_patient;
                    notifyInfoMax[lenNotify]['first_name'] =  (dd[key].first_name != null) ? dd[key].first_name : "";
                    notifyInfoMax[lenNotify]['last_name'] =  (dd[key].last_name != null) ? dd[key].last_name : "";
                    notifyInfoMax[lenNotify]['avatar_path'] =  (typeof(dd[key].avatar_path) != 'null') ? dd[key].avatar_path : "";
                    notifyInfoMax[lenNotify]['afliction'] =  dd[key].afliction;
                    notifyInfoMax[lenNotify]['nb_room'] =  dd[key].nb_room;
                    notifyInfoMax[lenNotify]['dev_coordonate'] =  dd[key].dev_coordonate;
                    notifyInfoMax[lenNotify]['io_name'] =  dd[key].io_name;
                    notifyInfoMax[lenNotify]['command'] =  dd[key].command;
                    //dev_coordonate

                    if (dd[key].coordinate_on_map!= null) {
                        var coordArray = dd[key].coordinate_on_map.split(',');
                        var coordId = coordArray.join('-');

                        notifyInfoMax[lenNotify]['coordinate_id'] = coordId;
                    } else {
                        notifyInfoMax[lenNotify]['coordinate_id'] = "";
                    }
                    lenNotify = notifyInfoMax.length;
                    //console.log('Nb array =', lenNotify);
                }
            }
            if (notifyInfoMax.length > 0 ){
                GeneratePopUpInfoMaxiVox(notifyInfoMax);
            }

        }
    });
    //console.log('idBuilding = ',idBuilding,' idMap = ', idMap);
    timerMaxiVoxNotif = setTimeout(refreshLivePanelMaxiVox, 5000);
}

function GeneratePopUpInfoMaxiVox(notInfoArray){
    var selectedEffect = 'bounce';
    var options = {};
    for(var key in notInfoArray){
        var shortInfo = notInfoArray[key];
        var divInfo = '';
        var divPosition = '';
        var patientName = shortInfo['first_name'] + " " + shortInfo['last_name'];
        if($('#device_max_'+shortInfo['id_device']).length == 0){
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

            divInfo += "<div id='device_max_"+shortInfo['id_device']+"' class='deviceNotificationMax "+ divPosition +"' style='cursor:pointer;'>";
            var color = getRandomColor();
            if (shortInfo['device_type'] == 'camera')
                divInfo += "<div class='notificationsMaxi cameranotification' id='device_notif_max_"+shortInfo['id_device']+"'>";
            else
                divInfo += "<div class='notificationsMaxi' id='device_notif_max_"+shortInfo['id_device']+"'>";
            divInfo += "    <div class='notification_details' id='div_notification_details_max_"+shortInfo['id_log']+"' style='background-color:"+shortInfo['color_hex']+";color:"+colorCorespond[shortInfo['color_hex']]+"'>";
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
            /*if (shortInfo['position_popup'] == 'top')
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
                divInfo += "<div class='topLeftFlash'>&nbsp;</div>";*/
            divInfo += "</div>";
            $('#mapsInfo').after(divInfo);
            /**
             * Add method of Autoclose fore notification in popup on extension
             */
            if (shortInfo['auto_close_duration'] > 0 && shortInfo['auto_close'] == 'Y'){
                var timeAfterClose = shortInfo['auto_close_duration']*1000;
                $('#div_notification_details_max_'+shortInfo['id_log']).delay(timeAfterClose).fadeOut(300);


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
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD - 79, top: topPositionD - 205});
            else if (shortInfo['position_popup'] == 'left'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD - 223 - 15, top: topPositionD - 96});
            } else if (shortInfo['position_popup'] == 'bottom'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD - 100, top: topPositionD + 45});
            } else if (shortInfo['position_popup'] == 'right'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD + 86, top: topPositionD - 96});
            } else if (shortInfo['position_popup'] == 'topleft'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD - 202, top: topPositionD - 215});
            } else if (shortInfo['position_popup'] == 'topright'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD + 51, top: topPositionD - 213});
            } else if (shortInfo['position_popup'] == 'bottomleft'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD - 209, top: topPositionD + 55});
            } else if (shortInfo['position_popup'] == 'bottomright'){
                $('#device_max_'+shortInfo['id_device']).offset({left:leftPositionD + 63, top: topPositionD + 55});
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
                changePositionOfMineDivMax(this);
            });
        } else {
            var color = getRandomColor();
            divInfo += "<div class='notification_details' id='div_notification_details_max_"+shortInfo['id_log']+"' style='background-color:"+shortInfo['color_hex']+";color:"+colorCorespond[shortInfo['color_hex']]+"'>";
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
            if ($("#div_notification_details_max_"+shortInfo['id_log']).length == 0 ) {
                $("#device_notif_max_"+shortInfo['id_device']).prepend(divInfo).show('clip');
                /**
                 * Add method of Autoclose fore notification in popup on extension
                 */
                if (shortInfo['auto_close_duration'] > 0 && shortInfo['auto_close'] == 'Y'){
                    var timeAfterClose = shortInfo['auto_close_duration']*1000;
                    $('#div_notification_details_max_'+shortInfo['id_log']).delay(timeAfterClose).fadeOut(300);

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