$(document).ready(function(){
    //$('#CallsType_color_hex').colorpicker();
    //$('.color').colorpicker();
    $('#colorPicker').tinycolorpicker();
    $('#PendantType_script').blur(function(){
        verifyPendantIsUnique();
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

function verifyPendantIsUnique(){
    var script = $('#PendantType_script').val();
    var old_script = $('#old_pendant_type').val();
    if (script != "" &&  old_script != script) {
        $.ajax({
            url: '/admin/pendantType/verifyPendant',                   //
            type: "POST",
            data: {PendantScript: script},
            datatype: 'json',
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("An error has occurred making the request: " + errorThrown)
            },
            success: function (dd) {
                if (dd == 'exist'){
                    $('#PendantType_script').focus();
                    $('#savePendantType').attr('disabled','disabled').attr('class','btn');
                    $('#PendantType_script_em_').show().html('This Pendant Type exist');
                }
                else {
                    $('#savePendantType').removeAttr('disabled').attr('class','btn btn-primary');;
                }
            }
        });
    }
}