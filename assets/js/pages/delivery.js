$(document).ready(function(){
    $( "#tabs" ).tabs();

    $('#testEmailButton').click(function(){
        if ($('#your_email').val() == "") {
            $("#messagesTestMail").html("Enter e-mail in field").show();
            $("#messagesTestMail").addClass("alert alert-danger");
            $('#your_email').focus();
            setTimeout(function(){
                    $("#messagesTestMail").fadeOut("slow");
                    $("#messagesTestMail").removeClass("alert alert-danger");
                }, 8000
            );
            return false;
        }
        $("#ajax_loader").ajaxStart(function(){
            $(this).show();
        });
    });
    $("#your_sms").mask("(999) 999-9999");
    $('#testSMSButton').click(function(){
        if ($('#your_sms').val() == "") {
            $("#messagesTestSMS").html("Enter sms number in field").show();
            $("#messagesTestSMS").addClass("alert alert-danger");
            $('#your_sms').focus();
            setTimeout(function(){
                    $("#messagesTestSMS").fadeOut("slow");
                    $("#messagesTestSMS").removeClass("alert alert-danger");
                }, 8000
            );
            return false;
        }
        $("#ajax_loader").ajaxStart(function(){
            $(this).show();
        });
    });
});