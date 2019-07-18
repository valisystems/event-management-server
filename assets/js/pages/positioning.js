$(document).ready(function(){

    $("[data-toggle='popover']").popover({"html":true, "trigger":"hover", "delay": { "show": 500, "hide": 2000 }});
    $(".popover").css("max-width", "750px");
        setTimeout(function(){ 
        $(".alert").fadeOut("slow"); 
    }, 5000 );
    $('[data-rel="chosen"],[rel="chosen"]').chosen();
    $('#Positioning_device_description').keyup(function() {
        if (typeof($('#devicePosition')) != "undefined") {
            $('#devicePosition').html($(this).val());
        }
    });

    $('#Positioning_id_building').change(function(){
        $.ajax({
            url: '/admin/positioning/floorList',                   //
            timeout: 30000,
            data:{id_building:$(this).val()},
            type: "POST",
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(dd){
                //Do stuff here on success such as modal info
                //$( this ).dialog( "close" );
                $('#Positioning_id_map').html(dd);
                $('#Positioning_id_map').trigger("chosen:updated");
            }
        });
    });

    if ($("#Positioning_id_map").val() > 0) {
        //$("#Positioning_id_map").change();
        setTimeout(function(){}, 3000);
        var coordonate = $('#coordinate_on_map').val().split(';');
        var l = $("#roomConstruction");
        var pos = l.offset();
        var newPositionTop = parseInt(coordonate[1]) + parseInt(pos.top);
        var newPositionLeft = parseInt(coordonate[0]) + parseInt(pos.left);
        //$('#devicePosition').html($('#Devices_device_description').val());
        $("#devicePosition" ).offset({top:newPositionTop, left: newPositionLeft});
    }
    $('#Positioning_serial_number').blur(function(){
        verifySerialNumberIsUnique();
    });

    $('.id_in_dev_edit').editable();
});


function getMapImage(idMap){
    $.ajax({
            url: '/admin/positioning/floorInfo/id/'+$(idMap).val(),                   //
            timeout: 30000,
            type: "POST",
            error: function(XMLHttpRequest, textStatus, errorThrown)  {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function(dd){                                                        
                 //Do stuff here on success such as modal info      
                     //$( this ).dialog( "close" );
                $('#maps').html(dd);
            }
    });
}

function changePositionOfDev(leftPos, topPos){
}

function verifySerialNumberIsUnique(){
    var serial_number = $('#Positioning__serial_number').val();
    var id_device = $('#id_device_update').val();
    if (serial_number != "" && id_device == '') {
        $.ajax({
            url: '/admin/positioning/verifySerialNumber',                   //
            type: "POST",
            data: {SerialNumber: serial_number},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'exist'){
                    $('#Positioning_serial_number').focus();
                    $('#Positioning_serial_number_em_').show().html('This device exist');
                    $('#btnSave').attr('disabled','disabled').attr('class','btn');
                } else {
                    $('#btnSave').removeAttr('disabled').attr('class','btn btn-primary');;
                }
            }
        });
    }
}


/*
 Tabularea Paginii
 */


function resetActive(event, percent, step) {
    /*$(".progress-bar").css("width", percent + "%").attr("aria-valuenow", percent);
     $(".progress-completed").text(percent + "%");
     */

    $("div").each(function () {
        if ($(this).hasClass("activestep")) {
            $(this).removeClass("activestep");
        }
    });

    if (event.target.className == "col-md-2") {
        $(event.target).addClass("activestep");
    }
    else {
        $(event.target.parentNode).addClass("activestep");
    }

    hideSteps();
    showCurrentStepInfo(step);
    $('.cleditor').each(function(){
        $(this).cleditor()[0].refresh();
    });
    //$('.cleditor').cleditor()[0].refresh();

}

function hideSteps() {
    $("div").each(function () {
        if ($(this).hasClass("activeStepInfo")) {
            $(this).removeClass("activeStepInfo");
            $(this).addClass("hiddenStepInfo");
        }
    });
}

function showCurrentStepInfo(step) {
    var id = "#" + step;
    $(id).addClass("activeStepInfo");
    //$('.cleditor').cleditor();
}


$(document).ready(function(){
    var inputIndex = 0;

    $('#devices-form')
    .on('click', '.addButton', function(){
        inputIndex++;
        var template = $('#ioTemplate'),
            clone = template.clone()
                .removeClass('hide')
                .removeAttr('id')
                .attr('data-io-index', inputIndex)
                .insertBefore('#ioTemplate');
        clone
            .find('[name="io_name"]').attr('name', 'io['+inputIndex+'][io_name]').end()
            .find('[name="io_id"]').attr('name', 'io['+inputIndex+'][io_id]').end();

    })
    .on('click', '.removeButton', function() {
        var $row  = $(this).parents('.io-form-group'),
            index = $row.attr('data-io-index');

        // Remove element containing the fields
        $row.remove();
    });

});

function deleteIO(vv, id_device) {
    var ioDev = $(vv);

    if (id_device > 0) {
        $.ajax({
            url: '/admin/positioning/removeIODevice',                   //
            type: "POST",
            data: {id_io_device: id_device},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'yes') {
                    var row = ioDev.parents('tr');
                    row.remove();
                } else {
                    alert('Device not deleted. Have any problems')
                }
            }
        });
    }

}