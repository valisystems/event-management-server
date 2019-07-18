$(document).ready(function(){
    $(document).ready($(function () { 
        $("[data-toggle='popover']").popover({"html":true, "trigger":"hover"});
        $(".popover").css("max-width", "750px"); 
    }));
    
});
function manageAppendTr(vv){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var data = $(vv).attr('id_building');
    var url = $(vv).attr('urlToGet');
    var toRemove = $(vv).attr('toremove');
    var activLink = vv;
    //var url = '';
    if (toRemove == 'no') {
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(html){
                var new_data = "<tr id='append_"+data+"'><td colspan='4' style='text-align:center;background-color:#E9EBEC;'>"+ html +"</td></tr>";
                $('#tr_'+data).after(new_data);
                $("[data-toggle='popover']").popover({"html":true, "trigger":"hover"});
                $(".popover").css("max-width", "750px"); 
                $(activLink).find('i').attr('class','fa fa-caret-square-o-down');
                $(activLink).attr('toremove', 'yes');
            }
        });
    } else if (toRemove == 'yes') {
        $('#append_'+data).remove();
        $(activLink).attr('toremove', 'no');
        $(activLink).find("i").attr('class','fa fa-caret-square-o-right');
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function manageEmaps(){
   $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
   var dataForm = $('#maps-form').serialize();
   var urlAction = $('#maps-form').attr('action');
    
    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(data){                                                        
             //Do stuff here on success such as modal info      
             //$( this ).dialog( "close" );
             if (data.status == 'success') {
                 //alert('Success')
                 $('#manageEmaps2').dialog('close');
                 populateBuildingsFloor(data.id_building);
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function submitUpdateFloor(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#maps-form').serialize();
    var urlAction = $('#maps-form').attr('action');
    
    $.ajax({
        url: urlAction,                   //
        timeout: 30000,
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(data){                                                        
             //Do stuff here on success such as modal info      
             //$( this ).dialog( "close" );
             if (data.status == 'success') {
                 var idBuilding = data.id_building;
                 populateBuildingsFloor(idBuilding);
                 $('#updateEmap').dialog('close');
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function updateFloorDialog(id_map){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var url = "/admin/buildings/updateFloor/id/"+id_map;
    $.get(url, function(r){
        $("#updateEmap").html(r).dialog("open");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function deleteFloor(id_map, idBuilding, delMsg) {
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    if (confirm(delMsg)) {
        var url = '/admin/buildings/deleteFloor/id/'+id_map;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(dd){
                if (dd.status == 'success') {
                    populateBuildingsFloor(idBuilding);
                    /*var urlToRefresh = '/admin/buildings/viewflors/';
                    jQuery.ajax({
                        'type':'post',
                        //'data':data,
                        'url':urlToRefresh,
                        'cache':false,
                        'success':function(html){
                            $('#append_'+idBuilding).remove();
                            var new_data = "<tr id='append_"+idBuilding+"'><td colspan='4' style='text-align:center;background-color:#BFE9FC;'>"+ html +"</td></tr>";
                            $('#tr_'+idBuilding).after(new_data);
                            $("[data-toggle='popover']").popover({"html":true, "trigger":"hover"});
                            $(".popover").css("max-width", "750px"); 
                            $('#updateEmap').dialog('close');
                        }
                    });*/
                }
            }
        });
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function populateBuildingsFloor(idBuilding){
    $('a[id_building="'+idBuilding+'"]').each(function() {
        $('#append_'+idBuilding).remove();
        var url = '/admin/buildings/viewflors/id/'+idBuilding;
        var aActive = this;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(html){
                $('#append_'+idBuilding).remove();
                var new_data = "<tr id='append_"+idBuilding+"'><td colspan='4' style='text-align:center;background-color:#BFE9FC;'>"+ html +"</td></tr>";
                $('#tr_'+idBuilding).after(new_data);
                $("[data-toggle='popover']").popover({"html":true, "trigger":"hover"});
                $(".popover").css("max-width", "750px");
                $(aActive).find('i').attr('class','fa fa-caret-square-o-down');
                $(aActive).attr('toremove', 'yes'); 
            }
        });
        // `this` is the div
    });  
}