/**
 * Created by iurik on 4/22/16.
 */
function generateUrl(){
    var typeUrl = $('#HttpInventory_type_of_url').val();
    var html= '';
    $('#myModalHttp .modal-dialog').removeClass('modal-sm');
    $('#myModalHttp .modal-dialog').addClass('modal-sm');

    if (typeUrl == "") return false;
    switch (typeUrl){
        case "3cx":
            $('#myModalTitle').html('3cx Urls');
            $('#myModalHttp .modal-body').empty();
            $('#myModalHttp .modal-body').append("<form method='post' action='#'><div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Remote Address</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='addressServer' value='' id='addressServer' class='form-control' style='width: 250px;' placeholder='https://vodia.server' />" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Call From</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='call_from' value='' id='call_from' class='form-control' style='width: 250px;' placeholder='107' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Extension Password</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='ext_password' value='' id='ext_password' class='form-control' style='width: 250px;' placeholder='987654321' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Call To</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='call_to' value='' id='call_to' class='form-control' style='width: 250px;' placeholder='130' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div></form> ");


            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>URL Encode</label>" +
            "<div class='input-group'>" +
            "<input type='checkbox' name='urlencode' id='urlencode' value='1' style='width: 250px;'/>" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#btnGenerate').on('click', function (){generateURLToCall('3cx')});
            break;
        case "pbx":
            $('#myModalTitle').html('snomONE PBX');
            $('#myModalHttp .modal-body').empty();

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Remote Address</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='address' value='' id='address' class='form-control' style='width: 250px;' placeholder='https://pbxnsip.server' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Extension Call From</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='call_from' value='' id='call_from' class='form-control' style='width: 250px;' placeholder='107@office.claricomip.com' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Extension Authentification</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='ext_auth' value='' id='ext_auth' class='form-control' style='width: 250px;' placeholder='207@office.claricomip.com' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Extension Authentification Password</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='ext_password' value='' id='ext_password' class='form-control' style='width: 250px;' placeholder='987654321' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Call To</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='call_to' value='' id='call_to' class='form-control' style='width: 250px;' placeholder='130' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");


            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>URL Encode</label>" +
            "<div class='input-group'>" +
            "<input type='checkbox' name='urlencode' id='urlencode' value='1' style='width: 250px;'/>" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#btnGenerate').on('click', function (){generateURLToCall('pbx')});
            break;
        case "vodia":
            $('#myModalTitle').html('Vodia');
            $('#myModalHttp .modal-body').empty();

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Remote Address</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='address' value='' id='address' class='form-control' style='width: 250px;' placeholder='https://pbxnsip.server' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Call From</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='call_from' value='' id='call_from' class='form-control' style='width: 250px;' placeholder='107@office.claricomip.com' />" +
            "" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Call To</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<input type='text' name='call_to' value='' id='call_to' class='form-control' style='width: 250px;' placeholder='130' />" +
            "</div>" +
            "</div>" +
            "</div>");


            $('#myModalHttp .modal-body').append("<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>URL Encode</label>" +
            "<div class='input-group'>" +
            "<input type='checkbox' name='urlencode' id='urlencode' value='1' style='width: 250px;'/>" +
            "</div>" +
            "</div>" +
            "</div>");

            $('#btnGenerate').on('click', function (){generateURLToCall('vodia')});
            break;
        case "custom":
            $('#myModalTitle').html('Custom');
            $('#myModalHttp .modal-body').empty();
            $('#myModalHttp .modal-dialog').addClass('modal-lg');
            var html;
            html = "<div class='row'>" +
            "<div class='col-lg-6'>" +
                "<label class='control-label'>Authentification method:</label>" +
                "<div class='input-group date'>" +
                    "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
                    "<select name='auth_method' id='auth_method' class='form-control' style='width: 250px;' onchange='changeAuthMethod(this);'>" +
                    "<option value=''>-- Choose authentification method --</option>" +
                    "<option value='basic'>Basic</option>" +
                    "<option value='cloud'>Rackspace Cloud Big Data 2.0</option>" +
                    "<option value='dns'>DNS Made Easy</option>" +
                    "</select>" +
                "</div>" +
            //"</div>" +
            "</div>";

            html += "" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Username:</label>" +
            "<div class='input-group'>" +
            "<input type='text' name='username' value='' id='username' class='form-control' style='width: 250px;' placeholder='Username' />" +
            "</div>" +
            "</div>" +
            "</div>";

            html += "<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Password:</label>" +
            "<div class='input-group'>" +
            "<input type='password' name='passwd' value='' id='passwd' class='form-control' style='width: 250px;'/>" +
            "</div>" +
            "</div>";

            html += "" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Password (repeat):</label>" +
            "<div class='input-group'>" +
            "<input type='password' name='passwdrep' value='' id='passwdrep' class='form-control' style='width: 250px;'/>" +
            "</div>" +
            "</div>" +
            "</div>";


            html += "<div class='row'>" +
            "<div class='col-lg-6' id='divRegion' style='display: none'>" +
            "<label class='control-label'>Region:</label>" +
            "<div class='input-group'>" +
            "<input type='text' name='region' value='' id='region' class='form-control' style='width: 250px;' placeholder='Region' />" +
            "</div>" +
            "</div>";

            html += "" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Method:</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<select name='send_method' id='send_method' class='form-control' style='width: 250px;'>" +
            "<option value=''>-- Choose Action methode --</option>" +
            "<option value='get'>GET</option>" +
            "<option value='post'>POST</option>" +
            "<option value='put'>PUT</option>" +
            "<option value='delete'>DELETE</option>" +
            "</select>" +
            "</div>" +
            "</div>" +
            "</div>";

            html += "<div class='row'>" +
            "<div class='col-lg-12'>" +
            "<label class='control-label'>URL:</label>" +
            "<div class='form-group'>" +
            "<input type='text' name='url' value='' id='url' class='form-control' placeholder='https://' />" +
            "</div>" +
            "</div>" +
            "</div>";

            html += "<div class='row'>" +
            "<div class='col-lg-4'>" +
            "<label class='control-label'>Additional Headers Parameters:</label>" +
            "<div class='input-group'>" +
            "<input type='text' name='aditional_head_param[]' value='' class='form-control aditional_head_param' style='width: 250px;' placeholder='' />" +
            "</div>" +
            "</div>";

            html += "" +
            "<div class='col-lg-4'>" +
            "<label class='control-label'>Additional Headers Values:</label>" +
            "<div class='input-group'>" +
            "<input type='text' name='aditional_head_value[]' value='' class='form-control aditional_head_value' style='width: 250px;' placeholder='' />" +
            "</div>" +
            "</div>";
            html += "" +
            "<div class='col-lg-2'>" +
            "<label class='control-label'>&nbsp;</label>" +
            "<div class='input-group'>" +
            "<button type='button' class='btn btn-success' onclick='javascript:addAditionalHeader(this)' id='firstAddButton'><i class='fa fa-plus-circle' aria-hidden='true'></i></button>" +
            "</div>" +
            "</div>" +
            "</div><hr/>";

            html += "<div class='row'>" +
            "<div class='col-lg-4'>" +
            "<label class='control-label'>Additional Variable Name:</label>" +
            "<div class='input-group'>" +
            "<input type='text' name='aditional_variable_param[]' value='' class='form-control aditional_variable_param' style='width: 250px;' placeholder='' />" +
            "</div>" +
            "</div>";

            html += "" +
            "<div class='col-lg-4'>" +
            "<label class='control-label'>Additional Variable Values:</label>" +
            "<div class='input-group'>" +
            "<input type='text' name='aditional_variable_value[]' value='' class='form-control aditional_variable_value' style='width: 250px;' placeholder='' />" +
            "</div>" +
            "</div>";
            html += "" +
            "<div class='col-lg-2'>" +
            "<label class='control-label'>&nbsp;</label>" +
            "<div class='input-group'>" +
            "<button type='button' class='btn btn-success' onclick='javascript:addAditionalVariable(this)' id='secondAddButton'><i class='fa fa-plus-circle' aria-hidden='true'></i></button>" +
            "</div>" +
            "</div>" +
            "</div><hr/>";

            html += "<div class='row'>" +
            "<div class='col-lg-6'>" +
            "<label class='control-label'>Encoding for the message body:</label>" +
            "<div class='input-group date'>" +
            "<span class='input-group-addon'><i class='fa  fa-history'></i></span>" +
            "<select name='enconding_message' id='enconding_message' class='form-control' style='width: 250px;'>" +
            "<option value=''>-- Choose encoding method --</option>" +
            "<option value='json'>JSON</option>" +
            "<option value='xml'>XML</option>" +
            "<option value='url'>URL</option>" +
            "<option value='ascii'>ASCII</option>" +
            "</select>" +
            "</div>" +
            "</div>" +
            "</div>";

            html += "<div class='row'>" +
            "<div class='col-lg-12'>" +
            "<label class='control-label'>Message body:</label>" +
            "<div class='form-group'>" +
            "<textarea name='message_body' value='' id='message_body' class='form-control' placeholder='https://' ></textarea>" +
            "</div>" +
            "</div>" +
            "</div>";

            $('#myModalHttp .modal-body').append(html);

            $('#btnGenerate').on('click', function (){generateURLToCall('custom')});
            break;

    }

    $('body').append($('#myModalHttp'));
    $('#myModalHttp').modal('show');
}
function generateURLToCall(act){
    switch (act){
        case "3cx":
            var addressToServer;
            $("input[name=addressServer]").each(function () {
                addressToServer = $(this).val();
            });
            var call_from;
            $("input[name=call_from]").each(function () {
                call_from = $(this).val();
            });

            var ext_password;
            $("input[name=ext_password]").each(function () {
                ext_password = $(this).val();
            });

            var call_to;
            $("input[name=call_to]").each(function () {
                call_to = $(this).val();
            });

            // https:localhost:5000/ivr/PbxAPI.aspx?func=make_call&from=200&to=120&pin=
            var url = '';
            $('#HttpInventory_urlencode').val('0');

            if ($("input[name=urlencode]").is(':checked'))
            {
                url = addressToServer + "/ivr/PbxAPI.aspx?"+encodeURIComponent("func=make_call&from=" + call_from + "&to=" + call_to + "&pin="+ext_password);
                $('#HttpInventory_urlencode').val('1');
            } else {
                url =addressToServer + "/ivr/PbxAPI.aspx?func=make_call&from=" + call_from + "&to=" + call_to + "&pin="+ext_password;
            }

            $('#HttpInventory_action_url').val(url);
            $('#myModalHttp').modal('hide')
            break;
        case "pbx":
            var addressToServer;
            $("input[name=address]").each(function () {
                addressToServer = $(this).val();
            });
            var call_from;
            $("input[name=call_from]").each(function () {
                call_from = $(this).val();
            });

            var ext_auth;
            $("input[name=ext_auth]").each(function () {
                ext_auth = $(this).val();
            });


            var ext_password;
            $("input[name=ext_password]").each(function () {
                ext_password = $(this).val();
            });

            var call_to;
            $("input[name=call_to]").each(function () {
                call_to = $(this).val();
            });

            var url = '';
            $('#HttpInventory_urlencode').val('0');

            if ($("input[name=urlencode]").is(':checked'))
            {
                url = addressToServer + "/remote_call.htm?"+encodeURIComponent("user="+ call_from +"&auth=" + ext_auth + ":" + ext_password +"&connect=true&dest=" + call_to);
                $('#HttpInventory_urlencode').val('1');
            } else {
                url = addressToServer + "/remote_call.htm?user="+ call_from +"&auth=" + ext_auth + ":" + ext_password +"&connect=true&dest=" + call_to;
            }

            $('#HttpInventory_action_url').val(url);
            $('#myModalHttp').modal('hide')
            break;
        case "vodia":
            var addressToServer;
            $("input[name=address]").each(function () {
                addressToServer = $(this).val();
            });
            var call_from;
            $("input[name=call_from]").each(function () {
                call_from = $(this).val();
            });

            var call_to;
            $("input[name=call_to]").each(function () {
                call_to = $(this).val();
            });

            // http://pbx/remote_call.htm?user=123&extension=true&dest=123456789&time=current_time&auth=hash
            var url = '';
            $('#HttpInventory_urlencode').val('0');

            if ($("input[name=urlencode]").is(':checked'))
            {
                url = addressToServer + "?src="+ encodeURIComponent(call_from +"&dst=" + call_to);
                $('#HttpInventory_urlencode').val('1');
            } else {
                url = addressToServer + "?src="+ call_from +"&dst=" + call_to;
            }

            $('#HttpInventory_action_url').val(url);
            $('#myModalHttp').modal('hide');
            break;
        case "custom":
            var auth_method;
            $("select[id=auth_method]").each(function () {
                auth_method = $(this).val();
            });
            var username;
            $("input[name=username]").each(function () {
                username = $(this).val();
            });

            var passwd;
            $("input[name=passwd]").each(function () {
                passwd = $(this).val();
            });
            var passwdrep;
            $("input[name=passwdrep]").each(function () {
                passwdrep = $(this).val();
            });

            var region;
            $("input[name=region]").each(function () {
                region = $(this).val();
            });
            var send_method;
            $("select[id=send_method]").each(function () {
                send_method = $(this).val();
            });

            var url;
            $("input[name=url]").each(function () {
                url = $(this).val();
            });

            var aditional_head_param = Array();
            $("input[name='aditional_head_param[]']").each(function () {
                aditional_head_param += $(this).val() + '|';
            });

            var aditional_head_value = Array();
            $("input[name='aditional_head_value[]']").each(function () {
                aditional_head_value += $(this).val() + '|';
            });

            var aditional_variable_param = Array();
            $("input[name='aditional_variable_param[]']").each(function () {
                aditional_variable_param += $(this).val() + '|';
            });

            var aditional_variable_value = Array();
            $("input[name='aditional_variable_value[]']").each(function () {
                aditional_variable_value += $(this).val() + '|';
            });

            var enconding_message;
            $("select[id=enconding_message]").each(function () {
                enconding_message = $(this).val();
            });
            var message_body;
            $("textarea[id=message_body]").each(function () {
                message_body = $(this).val();
            });

            var msg = '';

            if (auth_method == '') {
                msg += "Choose valid Authentification method\n\r";
            }
            if (username == ''){
                msg += "Enter User Name\n\r";
            }

            if ((passwd != '' && passwd != passwdrep) || passwd == '') {
                msg += "Enter Valid Password\n\r";
            }

            if (auth_method == 'cloud' && region == '') {
                msg += "Enter Region\n\r";
            }

            if (send_method == '') {
                msg += "Choose Action Methode\n\r";
            }
            if (url == '') {
                msg += "Enter URL\n\r";
            }

            if (enconding_message == '') {
                msg += "Choose Encoding Methode\n\r";
            }
            if (message_body == '') {
                msg += "Enter Message\n\r";
            }

            if (msg != ''){
                alert(msg)
            }

            if (msg == '') {

                $('#HttpInventory_type_method_info').val(auth_method);
                $('#HttpInventory_action_url').val(url);
                $('#HttpInventory_urlencode').val('1');
                $('#HttpInventory_username').val(username);
                $('#HttpInventory_password').val(passwd);
                $('#HttpInventory_enconding_message').val(enconding_message);
                $('#HttpInventory_message_body').val(message_body);
                $('#HttpInventory_region').val(region);
                $('#HttpInventory_send_method').val(send_method);
                $('#HttpInventory_additional_header').val(aditional_head_param+';'+aditional_head_value);
                $('#HttpInventory_custom_variable').val(aditional_variable_param+';'+aditional_variable_value);
                $('#myModalHttp').modal('hide')
            }
            break;
    }
}
function getStaffTable() {
    var urlAction = "/admin/httpInventory/informations";
    var rooms = $('#resultHttp').dataTable({
        "paging": true,
        "ordering": true,
        "hover": true,
        "info": false,
        "processing": true,
        "serverSide": false,
        "stateSave": true,
        //"filter": false,
        "destroy": true,
        "createdRow": function ( row, data, index ) {

        },
        "ajax": {
            "url": urlAction,
            "type": "POST",
            "datatype": 'json',
            "searching": true,
            "columns": [
                {"data": "start_work"},
                {"data": "staff_name"},
                {"data": "position"},
                {"data": "ext_number"},
                {"data": "action"}
            ]
        }
        //"dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    /*$("[data-toggle='popover']").live("popover",function()
     {
     html:true,
     trigger:"hover"
     }
     );*/
    $('#resultHttp').removeClass('display').addClass('table table-striped table-bordered');
    $(".popover").css("max-width", "750px");
}

function verifyCustom(vv){
    /*if ($(vv).val() == 'custom') {
        $('#HttpInventory_action_url').removeAttr('readonly');
        $('#generateUrl').attr('disabled', 'disabled').removeClass('btn-primary').addClass('btn-default');
    } else {
        $('#HttpInventory_action_url').attr('readonly', 'readonly');
        $('#generateUrl').removeAttr('disabled').removeClass('btn-default').addClass('btn-primary');
    }*/
}

function modifyUrl(){
    var url;
    url = $('#HttpInventory_action_url').val();
    var splitText = url.split("?");
    var listOfArray = decodeURIComponent(splitText[1]).split('&');
    var typeOfUrl = $('#HttpInventory_type_of_url').val();
    generateUrl();
    switch (typeOfUrl) {
        case "3cx":
            var url3cx;
            url3cx = splitText[0].split("/ivr");
            $("input[name=addressServer]").each(function () {
                $(this).val(url3cx[0]);
            });
            break;
        case "pbx":
            var urlpbx;
            urlpbx = splitText[0].split("/remote_call.htm");
            $("input[name=address]").each(function () {
                $(this).val(urlpbx[0]);
            });

            break;
        case "vodia":
            $("input[name=address]").each(function () {
                $(this).val(splitText[0]);
            });
            break;
    }
    var tmpValue;
    $.each(listOfArray, function(index, obj) {
        tmpValue = obj.split('=');
        switch (typeOfUrl) {
            case "3cx":
                switch (tmpValue[0]){
                    case "from":
                        $("input[name=call_from]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                    case "to":
                        $("input[name=call_to]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                    case "pin":
                        $("input[name=ext_password]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                }
                break;
            case "pbx":
                switch (tmpValue[0]){
                    case "user":
                        $("input[name=call_from]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                    case "auth":
                        var authCred;
                        authCred = tmpValue[1].split(':');

                        $("input[name=ext_auth]").each(function () {
                            $(this).val(authCred[0]);
                        });
                        $("input[name=ext_password]").each(function () {
                            $(this).val(authCred[1]);
                        });
                        break;
                    case "dest":
                        $("input[name=call_to]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                }
                break;
            case "vodia":
                switch(tmpValue[0]){
                    case "src":
                        $("input[name=call_from]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                    case "dst":
                        $("input[name=call_to]").each(function () {
                            $(this).val(tmpValue[1]);
                        });
                        break;
                }

                break;
            case "custom":
                var auth_method = $('#HttpInventory_type_method_info').val();
                //var url = $('#HttpInventory_action_url').val(url);
                var username = $('#HttpInventory_username').val();
                var passwd = $('#HttpInventory_password').val();
                var enconding_message = $('#HttpInventory_enconding_message').val();
                var message_body = $('#HttpInventory_message_body').val();
                var region = $('#HttpInventory_region').val();
                var send_method = $('#HttpInventory_send_method').val();
                if ($('#HttpInventory_additional_header').val() != '') {
                    var ad_header = $('#HttpInventory_additional_header').val().split(';');
                    var header_var = ad_header[0].substring(0, ad_header[0].length - 1).split('|');
                    var header_val = ad_header[1].substring(0, ad_header[1].length - 1).split('|');
                } else {
                    var header_var = Array();
                    var header_val = Array();
                }

                if ($('#HttpInventory_custom_variable').val() != '') {
                    var var_custom = $('#HttpInventory_custom_variable').val().split(';');
                    var value_var = var_custom[0].substring(0, var_custom[0].length - 1).split('|');
                    var value_val = var_custom[1].substring(0, var_custom[1].length - 1).split('|');
                } else {
                    var value_var = Array();
                    var value_val = Array();
                }


                $("button[id=firstAddButton]").each(function () {
                    $.each(header_var, function( index, value ) {
                        //alert(index)
                        if (index > 0){
                            $('#firstAddButton').click();
                        }
                    })
                });
                $("button[id=secondAddButton]").each(function () {
                    $.each(value_var, function( index, value ) {
                        //alert(index)
                        if (index > 0){
                            $('#secondAddButton').click();
                        }
                    })
                });
                $("select[id=auth_method]").each(function () {
                    $(this).val(auth_method);
                });
                $("input[name=username]").each(function () {
                    $(this).val(username);
                });

                $("input[name=passwd]").each(function () {
                    $(this).val(passwd);
                });
                $("input[name=passwdrep]").each(function () {
                    $(this).val(passwd);
                });

                $("input[name=region]").each(function () {
                    $(this).val(region);
                });
                $("select[id=send_method]").each(function () {
                    $(this).val(send_method);
                });

                if (url != '') {
                    $("input[name=url]").each(function () {
                        $(this).val(url);
                    });
                }

                $("select[id=enconding_message]").each(function () {
                    $(this).val(enconding_message);
                });

                $("textarea[id=message_body]").each(function () {
                    $(this).val(message_body);
                });
                var cc = 0;
                $("input[name='aditional_head_param[]']").each(function () {
                    $(this).val(header_var[cc]);
                    cc++;
                });

                $("input[name='aditional_head_value[]']").each(function (ind, vl) {
                    $(this).val(header_val[ind]);
                });

                var cc = 0;
                $("input[name='aditional_variable_param[]']").each(function () {
                    $(this).val(value_var[cc]);
                    cc++;
                });

                $("input[name='aditional_variable_value[]']").each(function (ind, vl) {
                    $(this).val(value_val[ind]);
                });
                break;
        }
    });
}

function addAditionalHeader(vv){
    var html = '';
    html += "<div class='row'>" +
    "<div class='col-lg-4'>" +
    "<label class='control-label'>Additional Headers Parameters:</label>" +
    "<div class='input-group'>" +
    "<input type='text' name='aditional_head_param[]' value='' class='form-control aditional_head_param' style='width: 250px;' placeholder='' />" +
    "</div>" +
    "</div>";

    html += "" +
    "<div class='col-lg-4'>" +
    "<label class='control-label'>Additional Headers Values:</label>" +
    "<div class='input-group'>" +
    "<input type='text' name='aditional_head_value[]' value='' class='form-control aditional_head_value' style='width: 250px;' placeholder='' />" +
    "</div>" +
    "</div>";
    html += "" +
    "<div class='col-lg-2'>" +
    "<label class='control-label'>&nbsp;</label>" +
    "<div class='input-group'>" +
    "<button type='button' class='btn btn-success' onclick='javascript:addAditionalHeader(this)'><i class='fa fa-plus-circle' aria-hidden='true'></i></button>&nbsp;&nbsp;" +
    "<button type='button' class='btn btn-danger' onclick='javascript:removeAditionalHeader(this)'><i class='fa fa-minus-circle' aria-hidden='true'></i></button>" +
    "</div>" +
    "</div>" +
    "</div>";
    $(vv).closest(".row").after(html);
}

function removeAditionalHeader(vv){
    $(vv).closest(".row").remove();
}

function changeAuthMethod(vv){
    if ($(vv).val() == 'cloud') {
        $("div[id=divRegion]").each(function () {
            $(this).show();
        });
    } else {
        $("div[id=divRegion]").each(function () {
            $(this).hide();
        });
    }
}

function addAditionalVariable(vv) {
    var html = '';
    html += "<div class='row'>" +
    "<div class='col-lg-4'>" +
    "<label class='control-label'>Additional Variable Parameters:</label>" +
    "<div class='input-group'>" +
    "<input type='text' name='aditional_variable_param[]' value='' class='form-control aditional_head_param' style='width: 250px;' placeholder='' />" +
    "</div>" +
    "</div>";

    html += "" +
    "<div class='col-lg-4'>" +
    "<label class='control-label'>Additional Variable Values:</label>" +
    "<div class='input-group'>" +
    "<input type='text' name='aditional_variable_value[]' value='' class='form-control aditional_head_value' style='width: 250px;' placeholder='' />" +
    "</div>" +
    "</div>";
    html += "" +
    "<div class='col-lg-2'>" +
    "<label class='control-label'>&nbsp;</label>" +
    "<div class='input-group'>" +
    "<button type='button' class='btn btn-success' onclick='javascript:addAditionalVariable(this)'><i class='fa fa-plus-circle' aria-hidden='true'></i></button>&nbsp;&nbsp;" +
    "<button type='button' class='btn btn-danger' onclick='javascript:removeAditionalHeader(this)'><i class='fa fa-minus-circle' aria-hidden='true'></i></button>" +
    "</div>" +
    "</div>" +
    "</div>";
    $(vv).closest(".row").after(html);
}