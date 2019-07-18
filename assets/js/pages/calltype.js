$(document).ready(function(){
    //$('#CallsType_color_hex').colorpicker();
    //$('.color').colorpicker();
    $('#colorPicker').tinycolorpicker();
    $('#CallsType_script').blur(function(){
        verifyDTMFIsUnique();
    });
    //$('#saveCallType').click(function(){
    //    var script = $('#CallsType_script').val();
    //    if (script != "") {
    //        $.ajax({
    //            url: '/admin/callsType/verifyDtmf',                   //
    //            type: "POST",
    //            data: {DtmfScript: script},
    //            datatype: 'json',
    //            error: function (XMLHttpRequest, textStatus, errorThrown) {
    //                alert("An error has occurred making the request: " + errorThrown)
    //            },
    //            success: function (dd) {
    //                if (dd == 'exist'){
    //                    $('#CallsType_script').focus();
    //                    return false;
    //                } else {
    //                    return true;
    //                }
    //            }
    //        });
    //    }
    //});
});

function verifyDTMFIsUnique(){
    var script = $('#CallsType_script').val();
    var old_script = $('#old_call_type').val();
    if (script != "" &&  old_script != script) {
        $.ajax({
            url: '/admin/callsType/verifyDtmf',                   //
            type: "POST",
            data: {DtmfScript: script},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'exist'){
                    $('#CallsType_script').focus();
                    $('#saveCallType').attr('disabled','disabled').attr('class','btn');
                    $('#CallsType_script_em_').show().html('This Call Type exist');
                }
                else {
                    $('#saveCallType').removeAttr('disabled').attr('class','btn btn-primary');;
                }
            }
        });
    }
}