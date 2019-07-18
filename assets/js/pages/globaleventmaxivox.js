$(document).ready(function(){
    setTimeout(function(){ 
        $(".alert").fadeOut("slow"); 
    }, 5000 ); 
    populateReceiver();
    
    $('#GlobalEventMaxivoxTemplate_auto_close').change(
        function(){
            changeAutoClose(this);
        }
    );
    changeAutoClose($('#GlobalEventMaxivoxTemplate_auto_close'));
    $("#GlobalEventMaxivoxTemplate_pick_event_type option[value='TRANSFER']").each(function() {
        $(this).remove();
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
        url: '/admin/globalEventMaxivoxTemplate/eventListByPick',             // указываем URL и
        type: "POST",
        data: 'pick_event_type='+$('#GlobalEventMaxivoxTemplate_pick_event_type').val()+'&emptyDiv=yes',                     // тип загружаемых данных
        success: function (data) { // вешаем свой обработчик на функцию success
            $("#divReceiver").append(data);
            $(document).ready(function() {
                $(".GlobalEventMaxivoxTemplate_receiver").unbind( "change" ).change(receiverAction);
            });
        }
    });
}

function delReceiver(vv) {
    $('#'+vv).remove();
}

function populateReceiver() {
    if (typeof(id_global_event_maxivox_template) != "undefined") {
        //alert('vasea')
        $.ajax({
            url: '/admin/globalEventMaxivoxTemplate/receiverList',             // указываем URL и
            type: "POST",
            data: 'id_global_event='+id_global_event_maxivox_template+'&pick_event_type='+$('#GlobalEventMaxivoxTemplate_pick_event_type').val(),                     // тип загружаемых данных
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
function receiverAction(){
    var pickEvent = $('#GlobalEventMaxivoxTemplate_pick_event_type').val();
    if (pickEvent == 'IOPOS'){
        var parrentDiv = $(this).closest('.receiver-list');
        $.ajax({
            url: '/admin/globalEventMaxivoxTemplate/commandList',             // указываем URL и
            type: "POST",
            success: function (dd) { // вешаем свой обработчик на функцию success
                parrentDiv.find('div.commandList').remove();
                parrentDiv.after(dd);
            }
        });
    }
}

