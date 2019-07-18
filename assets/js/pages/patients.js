$(document).ready(function(){
    //$('.cleditor').cleditor();
    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
    $(".popover").css("max-width", "750px");
    getPatientsTable();
});
function optionGroup(){
    //$('[data-rel="chosen"],[rel="chosen"]').chosen();
}
function getPatientInfo() {
    if ($(this).attr('url_info')) {
        alert($(this).attr('url_info'))
    }
    // show standard popover content
    return "";    
}
   
/**
* Camera URL START
*/
function addCameraUrl() {
    $.ajax({
        url: '/admin/patients/cameraUrl',             
        type: "JSON",
        success: function (data) { 
            $("#divCameraUrl").after(data);
        }
    });
}

function delCameraUrl(vv){
    $('#'+vv).remove();
}
/**
* Camera URL Stop
*/

/**
* Notes
*/
function addNotes(){
    $("#ajax_loader").ajaxStart(function(){
         $(this).show();
    }); 
    var url = '/admin/patients/addNotes';
    $.get(url, function(r){
        $("#addNotes").html(r).dialog("open");
        $('.notesEditor').cleditor();
        $('#PatientsNotes_id_patient').val($("#needInfo").attr('id_patient'));
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}

function addInsertNotes(){
    $("#ajax_loader").ajaxStart(function(){
         $(this).show();
    }); 
    var url = '/admin/patients/addInsertUpdateNotes';
    $.get(url, function(r){
        //$("#addNotes").html(r).dialog("open");
        $('#divNotes').append(r);
        $('.cleditor').cleditor();
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;   
}

function addNoteToDb(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#patients-form').serialize();
    var urlAction = $('#patients-form').attr('action');
    
    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){                                                        
             //Do stuff here on success such as modal info      
             //$( this ).dialog( "close" );
             if (dd.status == 'success') {
                $('#addNotes').dialog('close');
                var url = "/admin/patients/manageNotes/id/"+dd.id_patient;
                $.get(url, function(r){
                    $("#manageNotes").html(r);
                    $("[data-toggle='popover']").popover(
                        {
                            html:true, 
                            trigger:"hover",
                        }
                    );
                    $(".popover").css("max-width", "350px");
                });
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
  
/**
* Notes END
*/
function addEmergency(){
    var table = $('#tabEmergencyContact>tbody');
    var str = '';
    var today = new Date().getTime();
    str += "<tr id='"+ today +"'>";
    str += '<td><input type="text" id="Patients_em_name'+ today +'" name="Patients[emergency]['+ today +'][name_contact]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += '<td><input type="text" id="Patients_em_phone'+ today +'" name="Patients[emergency]['+ today +'][phone]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += '<td><input type="text" id="Patients_em_cel'+ today +'" name="Patients[emergency]['+ today +'][mobile]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += '<td><input type="text" id="Patients_em_email'+ today +'" name="Patients[emergency]['+ today +'][email]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += '<td><input type="text" id="Patients_em_sms'+ today +'" name="Patients[emergency]['+ today +'][sms]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += '<td><input type="text" id="Patients_em_login'+ today +'" name="Patients[emergency]['+ today +'][login_id]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += '<td><input type="password" id="Patients_em_pass'+ today +'" name="Patients[emergency]['+ today +'][passwd]" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
    str += "<td><a class='btn btn-xs btn-success' onClick='javascript:removeRow(this);'><i class='fa fa-trash-o'></i></a></td>";
    str += "</tr>";
    table.append(str);
    
}

function removeRow(vv, idEmergencyContact, delMsg) {
    if(typeof(idEmergencyContact)==='undefined') idEmergencyContact = -1;
    if(typeof(delMsg)==='undefined') delMsg = 'Are you sure you want to delete this item?';
    if (confirm(delMsg)) {
        //
        if (idEmergencyContact > 0) {
            $.ajax({
                url: '/admin/patients/deleteEmergencyContact',             
                type: "POST",
                data: "id_emergency_contact="+idEmergencyContact,
                success: function (dd) { 
                    if (dd.status == 'success') {
                        $(vv).parent().parent().remove();
                    }
                }
            });
        } else {
            $(vv).parent().parent().remove();
        }
    }
}

function populateUpdateForm(idPatient){
    $("#ajax_loader").ajaxStart(function(){
         $(this).show();
    }); 
    $('#avatrImg').html('<img class="img-responsive img-thumbnail" src="'+$('#Patients_avatar_path').val()+'">');
    $.ajax({
        url: '/admin/patients/getRoomInformation',             
        type: "POST",
        data: "id_patient="+idPatient,
        success: function (data) { 
            var json = jQuery.parseJSON(data);
            if(json.id_building) {
                $('#Patients_id_building').val(json.id_building).change();
                //alert(json.id_room)
                
                setTimeout(
                  function() 
                  {
                    $('#Patients_id_room').val(json.id_room);
                  }, 3000);
            }
            //$('#tabEmergencyContact tbody').html(data);
        }
    });
    $.ajax({
        url: '/admin/patients/getEmergencyContact',             
        type: "POST",
        data: "id_patient="+idPatient,
        success: function (data) { 
            $('#tabEmergencyContact tbody').html(data);
        }
    });
    $.ajax({
        url: '/admin/patients/getNotes',             
        type: "POST",
        data: "id_patient="+idPatient,
        success: function (data) { 
            //var jsonNotes = jQuery.parseJSON(data);
            //alert(jsonNotes[0]['file_url'])
            $('#notesList').html(data);
            $("[data-toggle='popover']").popover(
                {
                    html:true, 
                    trigger:"hover",
                }
            );
            $(".popover").css("max-width", "750px");
        }
    });
    $.ajax({
        url: '/admin/patients/getCameraUrl',             
        type: "POST",
        data: "id_patient="+idPatient,
        success: function (data) { 
            $('#urlList').html(data);
            $("[data-toggle='popover']").popover(
                {
                    html:true, 
                    trigger:"hover",
                }
            );
            $(".popover").css("max-width", "750px");
        }
    });

    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function editNotes(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#patients-form').serialize();
    var urlAction = $('#patients-form').attr('action');
    
    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){                                                        
             //Do stuff here on success such as modal info      
             //$( this ).dialog( "close" );
             if (dd.status == 'success') {
                $('#editNotes').dialog('close');
                var url = "/admin/patients/manageNotes/id/"+dd.id_patient;
                $.get(url, function(r){
                    $("#manageNotes").html(r);
                    $("[data-toggle='popover']").popover(
                        {
                            html:true, 
                            trigger:"hover",
                        }
                    );
                    $(".popover").css("max-width", "350px");
                });
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function updateNotes(id_patient_notes){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var url = "/admin/patients/updateNotes/id/"+id_patient_notes;
    $.get(url, function(r){
        $("#editNotes").html(r).dialog("open");
        $('.notesEditor').cleditor();
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
function deleteNotes(id_patient_notes, id_patient, delMsg) {
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    if (confirm(delMsg)) {
        var url = '/admin/patients/deleteNotes/id/'+id_patient_notes;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(dd){
                if (dd.status == 'success') {
                    var url = "/admin/patients/manageNotes/id/"+id_patient;
                    $.get(url, function(r){
                        $("#manageNotes").html(r);
                        $("[data-toggle='popover']").popover(
                            {
                                html:true, 
                                trigger:"hover",
                            }
                        );
                        $(".popover").css("max-width", "350px");
                    });
                }
            }
        });
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
var timer;
var imgUrl;
function openCameraView(urlCamera){
    $('#viewCamera').dialog("open");
    imgUrl = urlCamera;
    refreshImage();
}
function refreshImage(){
    var time = (new Date()).getTime();
    $('#viewCamera').fadeOut("slow").html('<img src="'+imgUrl+'?time='+time+'" border=0 width="320"/>').fadeIn("slow");;
    //console.log(time);
    timer = setTimeout("refreshImage()", 5000);
}
function stoper() {
	x = 0;
	clearTimeout(timer);
    imgUrl = '';
    console.log('Gata ='+imgUrl);
}

function openImportDiag(){
    $("#ajax_loader").ajaxStart(function(){
         $(this).show();
    }); 
    var url = '/admin/patients/formImportCSV';
    $.get(url, function(r){
        $("#importCSV").html(r).dialog("open");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}

function importCSV(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    var dataForm = $('#importCSVForm').serialize();
    var urlAction = $('#importCSVForm').attr('action');
    
    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){                                                        
             //Do stuff here on success such as modal info      
             //$( this ).dialog( "close" );
             if (dd.status == 'success') {
                $('#importCSV').dialog('close');
                location.reload(); 
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });   
}
function deleteUrlCameraFromUpdate(idCamera, idPatient, delMsg){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    if (confirm(delMsg)) {
        var url = '/admin/patients/delCamera/id/'+idCamera;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(dd){
                if (dd.status == 'success') {
                    $.ajax({
                        url: '/admin/patients/getCameraUrl',
                        type: "POST",
                        data: "id_patient="+idPatient,
                        success: function (data) {
                            $('#urlList').html(data);
                            $("[data-toggle='popover']").popover(
                                {
                                    html:true,
                                    trigger:"hover",
                                }
                            );
                            $(".popover").css("max-width", "750px");
                        }
                    });
                }
            }
        });
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    }); 
}

function removeNotesRow(idNotes, idPatient, delMsg){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    if (confirm(delMsg)) {
        var url = '/admin/patients/deleteNotes/id/'+idNotes;
        jQuery.ajax({
            'type':'post',
            //'data':data,
            'url':url,
            'cache':false,
            'success':function(dd){
                if (dd.status == 'success') {
                   $.ajax({
                        url: '/admin/patients/getNotes',             
                        type: "POST",
                        data: "id_patient="+idPatient,
                        success: function (data) { 
                            //var jsonNotes = jQuery.parseJSON(data);
                            //alert(jsonNotes[0]['file_url'])
                            $('#notesList').html(data);
                            $("[data-toggle='popover']").popover(
                                {
                                    html:true, 
                                    trigger:"hover",
                                }
                            );
                            $(".popover").css("max-width", "750px");
                        }
                    }); 
                }
            }
        });    
    }
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function editCamera(idCameraPatient){
    $("#ajax_loader").ajaxStart(function(){
         $(this).show();
    }); 
    
    var dialog = $( "#camEdit" ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Save": updateCamera,
            "Close": function() {
                dialog.dialog( "close" );
            }
        }
    });
    var url = '/admin/patients/formCameraEdit/id/'+idCameraPatient;
    $.post(url, function(r){
        $("#camEdit").html(r).dialog("open");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function updateCamera(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var dataForm = $('#cameraEdit').serialize();
    var urlAction = '/admin/patients/updateCamera';

    $.ajax({
        url: urlAction,                   //
        type: "POST",
        data: dataForm,
        datatype: 'json',
        //dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(dd){
            //Do stuff here on success such as modal info
            //$( this ).dialog( "close" );
            if (dd.status == 'success') {
                $('#camEdit').dialog('close');
                $.ajax({
                    url: '/admin/patients/getCameraUrl',
                    type: "POST",
                    data: "id_patient="+dd.id_patient,
                    success: function (data) {
                        $('#urlList').html(data);
                        $("[data-toggle='popover']").popover(
                            {
                                html: true,
                                trigger: "hover"
                            }
                        );
                        if (dd.status == 'success') {

                            var html = '<div class="row">';
                            html += '<div class="alert alert-success">Update successfuly</div>';
                            html += '</div>';
                        } else {
                            var html = '<div class="row">';
                            html += '<div class="alert alert-danger">Update failed</div>';
                            html += '</div>';
                        }
                        $('#urlList').before(html);
                        $(".popover").css("max-width", "750px");
                        setTimeout(function(){
                            $(".alert").fadeOut("slow");
                        }, 5000 );
                    }
                });
            }
        }
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

/*
Tabularea Paginii
 */


function resetActive(event, percent, step) {
    /*$(".progress-bar").css("width", percent + "%").attr("aria-valuenow", percent);
    $(".progress-completed").text(percent + "%");
    */

    $("div").each(function () {
        if ($(this).hasClass("activestep")) {
            $(this).removeClass("activestep");
        }
    });

    if (event.target.className == "col-md-2") {
        $(event.target).addClass("activestep");
    }
    else {
        $(event.target.parentNode).addClass("activestep");
    }

    hideSteps();
    showCurrentStepInfo(step);
    $('.cleditor').each(function(){
        $(this).cleditor()[0].refresh();
    });
    //$('.cleditor').cleditor()[0].refresh();

}

function hideSteps() {
    $("div").each(function () {
        if ($(this).hasClass("activeStepInfo")) {
            $(this).removeClass("activeStepInfo");
            $(this).addClass("hiddenStepInfo");
        }
    });
}

function showCurrentStepInfo(step) {
    var id = "#" + step;
    $(id).addClass("activeStepInfo");
    //$('.cleditor').cleditor();
}
$(document).ready(function() {

});

function getPatientsTable() {
    var urlAction = "/admin/patients/informations";
    var patients = $('#resultPatient').dataTable({
        "paging": true,
        "ordering": true,
        "hover": true,
        "info": false,
        "processing": true,
        "serverSide": true,
        //"filter": false,
        "stateSave": true,
        "destroy": true,
        "ajax": {
            "url": urlAction,
            "type": "POST",
            "datatype": 'json',
            "searching": true,
            "data": function (d) {
                d.id_building = id_building;
                d.id_map = id_map;
            },
            "columns": [
                {"data": "time"},
                {"data": "deviceDesc"},
                {"data": "patient"},
                {"data": "room"},
                {"data": "receiver"},
                {"data": "serialNumber"},
                {"data": "code"},
                {"data": "typeNotif"}
            ]
        }
    });
    $('#resultPatient').removeClass('display').addClass('table table-striped table-bordered hover');
    $(document).ready(function() {
        $("[data-toggle='popover']").popover(
            {
                html:true,
                trigger:"hover"
            }
        );
        $(".popover").css("max-width", "750px");
    });
}

function manageNotes(vv) {
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var url = $(vv).attr('url');
    $.get(url, function(r){
        $("#manageNotes").html(r).dialog("open");
        $("[data-toggle='popover']").popover(
            {
                html:true,
                trigger:"hover"
            }
        );
        var urlAux = url.split('/');
        $("#needInfo").attr('id_patient',urlAux[urlAux.length -1]);
        $(".popover").css("max-width", "350px");
    });
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
    return false;
}