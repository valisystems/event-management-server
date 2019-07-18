/**
 * Created by iurik on 8/3/15.
 */
$(document).ready($(function () {
    $('[data-rel="chosen"],[rel="chosen"]').chosen();
    $('#MaxivoxDevice_dev_desc').keyup(function() {
        if (typeof($('#devicePosition')) != "undefined") {
            $('#devicePosition').html($(this).val());
        }
    });
    $('#MaxivoxDevice_dev_address').blur(function(){
        verifySerialNumberIsUnique();
    });
}));

var x1 = x2 = y1 = y2 = xTmp = yTmp = 0;

function getMapImage(idMap){
    $.ajax({
        url: '/admin/maxivoxDevice/floorInfo/id/'+idMap,                   //
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
            $("#MaxivoxDevice_dev_desc").keyup();
        }
    });
}
$('#MaxivoxDevice_id_room').change(function(){
    if($(this).val() != "") {
        $.ajax({
            url: '/admin/maxivoxDevice/roomCoordonate/id/' + $(this).val(),                   //
            timeout: 30000,
            type: "POST",
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
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
                x1, x2, y1, y2 = yTmp = xTmp = 0;
                for (var i = 0; i < (coordonateArray.length / 2); i++) {
                    //console.log('i = ',i,' X = ',coordonateArray[i], 'Y = ', coordonateArray[i+1])
                    if (i == 0) {
                        x1 = x2 = xTmp = coordonateArray[i * 2];
                        y1 = y2 = yTmp = coordonateArray[i * 2 + 1];
                    }
                    if (i > 0) {
                        if (x1 > coordonateArray[i * 2]) {
                            x1 = coordonateArray[i * 2];
                        }
                        if (y1 < coordonateArray[i * 2 + 1]) {
                            y1 = coordonateArray[i * 2 + 1];
                        }

                        if (x2 < coordonateArray[i * 2]) {
                            x2 = coordonateArray[i * 2];
                        }
                        if (y2 > coordonateArray[i * 2 + 1]) {
                            y2 = coordonateArray[i * 2 + 1];
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
                var widthImg = 0;

                widthImg = $('canvas').attr('width');
                var heightImg = 0;
                heightImg = $('canvas').attr('height');

                console.log('widthImg =', widthImg, ' Height = ', heightImg);
                if (widthImg > 0 && heightImg > 0) {
                    $('#maps').attr('width', widthImg);
                    $('#maps').attr('height', heightImg);
                }
                $('#devicePosition').droppable({
                    accept: '#devicePosition',
                    hoverClass: "mapHover"
                });
                $('#devicePosition').mouseup(function () {
                    if ($('input:radio[name="MaxivoxDevice[comon_area]"]:checked').val() == 0) {
                        //console.log('x1=',x1, ' y1=', y1, ' x2 = ',x2, ' y2=',y2);
                        var pos = $(this).position();
                        var x1Pos = parseInt(pos.left) - 14;
                        var y1Pos = parseInt(pos.top) - 440;
                        //var x1Pos = parseInt(pos.left);
                        //var y1Pos = parseInt(pos.top);
                        //console.log('xD = ',x1Pos, ' yD = ',y1Pos);
                        if (x1Pos >= x1 && x1Pos <= x2 && y1Pos >= y2 && y1Pos <= y1) {

                        } else {
                            var convasPosition = $('canvas').offset();
                            $(this).offset({
                                left: parseInt(convasPosition.left) + xTmp,
                                top: parseInt(convasPosition.top) + yTmp
                            });
                            alert('Out of room area')
                        }
                    }
                });
            }
        });
    } else {
        $('#MaxivoxDevice_id_map').change();
    }
    //$("#MaxivoxDevice_dev_desc").keyup();
});

function verifySerialNumberIsUnique(){
    var serial_number = $('#MaxivoxDevice_dev_address').val();
    var id_device = "";//$('#id_device_update').val();
    if (serial_number != "" && id_device == '') {
        $.ajax({
            url: '/admin/maxivoxDevice/verifySerialNumber',                   //
            type: "POST",
            data: {SerialNumber: serial_number},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'exist'){
                    $('#MaxivoxDevice_dev_address').focus();
                    $('#MaxivoxDevice_dev_address_em_').show().html('This device exist');
                    $('#btnSave').attr('disabled','disabled').attr('class','btn');
                } else {
                    $('#btnSave').removeAttr('disabled').attr('class','btn btn-primary');;
                }
            }
        });
    }
}

function changeComonArea(vv){
    //alert($('input:radio[name="MaxivoxDevice[comon_area]"]:checked').val())
}
function manageEmaps(){
    if ($('#MaxivoxDevice_id_patient').val() != "") {
        var url = $('#patient-devices-form').attr('action');
        $.ajax({
            url: url,                   //
            timeout: 30000,
            type: "POST",
            data: 'id_patient='+$('#MaxivoxDevice_id_patient').val()+'&id_room='+$('#MaxivoxDevice_id_room').val(),
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