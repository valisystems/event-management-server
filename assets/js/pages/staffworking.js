/**
 * Created by iurik on 2/25/16.
 */
$(document).ready($(function () {
    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
    $(".popover").css("max-width", "750px");

    $('#staffTab').tab();

    getStaffTable();

    $('body').popover({
        selector: "[data-toggle='popover']",
        html:true,
        trigger:"hover"

    });
    $('.datepicker').datepicker();
    $('.cleditor').cleditor();
}));

function getStaffTable() {
    var urlAction = "/admin/staffWorking/informations";
    var rooms = $('#resultStaff').dataTable({
        "paging": true,
        "ordering": true,
        "hover": true,
        "info": false,
        "processing": true,
        "serverSide": true,
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
            "data": function (d) {
                d.id_building = id_building;
                d.id_map = id_map;
            },
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
    $('#resultStaff').removeClass('display').addClass('table table-striped table-bordered');
    $(".popover").css("max-width", "750px");
}
var staffSeries = "";

function staffWorkingCharts(){
    //alert(staffSeries)
    $('#container').highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Staff Activity'
        },
        subtitle: {
            text: 'Activity'
        },
        plotOptions: {
            column: {
                depth: 55
            }
        },
        xAxis: {
            categories: ["Call Activity"]
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: staffSeries
    });

    $('#staffTable').dataTable();
}

