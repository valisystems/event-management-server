$(document).ready(function(){
    setTimeout(function(){
        $(".alert").fadeOut("slow"); 
    }, 5000 ); 
});

function addNewRecord(){
var textHtml;
    var today = new Date().getTime();
    textHtml = '<div class="col-lg-12 col-sm-12" id="forDelete_'+today+'">';
    textHtml += '<div class="form-group">';
    textHtml += '<div class="row">';
    textHtml += '    <div class="col-lg-4">';
    textHtml += '        <label class="control-label" for="description_manufacture">';
    textHtml += '            <label for="Func_Manufacture">Manufacturer</label> ';
    textHtml += '        </label>';
    textHtml += '        <div class="input-group date col-sm-4">';
    textHtml += '            <span class="input-group-addon">';
    textHtml += '                <i class="fa fa-plug"></i>';
    textHtml += '            </span>';
    textHtml += '            <input class="form-control bfh-phone" style="width:250px" name="Func['+today+'][id_support_manufactures]" id="Func_'+today+'_id_support_manufactures" value="" type="hidden">';
    textHtml += '            <input class="form-control bfh-phone" style="width:250px" name="Func['+today+'][description_manufacture]" id="Func_'+today+'_description_manufacture" maxlength="250" value="" type="text">';
    textHtml += '        </div>';
    textHtml += '        <div class="alert alert-danger" style="margin-top:5px;display:none" id="Func_'+today+'_description_manufacture_em_"></div>';
    textHtml += '    </div>&nbsp;&nbsp;';
    textHtml += '    <div class="col-lg-4">';
    textHtml += '        <label class="control-label" for="number_manufacture">';
    textHtml += '            <label for="Func_Access_Number">Access  Number</label>';
    textHtml += '        </label>';
    textHtml += '        <div class="controls">';
    textHtml += '            <div class="input-group date col-sm-4">';
    textHtml += '                <span class="input-group-addon">';
    textHtml += '                    <i class="fa fa-phone"></i>';
    textHtml += '                </span>';
    textHtml += '                <input class="form-control" style="width:250px" name="Func['+today+'][number_manufacture]" id="Func_'+today+'_number_manufacture" maxlength="16" value="" type="text"> ';
    textHtml += '            </div>';
    textHtml += '        </div>';
    textHtml += '        <div class="alert alert-danger" style="margin-top:5px;display:none" id="Func_'+today+'_number_manufacture_em_"></div>';
    textHtml += '    </div>';
    textHtml += '    <div class="col-lg-1">';
    textHtml += '        <label class="control-label">&nbsp;</label>';
    textHtml += '        <div class="checkbox">';
    textHtml += '            <input id="Func_'+today+'_status_manufacture" value="1" name="Func['+today+'][status_manufacture]" type="checkbox" data-toggle="toggle">';
    textHtml += '        </div>';
    textHtml += '    </div>';
    textHtml += '    <div class="col-lg-2" style="margin-top:10px;margin-left: 10px;">';
    textHtml += '       <label class="control-label">&nbsp;</label><br/>';
    textHtml += '       <div class="controls">';
    textHtml += '           <div class="btn btn-primary" onclick="javascript:removeRecord('+today+')">';
    textHtml += '               <i class="fa fa-trash-o"></i>';
    textHtml += '           </div>';
    textHtml += '       </div>';
    textHtml += '    </div>';
    textHtml += '</div>';
    textHtml += '</div>';
    textHtml += '</div>';
    $('#newRecord').append(textHtml);
    $('#Func_' + today + '_status_manufacture').bootstrapToggle();
}

function removeRecord(index) {
    if (confirm('Are you sure you want to delete this item?')) {
        var id_manufacturer = $('#Func_' + index + '_id_support_manufactures').val();
        if (id_manufacturer > 0) {
            $.ajax({
                url: '/admin/func/delete',                   //
                type: "POST",
                data: 'id_manufacturer=' + id_manufacturer,
                //dataType: 'json',
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("An error has occurred making the request: " + errorThrown)
                },
                success: function (data) {
                    if (data.status == 'success') {
                        $('#forDelete_' + index).remove();
                    }
                }
            });
        } else {
            $('#forDelete_' + index).remove();
        }
    }
}