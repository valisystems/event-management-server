/**
 * Created by iurik on 27/02/15.
 */
$(document).ready(function(){
    generalNotificationAdmin()
});
function generalNotificationAdmin(){
    $.ajax({
        url: '/admin/default/generationOfAllEvent',                   //
        type: "POST",
        datatype: 'json',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function (dd) {
            if (dd != ''){
                $('#headStatusBar').append(dd);
            }
        }
    });
}
