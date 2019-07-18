$(document).ready(function(){
    setTimeout(function(){ 
        $(".alert").fadeOut("slow"); 
    }, 5000 ); 
    populateReceiver();
    
    $('#GlobalEventPendantTemplate_auto_close').change(
        function(){
            changeAutoClose(this);
        }
    );
    changeAutoClose($('#GlobalEventPendantTemplate_auto_close'));
    $("#GlobalEventPendantTemplate_pick_event_type option[value='TRANSFER']").each(function() {
        $(this).remove();
    });
    $('#GlobalEventPendantTemplate_pick_event_type').on('change',function(){
        var pickEvent =  $(this).val();
        //if (pickEvent == 'IOPOS')
    });

});

function changeAutoClose(vv){
    if ($(vv).val() ==  'Y') {
        $('#divAutoCloseTime').show();
    } else {
        $('#divAutoCloseTime').hide();
    }
}
function addReceiver(){
    $.ajax({
        url: '/admin/globalEventPendantTemplate/eventListByPick',             // указываем URL и
        type: "POST",
        data: 'pick_event_type='+$('#GlobalEventPendantTemplate_pick_event_type').val()+'&emptyDiv=yes',                     // тип загружаемых данных
        success: function (data) { // вешаем свой обработчик на функцию success
            $("#divReceiver").append(data);
            $(document).ready(function() {
                $(".GlobalEventPendantTemplate_receiver").unbind( "change" );
                $(".GlobalEventPendantTemplate_receiver").change(receiverAction);
            });
        }
    });
}

function delReceiver(vv) {
    $('#'+vv).remove();
}

function populateReceiver() {
    if (typeof(id_global_event_pendant_template) != "undefined") {
        $.ajax({
            url: '/admin/globalEventPendantTemplate/receiverList',             // указываем URL и
            type: "POST",
            data: 'id_global_event='+id_global_event_pendant_template+'&pick_event_type='+$('#GlobalEventPendantTemplate_pick_event_type').val(),                     // тип загружаемых данных
            success: function (data) { // вешаем свой обработчик на функцию success
                $("#divReceiver").append(data);

                $('div.commandList').each(function(){
                    var parrentDiv = $(this).closest('.receiver-list');
                    parrentDiv.after($(this).html());
                    $(this).remove();
                });
            }
        });
    }
}
var counter = 0;
function receiverAction(){
    var pickEvent = $('#GlobalEventPendantTemplate_pick_event_type').val();
    if (pickEvent == 'IOPOS'){
        var parrentDiv = $(this).closest('.receiver-list');
        $.ajax({
            url: '/admin/globalEventPendantTemplate/commandList',             // указываем URL и
            type: "POST",
            success: function (dd) { // вешаем свой обработчик на функцию success
                //parrentDiv.children("div[class*='.commandList']").remove();
                //parrentDiv.children("div[class*='.commandList']").css('background-color','red');
                //$("div[class*='.commandList']",parrentDiv).remove();
                //$("div[class*='.commandList']",parrentDiv).css('background-color','red');
                console.log('suntem aici');
                parrentDiv.children('div').attr('data-command-list').css('background-color','red');
                parrentDiv.after(dd);
            }
        });
    }
}

