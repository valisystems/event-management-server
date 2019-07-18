$(document).ready($(function () {
    $("[data-toggle='popover']").popover({"html":true, "trigger":"hover", "delay": { "show": 500, "hide": 2000 }});
    $(".popover").css("max-width", "750px");
    setTimeout(function(){
        $(".alert").fadeOut("slow");
    }, 5000 );
    $('[data-rel="chosen"],[rel="chosen"]').chosen();
    extensionDefine();
    $( "#Devices_id_map" ).change(function() {
        if( $('#Devices_extension_define_1').is(':checked') ) {
            $('#Devices_extension_number').val("");
            //$('#extNb').hide();
        } else {
            //$('#extNb').show();
        }
    });

    $( "#btnSave" ).click(function() {
        if( $('#Devices_extension_define_1').is(':checked') ) {
            if ($('#Devices_extension_number').val() == '') {
                alert('Enter valid Extension number')
                return false;
            } else
                return true;
        }

    });
}));
var x1 = x2 = y1 = y2 = xTmp = yTmp = 0;
$(document).ready(function(){
    $('#Devices_device_description').keyup(function() {
        if (typeof($('#devicePosition')) != "undefined") {
            $('#devicePosition').html($(this).val());
        }
    });
    
    if ($("#Devices_id_map").val() > 0) {
        $("#Devices_id_map").change();
        //getMapImage($("#Devices_id_map").val());
        //$('#Devices_id_room').change();
        setTimeout(function(){}, 3000);
        //var coordonate = $('#coordinate_on_map').val().split(';');
        //var l = $("#roomConstruction");
        //var pos = l.offset();
        //var newPositionTop = parseInt(coordonate[1]) + parseInt(pos.top);
        //var newPositionLeft = parseInt(coordonate[0]) + parseInt(pos.left);
        //$("#devicePosition" ).offset({top:newPositionTop, left: newPositionLeft});
    }
    $('#Devices_serial_number').blur(function(){
        verifySerialNumberIsUnique();
    });
});

function manageEmaps(){
   if ($('#Devices_id_patient').val() != "") {
       var url = $('#patient-devices-form').attr('action');
       $.ajax({
                url: url,                   //
                timeout: 30000,
                type: "POST",
                data: 'id_patient='+$('#Devices_id_patient').val()+'&id_room='+$('#Devices_id_room').val(),
                //dataType: 'json',
                error: function(XMLHttpRequest, textStatus, errorThrown)  {
                    alert("An error has occurred making the request: " + errorThrown)
                },
                success: function(data){                                                        
                     //Do stuff here on success such as modal info      
                         //$( this ).dialog( "close" );
                    $('#managePatient').html(data);
                }
       });
   }
   else
        alert('Need Choose a Patient') 
}
function extensionDefine(){
    if($('#Devices_extension_define_1').is(':checked')) {
        $('#extNb').show();
    } else {
        $('#extNb').hide();
    }
}

function openFormCreateExtension(){
    if (openFormExt % 2 == 0){
        $('#extForm').show();
        openFormExt++;
    } else {
        $('#extForm').hide();
        openFormExt++;
    }
}

function saveFormExtension(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#extension-form').serialize();
    var urlAction = $('#extension-form').attr('action');
    
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
            var url = "/admin/devices/manageExtension/id/"+$('#Devices_id_device').val();
            $.get(url, function(r){
                $("#manageExtensions").html(r);
                $("[data-toggle='popover']").popover(
                    {
                        html:true, 
                        trigger:"hover",
                    }
                );
                $(".popover").css("max-width", "350px");
                setTimeout(function(){ 
                    $(".alert").fadeOut("slow"); 
                }, 5000 ); 
            });
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function editExtension(id_extension, id_device){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var url = "/admin/devices/manageExtension/id/"+id_device;
    jQuery.ajax({
            'type':'post',
            'data':'viewEditForm=1',
            'url':url,
            'cache':false,
            'success':function(dd){
                $("#manageExtensions").html(dd);
                $("[data-toggle='popover']").popover(
                    {
                        html:true, 
                        trigger:"hover",
                    }
                );
                $(".popover").css("max-width", "350px");
            }
        });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function deleteExtension(id_extension, id_device, delMsg){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    if (confirm(delMsg)) {
        var url = '/admin/devices/deleteExtension/id/'+id_extension;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(){
                var url = "/admin/devices/manageExtension/id/"+id_device;
                $.get(url, function(r){
                    $("#manageExtensions").html(r);
                    $("[data-toggle='popover']").popover(
                        {
                            html:true, 
                            trigger:"hover",
                        }
                    );
                    $(".popover").css("max-width", "350px");
                });
            }
        });
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function getMapImage(idMap){
    $.ajax({
            url: '/admin/devices/floorInfo/id/'+idMap,                   //
            timeout: 30000,
            type: "POST",
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(dd){                                                        
                 //Do stuff here on success such as modal info      
                     //$( this ).dialog( "close" );
                /*$('#roomConstruction').remove();
                $('canvas').remove();*/
                $('#maps').html(dd);
            }
    });
}
$('#Devices_id_room').change(function(){
    //alert('Vasea');
    //console.log('Vasea');
    $.ajax({
        url: '/admin/devices/roomCoordonate/id/'+$(this).val(),                   //
        timeout: 30000,
        type: "POST",
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){                                                        
             //Do stuff here on success such as modal info      
                 //$( this ).dialog( "close" );
            //alert(dd.pathImage)
            $('canvas').remove();
            $('#coordinate_convas').attr('data-image-url', dd.pathImage);
            $('#coordinate_convas').attr('value', dd.coordinate);
            var coord = dd.coordinate;
            var coordonateArray = new Array();
            coordonateArray = coord.split(",").map(Number);
            //console.log(coord);

            //console.log(coordonateArray.length);
            x1,x2, y1, y2 = yTmp = xTmp = 0;
            for (var i = 0; i < (coordonateArray.length/2); i++) {
                //console.log('i = ',i,' X = ',coordonateArray[i], 'Y = ', coordonateArray[i+1])
                if(i == 0) {
                    x1 = x2 = xTmp = coordonateArray[i*2];
                    y1 = y2 = yTmp = coordonateArray[i*2+1];
                }
                if (i > 0) {
                    if (x1 > coordonateArray[i*2]) {
                        x1 = coordonateArray[i*2];
                    }
                    if (y1 < coordonateArray[i*2+1]) {
                        y1 = coordonateArray[i*2+1];
                    }

                    if (x2 < coordonateArray[i*2]) {
                        x2 = coordonateArray[i*2];
                    }
                    if (y2 > coordonateArray[i*2+1]) {
                        y2 = coordonateArray[i*2+1];
                    }

                }
            }
            //console.log('x1 = ', x1, ' y1 = ',y1,' x2 = ', x2, ' y2 = ',y2);
            $('#roomPositionsImg').remove();
            $('#coordinate_convas').canvasAreaDraw({
                //imageUrl: $('#coordinate_on_map').attr('data-image-url'),
                activePoint: false,
                readOnly: true
            });
            $('#devicePosition').droppable({
            	accept: '#devicePosition',
                hoverClass:  "mapHover"
            });
            $('#devicePosition').mouseup(function() {
                var pos = $(this).position();
                var x1Pos = parseInt(pos.left) - 13;
                var y1Pos = parseInt(pos.top) - 745;
                if (x1Pos >= x1 && x1Pos <= x2 && y1Pos >= y2 && y1Pos <= y1) {

                } else {
                    var convasPosition =  $('canvas').offset();
                    $(this).offset({left: parseInt(convasPosition.left) + xTmp, top: parseInt(convasPosition.top)+yTmp});
                    alert('Out of room area')
                }
            });
        }
    });
});
function iuraTest(){
    var offset = $(this).offset();
    var xPos = offset.left;
    var yPos = offset.top;
    console.log('x: ',xPos,' y: ',yPos);
}
function changePositionOfDev(leftPos, topPos){
}

function verifySerialNumberIsUnique(){
    var serial_number = $('#Devices_serial_number').val();
    var id_device = $('#id_device_update').val();
    if (serial_number != "" && id_device == '') {
        $.ajax({
            url: '/admin/devices/verifySerialNumber',                   //
            type: "POST",
            data: {SerialNumber: serial_number},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'exist'){
                    $('#Devices_serial_number').focus();
                    $('#Devices_serial_number_em_').show().html('This device exist');
                    $('#btnSave').attr('disabled','disabled').attr('class','btn');
                } else {
                    $('#btnSave').removeAttr('disabled').attr('class','btn btn-primary');;
                }
            }
        });
    }
}