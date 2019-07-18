$(document).ready(function(){
    $('.cleditor').cleditor();
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px"); 
    setTimeout(function(){ 
        $(".alert").fadeOut("slow"); 
    }, 5000 ); 
});