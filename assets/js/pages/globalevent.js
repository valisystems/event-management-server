$(document).ready(function(){
    setTimeout(function(){ 
        $(".alert").fadeOut("slow"); 
    }, 5000 ); 
    populateReceiver();
    
    $('#GlobalEventTemplate_auto_close').change(
        function(){
            changeAutoClose(this);
        }
    );
    changeAutoClose($('#GlobalEventTemplate_auto_close'));
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
        url: '/admin/globalEventTemplate/eventListByPick',             // указываем URL и
        type: "POST",
        data: 'pick_event_type='+$('#GlobalEventTemplate_pick_event_type').val()+'&emptyDiv=yes',                     // тип загружаемых данных
        success: function (data) { // вешаем свой обработчик на функцию success
            $("#divReceiver").append(data);
            $(document).ready(function() {
                $(".GlobalEventTemplate_receiver").unbind( "change" ).change(receiverAction);
            });
        }
    });
}

function delReceiver(vv) {
    $('#'+vv).remove();
}

function populateReceiver() {
    if (typeof(id_global_event_template) != "undefined") {
        $.ajax({
            url: '/admin/globalEventTemplate/receiverList',             // указываем URL и
            type: "POST",
            data: 'id_global_event='+id_global_event_template+'&pick_event_type='+$('#GlobalEventTemplate_pick_event_type').val(),                     // тип загружаемых данных
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
    var pickEvent = $('#GlobalEventTemplate_pick_event_type').val();
    if (pickEvent == 'IOPOS'){
        var parrentDiv = $(this).closest('.receiver-list');
        $.ajax({
            url: '/admin/globalEventTemplate/commandList',             // указываем URL и
            type: "POST",
            success: function (dd) { // вешаем свой обработчик на функцию success
                parrentDiv.find('div.commandList').remove();
                parrentDiv.after(dd);
            }
        });
    }
}
