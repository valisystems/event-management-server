/**
 * Created by iurik on 1/14/16.
 */
$(document).ready(function(){
    if (typeof version_arr != "undefined"){
        var cc = 0;
        for (var prop in version_arr) {
            if (cc > 0) {
               $('#'+prop).attr('disabled', 'disabled');
            }
            cc++;
        }
    }
});