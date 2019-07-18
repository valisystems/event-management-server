/**
 * Created by iurik on 3/10/15.
 */
$(document).ready(function(){
    disabledBuildings();
    //$('[data-rel="chosen"],[rel="chosen"]').chosen();
});


function disabledBuildings() {
    $("#ajax_loader").ajaxStart(function () {
        $(this).show();
    });
    var url = "/admin/asterisk/disabledBuildings";
    jQuery.ajax({
        'type': 'post',
        'datatype': 'json',
        'url': url,
        'cache': false,
        'success': function (dd) {
            //var jsonExt = JSON.parse(dd);
            var disableButton = true;
            var key;
            //alert(dd.length)
            for(key in dd) {
               if(dd[key] == 'n'){
                   disableButton = false;
               }
            }
            if (typeof($('#Asterisk_id_building')) != 'undefined'){
                for(var key in dd) {
                    if(dd[key] == 'y'){
                        if ($('#id_building_old').val() == '') {
                            $("#Asterisk_id_building option[value='" + key + "']").remove();
                        } else if ($('#id_building_old').val() != "" && $('#id_building_old').val() != key) {
                            $("#Asterisk_id_building option[value='" + key + "']").remove();
                        }
                    }
                }
            }
            if (disableButton && typeof ($('#createNodes')) != 'undefined'){
                $('#createNodes').attr('disabled', 'disabled');
            } else if (!disableButton && typeof ($('#createNodes')) != 'undefined') {
                $('#createNodes').removeAttr('disabled');
            }
        }
    });
    $("#ajax_loader").ajaxStop(function () {
        $(this).hide();
    });
}

function copyNodesInfo(){
    var id_nodes = $('#existing_nodes').val();
    if( id_nodes != "") {
        if (nodesArray[id_nodes].length > 0)
        $('#Asterisk_asterisk_name').val(nodesArray[id_nodes][0]);
        $('#Asterisk_asterisk_url').val(nodesArray[id_nodes][1]);
        $('#Asterisk_voip_url').val(nodesArray[id_nodes][2]);
    } else {
        $('#Asterisk_asterisk_name').val('');
        $('#Asterisk_asterisk_url').val('');
        $('#Asterisk_voip_url').val('');
    }
}