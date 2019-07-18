/**
 * Created by iurik on 21.01.15.
 */
$(document).ready(function() {
    $(document).on("click", '.btn-minimize', function (e) {
        e.preventDefault();
        var $target = $(this).parent().parent().next('.box-content');
        if ($target.is(':visible')) {
            //alert($('i', $(this)).attr('class'))
            $('i', $(this)).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
        else {
            //alert($('i', $(this)).attr('class')+' 2')
            $('i', $(this)).removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
        $target.slideToggle();
    });
});

function saveAccessRules(){
    var url = $('#users-rules').attr('action');
    var formData = $('#users-rules').serialize();
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    $.ajax({
        url: url,                   //
        timeout: 30000,
        type: "POST",
        data: formData,
        dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            if (dd.status == 'y'){
                $("#messages").html(dd.msg).show();
                $("#messages").addClass("alert alert-success");
                setTimeout(function(){
                        $("#messages").fadeOut("slow");
                        $("#messages").removeClass("alert alert-success");
                    }, 5000
                );
            } else {
                $("#messages").html(dd.msg).show();
                $("#messages").addClass("alert alert-danger");
                setTimeout(function(){
                        $("#messages").fadeOut("slow");
                        $("#messages").removeClass("alert alert-danger");
                    }, 8000
                );
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function saveBuildingRules(){
    var url = $('#buildings-rules').attr('action');
    var formData = $('#buildings-rules').serialize();
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    $.ajax({
        url: url,                   //
        timeout: 30000,
        type: "POST",
        data: formData,
        dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            if (dd.status == 'y'){
                $("#messages").html(dd.msg).show();
                $("#messages").addClass("alert alert-success");
                setTimeout(function(){
                        $("#messages").fadeOut("slow");
                        $("#messages").removeClass("alert alert-success");
                    }, 5000
                );
            } else {
                $("#messages").html(dd.msg).show();
                $("#messages").addClass("alert alert-danger");
                setTimeout(function(){
                        $("#messages").fadeOut("slow");
                        $("#messages").removeClass("alert alert-danger");
                    }, 8000
                );
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}