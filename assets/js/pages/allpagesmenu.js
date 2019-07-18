/**
 * Created by iurik on 11/13/15.
 */
function createModalLinkContent(contUrl, desc){
    $('#myModal').modal({
        keyboard: true,
        remote: contUrl
    });
    $('#myModal').find('.modal-title').html(desc);
    $('#myModal').find('.modal-body').find('iframe').attr('src',contUrl);
}

$(document).ready(function(){
    $('body').addClass('loaded');
});