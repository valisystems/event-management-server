/**
 * Created by iurik on 4/30/15.
 */

$(document).ready(function(){
    $('.date').datetimepicker();

    $('#clidnumber').click(function(){
        changeSearchCriteria('CallerIDNumberCheck');
    });
    $('#clidname').click(function(){
        changeSearchCriteria('CallerIdNameCheck');
    });
    $('#destin').click(function(){
        changeSearchCriteria('DestinationCheck');
    });
    $('#between').click(function(){
        changeSearchCriteria('durationCheck');
    });
    $('#betweenand').click(function(){
        changeSearchCriteria('durationCheck');
    });

    $('#disposition').click(function(){
        changeSearchCriteria('dispositionCheck');
    });

    $('#resultCDR')
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
        $('#resultCDR').dataTable( {
            "paging":   true,
            "ordering": true,
            "hover": true,
            "info":     false,
            "processing": true,
            "serverSide": false,
            //"filter": false,
            "destroy": true,
            "data": [],
            columnDefs: [
                { width: 30, targets: 4 }
            ],
            fixedColumns: true,
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
        if (this.checked) {
            switch (this.value) {
                case "CallerIDNumberCheck":
                    if ($('#clidnumber').val() == '') {
                        alert('Please enter Caller ID Number');
                        $('#clidnumber').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "CallerIdNameCheck":
                    if ($('#clidname').val() == "") {
                        alert('Please enter Caller ID Name');
                        $('#clidname').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "DestinationCheck":
                    if ($('#destin').val() == "") {
                        alert('Please enter Destination');
                        $('#destin').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "durationCheck":
                    if ($('#between').val() == '' || $('#betweenand').val() == '') {
                        alert("Please choose the date for search");
                        $('#between').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
                case "dispositionCheck":
                    if ($('#disposition').val() == "") {
                        alert('Please choose Disposition');
                        $('#disposition').focus();
                    } else {
                        sendAjaxToSearch(this.value);
                        enteredSearch = true;
                    }
                    break;
            }
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
var count = 0;
function sendAjaxToSearch(searchCriteria){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    });
    $('#exportContent').html("");
    var urlAction = '/admin/vodiaCdr/getCdr';
    var urlActionChart = '/admin/vodiaCdr/getCdrChart';
    var dataForm = $('#cdrReport-form').serialize();
    var urlLink = "/admin/vodiaCdr/reportExcel/searchData/"+btoa(dataForm)+"/format/pdf";
    var urlLinkExcel = "/admin/vodiaCdr/reportExcel/searchData/"+btoa(dataForm);
    $('#exportPDF').attr('href', urlLink);
    $('#exportXLS').attr('href', urlLinkExcel);

    //alert("serialized="+serializeArray);
    $('#resultCDR').show();
    var table = $('#resultCDR').dataTable( {
        "paging":   true,
        "ordering": true,
        "hover": true,
        "info":     false,
        "processing": true,
        "serverSide": true,
        //"filter": false,
        "destroy": true,
        columnDefs: [
            { width: 30, targets: 4 }
        ],
        scrollY:        "300px",
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
                { "data": "calldate" },
                { "data": "clid" },
                { "data": "src" },
                { "data": "dst" },
                { "data": "billsec" },
            ]

        }
    } );
    //$.ajax({
    //    url: urlActionChart,
    //    type: "POST",
    //    data: {'allData':dataForm},
    //    dataType: 'json',
    //    success: function (jsondata) {
    //        if (Object.keys(jsondata).length > 0) {
    //            $('#chartContent').highcharts({
    //                chart: {
    //                    type: 'column'
    //                },
    //                title: {
    //                    text: 'CDR Call Activity'
    //                },
    //                xAxis: {
    //                    type: 'category',
    //                    labels: {
    //                        rotation: -45,
    //                        style: {
    //                            fontSize: '13px',
    //                            fontFamily: 'Verdana, sans-serif'
    //                        }
    //                    }
    //                },
    //                yAxis: {
    //                    title: {
    //                        text: 'Number of call'
    //                    },
    //                    min: 0
    //                },
    //                legend: {
    //                    enabled: false
    //                },
    //                tooltip: {
    //                    pointFormat: '{point.y:.2f} calls'
    //                },
    //                series: jsondata
    //            });
    //        }
    //    }
    //});

    //table.on( 'draw', function () {    alert( 'Table redrawn' );} );
    $('#resultCDR')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered hover');
    $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });
}

function getFileFromFtp(pathFtp){

}

