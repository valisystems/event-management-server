var colorCorespond = new Array();
colorCorespond['#FD5308'] = '#FFFFFF';
colorCorespond['#FB9902'] = '#FFFFFF';
colorCorespond['#FABC02'] = '#000000';
colorCorespond['#FEFE33'] = '#000000';
colorCorespond['#D0EA2B'] = '#000000';
colorCorespond['#66B032'] = '#000000';
colorCorespond['#0391CE'] = '#FFFFFF';
colorCorespond['#0247FE'] = '#FFFFFF';
colorCorespond['#3D01A4'] = '#FFFFFF';
colorCorespond['#8601AF'] = '#FFFFFF';
colorCorespond['#A7194B'] = '#FFFFFF';
colorCorespond['#FE2712'] = '#FFFFFF';
colorCorespond['#000000'] = '#FFFFFF';
colorCorespond['#FFFFFF'] = '#000000';

var listShortNotification = new Array();
var listExtenstion = new Array();
var deviceId = new Array();
var devicePosition = new Array();
var serverLink = '';

var posDeviceId = new Array();
var posDevicePosition = new Array();

var maxiDeviceId = new Array();
var maxiDevicePosition = new Array();



$(document).ready(function(){
    //refreshLivePanel();
    //getStatusOfExtension();
    $('#id_building').val('');
    $('#id_map').val('');
    removeHidedNotification();
    hidePopupIfNotHaveNotification();
    hidePopupIfNotHaveNotificationPos();
    hidePopupIfNotHaveNotificationMaxi();
    calculation();
    $(window).resize(calculation);
    //$(window).on("resize", calculation);
    refreshCameraView();
});


function calculation() {
    if ($('#mapsImages').length > 0 && devicePosition.length > 0){
        var location = $('#mapsImages').offset();
        var top = location.top;
        var left = location.left;
        //alert("Resized");
        for (var key in devicePosition){
            var posDev = devicePosition[key].split(";");
            var leftPosition = parseInt(posDev[0]) + parseInt(left);
            var topPosition = parseInt(posDev[1]) + parseInt(top);
            $("#"+key).offset({left:leftPosition, top:topPosition});
        }
    }
}
function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
function changeCurrentTime(){
    var dayarray=new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

    var montharray=new Array("", "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
    var now     = new Date();
    var year    = now.getFullYear();
    var month   = now.getMonth()+1;
    var dateToday     = now.getDate();
    var day     = now.getDay();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds();
    /*if(month.toString().length == 1) {
     var month = '0'+month;
     }*/
    if(dateToday.toString().length == 1) {
        var dateToday = '0'+dateToday;
    }
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }
    var dateTime = hour+':'+minute+' '+ dayarray[day] + ' '+dateToday + ' ' + montharray[month]+' '+year;
    $('.currentTime').html(dateTime);
    setTimeout(changeCurrentTime, 10000);
}
function getFloors(idBuilding) {
    var url = '/livepanel/default/listFloor/id/'+idBuilding;
    jQuery.ajax({
        'type':'post',
        //'data':data,
        'url':url,
        'cache':false,
        'success':function(dd){
            $('#floorList').html(dd);
        }
    });
    $('#id_building').val(idBuilding);
    $('#id_map').val('');
    $('#id_map').val('');
    $('#mapsInfo').empty();
    $('.deviceNotification').remove();
    $('.deviceNotificationPos').remove();
    $('.stick').remove();
    listShortNotification = [];
}

function viewMaps(vv, idBuilding){
    $('#id_building').val(idBuilding);
    var imgMap = $(vv).attr('img_map');
    var maps=$("<img />",{"src":imgMap, 'id':'mapsImages', 'usemap':'#mapsArea', 'style':'z-index:0;'});
    var mm=$('<map />', {'id':'mapsArea', 'name':'mapsArea', 'class':'mapArea'});
    var id_map = $(vv).attr('id_map');
    //$('#mapsInfo').html(maps).append(mm);
    $('#mapsInfo').html(maps);
    $('#id_map').val(id_map);
    $('.deviceNotification').remove();
    $('.deviceNotificationPos').remove();
    $('.deviceNotificationMax').remove();
    $('.stick').remove();
    listShortNotification = [];
    //listExtenstion = deviceId = devicePosition = posDeviceId = posDevicePosition = maxiDeviceId = maxiDevicePosition = [];
    getListDevice();
    $('body').click();
}
function getListDevice() {
    var idMap = $('#id_map').val();
    var url = '/livepanel/default/listDeviceByFloor/id/'+idMap;
    posDeviceId.length = 0;
    maxiDeviceId = [];
    jQuery.ajax({
        'type':'post',
        //'data':data,
        'url':url,
        'cache':false,
        'success':function(dd){
            var btn;
            var p = $('#mapsImages').offset();
            //console.log('mapImagesPosition=', p);
            for(var key in dd){
               if (dd[key].device_classification == 'mialert') {
                   //console.log("Tipe device", dd[key].device_classification);
                   var devID = 'dev_' + dd[key].id_device;
                   btn = "<div id='" + devID + "' class='btn btn-sm btn-default'>" + dd[key].ext_number + "</div>";
                   $('#mapsInfo').append(btn);
                   devicePosition[devID] = dd[key].coordonate_on_map;
                   var posDev = dd[key].coordonate_on_map.split(";");
                   //setTimeout(function(){}, 1000);
                   var leftPosition = parseInt(posDev[0]) + parseInt(p.left);
                   var topPosition = parseInt(posDev[1]) + parseInt(p.top);
                   $("#" + devID).offset({left: leftPosition, top: topPosition});
                   listExtenstion.push(dd[key].ext_number);
                   serverLink = dd[key].asterisk_url;
                   deviceId[dd[key].ext_number] = dd[key].id_device;
               }

               if ( dd[key].device_classification == 'mipositioning' ) {
                   var posDevID = 'posDev_' + dd[key].id_device;
                   btn = "<div id='" + posDevID + "' class='btn btn-sm btn-info'>" + dd[key].device_description + "</div>";
                   $('#mapsInfo').append(btn);
                   posDevicePosition[posDevID] = dd[key].coordonate_on_map;
                   posDeviceId.push(dd[key].id_device);
                   var posDev = dd[key].coordonate_on_map.split(";");
                   var leftPosition = parseInt(posDev[0]) + parseInt(p.left);
                   var topPosition = parseInt(posDev[1]) + parseInt(p.top);
                   $("#" + posDevID).offset({left: leftPosition, top: topPosition});
                   var tt = 1;
               }
                if ( dd[key].device_classification == 'maxivox' ) {
                    var maxiDevID = 'maxiDev_' + dd[key].id_device;
                    btn = "<div id='" + maxiDevID + "' class='btn btn-sm btn-warning'>" + dd[key].device_description + "</div>";
                    $('#mapsInfo').append(btn);
                    maxiDevicePosition[maxiDevID] = dd[key].coordonate_on_map;
                    maxiDeviceId.push(dd[key].id_device);
                    var maxiDev = dd[key].coordonate_on_map.split(";");
                    var leftPosition = parseInt(maxiDev[0]) + parseInt(p.left);
                    var topPosition = parseInt(maxiDev[1]) + parseInt(p.top);
                    $("#" + maxiDevID).offset({left: leftPosition, top: topPosition});
                    var tt = 1;
                }
            }
            //alert(posDeviceId.length)
            refreshLivePanel();
            getNotificationPositioning();
            getNotificationMaxiVox();
            setTimeout(getStatusOfExtension, 2000);
        }
    });
    //$('nav.gn-menu-wrapper').removeClass('gn-open-all');

    //$('body').click();

}
function refreshLivePanel(){
    var idBuilding = $('#id_building').val();
    var idMap = $('#id_map').val();
    var coordonates = new Array();
    if (idBuilding > 0 && idMap > 0) {
        var url = '/livepanel/liveRequest/getLastNotification/idBuilding/'+idBuilding+'/idMap/'+idMap;
        $.ajax({
            url: url,                   //
            timeout: 30000,
            type: "POST",
            //data: 'id_patient='+$('#Devices_id_patient').val()+'&id_room='+$('#Devices_id_room').val(),
            //dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(data){
                //var notif = jQuery.parseJSON(data);
                //Do stuff here on success such as modal info
                //$( this ).dialog( "close" );
                /*
                 {
                 "id_log":'1234'
                 "code":"842",
                 "type_notification":"SMS",
                 "receiver":"4164203151",
                 "message_sent":"Sa vedem oare ce se intimplaHa, ha, ha",
                 "current_time":"2014-09-29 15:11:07",
                 "response_message":"<HTML>\r\n<HEAD><TITLE>Message Submitted<\/TITLE><\/HEAD>\r\n<BODY bgcolor=#cce8ff>\r\n<p>\r\nMessage Submitted\r\n<p>\r\n<a href=\"javascript:history.back()\">Continue<\/a>\r\n<p>\r\n<pre><small>\r\nMessageID=5395D93F, Recipient=4164203151\r\n<\/small><\/pre>\r\n<p>\r\n<\/BODY>\r\n<\/HTML>\r\n",
                 "status_of_notification":"0",
                 "device_description":"A device ",
                 "device_type":"button",
                 "comon_area":"0",
                 "id_device":"6",
                 "first_name":"Some",
                 "last_name":"Dude",
                 "avatar_path":"",
                 "afliction":"Mentally Retarded",
                 "id_asterisk":"1",
                 "ext_number":"1234567",
                 coordinate_on_map,
                 nb_room,
                 position_popup
                 }
                 */
                //console.log(data);
                var notifyInfo = new Array();
                var lenNotify = 0;
                for(var key in data){
                    if(data.hasOwnProperty(key)){
                        //console.log('key = ',key, 'code', data[key].coordinate_on_map);
                        if (coordonates.indexOf(data[key].coordinate_on_map) == -1 && data[key].coordinate_on_map.length > 0){
                            coordonates[coordonates.length] = data[key].coordinate_on_map;
                        }
                        notifyInfo[lenNotify] = new Array();
                        notifyInfo[lenNotify]['id_log'] =  data[key].id_log;
                        notifyInfo[lenNotify]['code'] =  data[key].code;
                        notifyInfo[lenNotify]['color_hex'] =  data[key].color_hex;
                        notifyInfo[lenNotify]['live_panel'] =  data[key].live_panel;
                        notifyInfo[lenNotify]['require_acknowledge'] =  data[key].require_acknowledge;
                        notifyInfo[lenNotify]['auto_close'] =  data[key].auto_close;
                        notifyInfo[lenNotify]['flashing_toggle'] =  data[key].flashing_toggle;
                        notifyInfo[lenNotify]['auto_close_duration'] =  data[key].auto_close_duration;
                        notifyInfo[lenNotify]['position_popup'] =  data[key].position_popup;

                        notifyInfo[lenNotify]['type_notification'] =  data[key].type_notification;
                        notifyInfo[lenNotify]['receiver'] =  data[key].receiver;
                        notifyInfo[lenNotify]['message_sent'] =  data[key].message_sent;
                        notifyInfo[lenNotify]['response_message'] = data[key].response_message;
                        notifyInfo[lenNotify]['current_time'] =  data[key].current_time;
                        notifyInfo[lenNotify]['status_of_notification'] =  data[key].status_of_notification;
                        notifyInfo[lenNotify]['device_description'] =  data[key].device_description;
                        notifyInfo[lenNotify]['device_type'] =  data[key].device_type;
                        notifyInfo[lenNotify]['comon_area'] =  data[key].comon_area;
                        notifyInfo[lenNotify]['id_device'] =  data[key].id_device;
                        notifyInfo[lenNotify]['id_patient'] =  data[key].id_patient;
                        notifyInfo[lenNotify]['first_name'] =  data[key].first_name;
                        notifyInfo[lenNotify]['last_name'] =  data[key].last_name;
                        notifyInfo[lenNotify]['avatar_path'] =  (typeof(data[key].avatar_path) != 'null') ? data[key].avatar_path : "";
                        notifyInfo[lenNotify]['afliction'] =  data[key].afliction;
                        notifyInfo[lenNotify]['id_asterisk'] =  data[key].id_asterisk;
                        notifyInfo[lenNotify]['ext_number'] =  data[key].ext_number;
                        notifyInfo[lenNotify]['nb_room'] =  data[key].nb_room;
                        notifyInfo[lenNotify]['dev_coordonate'] =  data[key].dev_coordonate;
                        notifyInfo[lenNotify]['io_name'] =  data[key].io_name;
                        notifyInfo[lenNotify]['command'] =  data[key].command;
                        //dev_coordonate

                        var coordArray = data[key].coordinate_on_map.split(',');
                        var coordId = coordArray.join('-');

                        notifyInfo[lenNotify]['coordinate_id'] =  coordId;
                        lenNotify = notifyInfo.length;
                        //console.log('Nb array =', lenNotify);
                    }
                }
                if (notifyInfo.length > 0 ){
                    GeneratePopUpInfo(notifyInfo);
                }
                //alert(coordonates.length)
                /*if (coordonates.length > 0) {
                 for (var i = 0; i < coordonates.length; i++){
                 createCanvas(coordonates[i]);
                 }
                 }*/
            }
        });
    }
    //console.log('idBuilding = ',idBuilding,' idMap = ', idMap);
    setTimeout(refreshLivePanel, 5000);
}
function createCanvas(coordonate){
    var coordArray = coordonate.split(',');
    var coordId = coordArray.join('-');
    if ($('#'+coordId).length == 0){
        $('#mapsArea').append('<area shape="poly" id="'+coordId+'" coords="'+coordonate+'" style="cursor:pointer">');
        //$('#'+coordId).css({'background-color' : 'red'});
    }

}
function GeneratePopUpInfo(notInfoArray){
    var selectedEffect = 'bounce';
    var options = {};
    for(var key in notInfoArray){
        var shortInfo = notInfoArray[key];
        var divInfo = '';
        var divPosition = '';
        var noPatientInfo = "";
        if($('#device_'+shortInfo['id_device']).length == 0){

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
            var id_device = shortInfo['id_device'];
            divInfo += "<div id='device_"+shortInfo['id_device']+"' class='deviceNotification "+ divPosition +"' style='cursor:pointer;'>";
            if (shortInfo['id_patient'] != null && shortInfo['device_type'] != 'camera') {
                divInfo += "<div class='patient_profile'>";
                divInfo += "    <div class='userAvatar'>";
                if (typeof(shortInfo['avatar_path']) != null && shortInfo['avatar_path'] != "")
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
            } else {
                noPatientInfo = "noPatientInfo";
            }

            var color = getRandomColor();
            if (shortInfo['device_type'] == 'camera')
                divInfo += "<div class='notifications cameranotification' id='device_notif_"+shortInfo['id_device']+"'>";
            else
                divInfo += "<div class='notifications "+noPatientInfo+"' id='device_notif_"+shortInfo['id_device']+"'>";
            divInfo += "    <div class='notification_details' id='div_notification_details_"+shortInfo['id_log']+"' style='background-color:"+shortInfo['color_hex']+";color:"+colorCorespond[shortInfo['color_hex']]+"'>";
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
                divInfo += "<label class='roomNumber'>Room "+ shortInfo['nb_room'] +"</label>";
                divInfo += "<label class='currentTime'>currentTime</label>";
            divInfo += "</div>";
            //if (shortInfo['position_popup'] == 'top')
            //    divInfo += "<div class='bottomFlash'></div>";
            //else if (shortInfo['position_popup'] == 'left')
            //    divInfo += "<div class='rightFlash'></div>";
            //else if (shortInfo['position_popup'] == 'bottom')
            //    divInfo += "<div class='topFlash'></div>";
            //else if (shortInfo['position_popup'] == 'right')
            //    divInfo += "<div class='leftFlash'></div>";
            //else if (shortInfo['position_popup'] == 'topleft')
            //    divInfo += "<div class='bottomRightFlash'>&nbsp;</div>";
            //else if (shortInfo['position_popup'] == 'topright')
            //    divInfo += "<div class='bottomLeftFlash'>&nbsp;</div>";
            //else if (shortInfo['position_popup'] == 'bottomleft')
            //    divInfo += "<div class='topRightFlash'>&nbsp;</div>";
            //else if (shortInfo['position_popup'] == 'bottomright')
            //    divInfo += "<div class='topLeftFlash'>&nbsp;</div>";
            divInfo += "</div>";
            $('#mapsInfo').after(divInfo);
            /**
             * Add method of Autoclose fore notification in popup on extension
             */
            if (shortInfo['auto_close_duration'] > 0 && shortInfo['auto_close'] == 'Y'){
                var timeAfterClose = shortInfo['auto_close_duration']*1000;
                $('#div_notification_details_'+shortInfo['id_log']).delay(timeAfterClose).fadeOut(300);


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
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD - 79, top: topPositionD - 205});
            else if (shortInfo['position_popup'] == 'left'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD - 223 - 15, top: topPositionD - 96});
            } else if (shortInfo['position_popup'] == 'bottom'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD - 100, top: topPositionD + 45});
            } else if (shortInfo['position_popup'] == 'right'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD + 86, top: topPositionD - 96});
            } else if (shortInfo['position_popup'] == 'topleft'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD - 202, top: topPositionD - 215});
            } else if (shortInfo['position_popup'] == 'topright'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD + 51, top: topPositionD - 213});
            } else if (shortInfo['position_popup'] == 'bottomleft'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD - 209, top: topPositionD + 55});
            } else if (shortInfo['position_popup'] == 'bottomright'){
                $('#device_'+shortInfo['id_device']).offset({left:leftPositionD + 63, top: topPositionD + 55});
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
                    if (shortInfo['require_acknowledge'] == 'Y') {
                        $.stickr({
                            note: divNotification,
                            position:{right:0,bottom:0},
                            className:classNameNotif,
                            sticked:true,
                            speed:300

                        });
                    } else {
                        $.stickr({
                            note: divNotification,
                            className: classNameNotif,
                            //sticked:true,
                            position: {right: 0, bottom: 0},
                            time: shortInfo['auto_close_duration'] * 1000,
                            speed: 300

                        });
                    }
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
            $('.deviceNotification').click(function(){
                changePositionOfMineDiv(this);
            });
        } else {
            var color = getRandomColor();
            divInfo += "<div class='notification_details' id='div_notification_details_"+shortInfo['id_log']+"' style='background-color:"+shortInfo['color_hex']+";color:"+colorCorespond[shortInfo['color_hex']]+"'>";
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
            divInfo += "<label class='time_notification'>";
            divInfo += shortInfo['current_time'];
            divInfo += "</label>";
            divInfo += "</div>";
            divInfo += "<div class='message_notification'>";
            if (shortInfo['type_notification'] == 'IOPOS')
                divInfo += shortInfo['io_name']+" - "+shortInfo['command'];
            else
                divInfo += shortInfo['receiver'];
            divInfo += "</div>";
            divInfo += "</div>";
            if ($("#div_notification_details_"+shortInfo['id_log']).length == 0 ) {
                $("#device_notif_"+shortInfo['id_device']).prepend(divInfo).show('clip');
                /**
                 * Add method of Autoclose fore notification in popup on extension
                 */
                if (shortInfo['auto_close_duration'] > 0 && shortInfo['auto_close'] == 'Y'){
                    var timeAfterClose = shortInfo['auto_close_duration']*1000;
                    $('#div_notification_details_'+shortInfo['id_log']).delay(timeAfterClose).fadeOut(300);

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
            }
            //console.log('suntem aici', shortInfo['id_device']);
        }
        //console.log('id log', notInfoArray[key]['id_log']);
    }
}

var ttime;
var timeView = 0;
//var listExtenstion = new Array();
//var serverLink = '';
function getStatusOfExtension(){
    if (listExtenstion.length > 0 && serverLink != null) {
        $.ajax({
            url: serverLink + "/statusextforlive.php",                   //
            type: "POST",
            data: {ext:listExtenstion},
            //datatype: 'json',
            //dataType: 'json',
            //contentType: 'application/json',
            //headers: {'Access-Control-Allow-Origin': '*'},
            cache: false,
            // error: function(XMLHttpRequest, textStatus, errorThrown)  {
            // console.log("An error has occurred making the request: " + errorThrown + "  " + XMLHttpRequest)
            // },
            success: function(dd){
                var jsonExt = JSON.parse(dd);
                for(key in jsonExt) {
                    if ($('#dev_'+deviceId[key]).length > 0) {
                        //alert(jsonExt[key])
                        switch (jsonExt[key]) {
                            case "UNKNOWN":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-default');
                                break;
                            case "-1":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-default');
                                break;
                            case "0":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-success');
                                break;
                            case "1":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-danger');
                                break;
                            case "2":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-warning');
                                break;
                            case "4":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-default');
                                break;
                            case "8":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-warning');
                                break;
                            case "16":
                                $('#dev_'+deviceId[key]).attr('class', 'btn btn-sm btn-primary');
                                break;
                        }
                    }
                }
            }
        });
    }
    setTimeout(getStatusOfExtension, 1000);
}

function dateNow(){
    var dateNow = Math.random();
    $('#camera_1102').attr('src', 'http://192.168.1.195/snapshot/view4.jpg?t='+dateNow);
    ttime = setTimeout(dateNow, 3000);

}

function changePositionOfMineDiv(vvThis){
    $('.deviceNotification').css('z-index',100);
    $(vvThis).css('z-index',1000);
}
function changePositionOfMineDivPos(vvThis){
    $('.deviceNotificationPos').css('z-index',100);
    $(vvThis).css('z-index',1000);
}
function changePositionOfMineDivMax(vvThis){
    $('.deviceNotificationMax').css('z-index',100);
    $(vvThis).css('z-index',1000);
}
function removeHidedNotification(){
    $(".notification_details").each(function () {
        if ($(this).css("display") == "none") { $(this).remove(); }
    });
    setTimeout(removeHidedNotification, 1000);
}
function hidePopupIfNotHaveNotification(){
    $('.deviceNotification').each(function(){
        if ($(this).children('.notifications').children('.notification_details').length == 0){
            $(this).hide();
        }else {
            $(this).show();
        }
    });
    setTimeout(hidePopupIfNotHaveNotification, 1000);
}
function hidePopupIfNotHaveNotificationPos(){
    $('.deviceNotificationPos').each(function(){
        if ($(this).children('.notificationsPos').children('.notification_details').length == 0){
            $(this).hide();
        }else {
            $(this).show();
        }
    });
    setTimeout(hidePopupIfNotHaveNotificationPos, 1000);
}
function hidePopupIfNotHaveNotificationMaxi(){
    $('.deviceNotificationMax').each(function(){
        if ($(this).children('.notificationsMaxi').children('.notification_details').length == 0){
            $(this).hide();
        }else {
            $(this).show();
        }
    });
    setTimeout(hidePopupIfNotHaveNotificationMaxi, 1000);
}
function refreshCameraView(){
    $('.imageCamera').each(function(){
       //alert('dev-id='+$(this).attr('dev_id'))
        var imgCamera = $(this).find("img");

        if($(imgCamera).attr('src') == "") {
            var url = '/livepanel/liveRequest/getImgUrl/idCamera/'+$(this).attr('camera_id');
            $.ajax({
                url: url,                   //
                timeout: 30000,
                type: "POST",
                //data: 'id_patient='+$('#Devices_id_patient').val()+'&id_room='+$('#Devices_id_room').val(),
                //dataType: 'json',
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("An error has occurred making the request: " + errorThrown)
                },
                success: function (dd) {
                        if(dd != "") {
                            $(imgCamera).attr('src',dd);
                        }
                }
            });
        } else {

            var src=imgCamera.attr('src');
            var i=src.indexOf('?dummy=');
            src=i!=-1?src.substring(0,i):src;

            d = new Date();
            imgCamera.attr('src', src+'?dummy='+d.getTime() );
        }
    });
    //console.log('suntem aici');
    setTimeout(refreshCameraView, 3000);
}