$(document).ready(function(){
    $("#SystemSmsNumbers_number_sms").mask("(999) 999-9999");
    setTimeout(function(){ 
        $(".alert").fadeOut("slow"); 
  }, 5000 ); 
});