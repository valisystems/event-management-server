/**
 * Created by iurik on 03.02.15.
 */
$(document).ready(function(){
    $('.date').datetimepicker();
    //$("#receiver").mask("(999) 999-9999");
    $('[data-rel="chosen"],[rel="chosen"]').chosen();
    $('#daterange').click(function(){
        changeSearchCriteria('daterange');
    });
    $('#daterangeTo').click(function(){
        changeSearchCriteria('daterange');
    });
    $('#serialNumber').click(function(){
        changeSearchCriteria('serialNumberCheck');
    });
    $('#code').click(function(){
        changeSearchCriteria('codeCheck');
    });
    $('#typeEvent').click(function(){
        changeSearchCriteria('typeEventCheck');
    });
    $('#receiver').click(function(){
        changeSearchCriteria('receiverCheck');
    });
    $('#patient').click(function(){
        changeSearchCriteria('patientCheck');
    });

    $('#resultEvent')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered hover');

    function changeSearchCriteria(val) {
        $('input[name="searchFilter"]').each(function(){
            if (this.value == val)
                this.checked = true;
        });
    }

    $('#reset').click(function(){
        $('#exportContent').html("");
        $('input[name="searchFilter"]').prop('checked', false);
        $('#resultEvent').dataTable( {
            "paging":   true,
            "ordering": true,
            "hover": true,
            "info":     false,
            "processing": true,
            "serverSide": false,
            //"filter": false,
            "destroy": true,
            "data": []
        } );
    });
    $('.box-header').click(function(){
        if ($('.box-content').is(":hidden")) {
            $('.box-content').toggle( "slow" );
        } else {
            $('.box-content').toggle( "slow" );
        }
    });
});
$("#search").click(function(){
    var enteredSearch = false;
    $('input[name="searchFilter"]').each(function(){
        if (this.checked)
            switch(this.value){
                /*case "daterange":
                 if ($('#daterange').val() == '' || $('#daterangeTo').val() == '') {
                 alert("Please choose the date for search");
                 $('#daterange').focus();
                 } else {
                 sendAjaxToSearch(this.value);
                 }
                 break;*/
                case "serialNumberCheck":
                    if ($('#serialNumber').val() == ''){
                        alert('Please enter serial number');
                        $('#serialNumber').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "codeCheck":
                    if ($('#code').val() == ""){
                        alert('Please enter the code');
                        $('#code').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "typeEventCheck":
                    if ($('#typeEvent').val() == ""){
                        alert('Please choose event');
                        $('#typeEvent').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "receiverCheck":
                    if ($('#receiver').val() == ''){
                        alert('Please enter the receiver number');
                        $('#receiver').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "patientCheck":
                    if ($('#patient').val() == ''){
                        alert('Please choose the patient');
                        $('#patient').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
            }
    });
    if (!enteredSearch) {
        if ($('#daterange').val() == '' || $('#daterangeTo').val() == '') {
            alert("Please choose the date for search");
            $('#daterange').focus();
        } else {
            sendAjaxToSearch("");
        }
    }
    $('.box-content').toggle( "slow" );
    return enteredSearch;
});
function sendAjaxToSearch(searchCriteria){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    $('#exportContent').html("");
    var urlAction = '/admin/eventsPendantReports/reportSearch';
    var urlActionChart = '/admin/eventsPendantReports/reportSearchChart';

    var dataForm = $('#eventsReport-form').serialize();
    //var urlLink = "/admin/eventsReports/reportPdf/searchData/"+btoa(dataForm)+"/format/pdf";
    var urlLink = "/admin/eventsPendantReports/reportExcel/searchData/"+btoa(dataForm)+"/format/pdf";
    var urlLinkExcel = "/admin/eventsPendantReports/reportExcel/searchData/"+btoa(dataForm);
    $('#exportPDF').attr('href', urlLink);
    $('#exportXLS').attr('href', urlLinkExcel);

    //alert("serialized="+serializeArray);
    $('#resultEvent').show();
    var table = $('#resultEvent').dataTable( {
        "paging":   true,
        "ordering": true,
        "hover": true,
        "info":     false,
        "processing": true,
        "serverSide": true,
        //"filter": false,
        "destroy": true,
        "ajax": {
            "url": urlAction,
            "type": "POST",
            "datatype": 'json',
            "searching": false,
            "data": function (d){
                d.allData = dataForm;
                //if (d.draw > 0)
                //    d.draw = d.draw++;
                //else
                //    d.draw = 0;
            },
            "columns": [
                { "data": "time" },
                { "data": "deviceDesc" },
                { "data": "patient"},
                { "data": "room" },
                { "data": "receiver" },
                { "data": "serialNumber" },
                { "data": "code" },
                { "data": "typeNotif" }
            ]
        }
    } );

    //table.on( 'draw', function () {    alert( 'Table redrawn' );} );
    $('#resultEvent')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered hover');

    //$.ajax({
    //    url: urlActionChart,
    //    type: "POST",
    //    data: {allData:dataForm},
    //    dataType: 'json',
    //    success: function (jsondata) {
    //        $('#chartContent').highcharts({
    //            chart: {
    //                type: 'column'
    //            },
    //            title: {
    //                text: 'Pendant Notification Activity'
    //            },
    //            xAxis: {
    //                type: 'category',
    //                labels: {
    //                    rotation: -45,
    //                    style: {
    //                        fontSize: '13px',
    //                        fontFamily: 'Verdana, sans-serif'
    //                    }
    //                }
    //            },
    //            yAxis: {
    //                title: {
    //                    text: 'Number of call'
    //                },
    //                min: 0
    //            },
    //            legend: {
    //                enabled: false
    //            },
    //            tooltip: {
    //                pointFormat: '{point.y:,.0f} events'
    //            },
    //            series: jsondata
    //        });
    //    }
    //});

    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function exportPDFFromSearch(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    var urlAction = '/admin/eventsPendantReports/reportPdf';
    var dataForm = $('#eventsReport-form').serialize();
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
            var WinId = window.open(dd);
            WinId.document.open();
            WinId.document.write(dd);
            WinId.document.close();
        }
    });

    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}
