$(document).ready(function(){
    getCodeGraph(1);
    getNotificationGraph(1);
});

function getCodeGraph(nbDay) {
    var dataString;
    var titleText;
    switch(nbDay) {
        case 1:
           dataString ='nb_day=1';
           titleText = 'Today';
            $('#code1').addClass('active');
            $('#code7').removeClass('active');
            $('#code30').removeClass('active');
           break;
        case 7:
           dataString ='nb_day=7';
           titleText = 'Last 7 days';
            $('#code1').removeClass('active');
            $('#code7').addClass('active');
            $('#code30').removeClass('active');
           break;
        case 30:
           dataString ='nb_day=30';
           titleText = 'Last Month';
            $('#code1').removeClass('active');
            $('#code7').removeClass('active');
            $('#code30').addClass('active');
           break;
    }
    $.ajax({
        url: '/admin/reports/codeGraph',             
        type: "POST",
        data: dataString,
        dataType: 'json',
        success: function (jsondata) { 
            $('#chartContent').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: titleText
            },
            /*subtitle: {
                text: 'Source: WorldClimate.com'
            },*/
            xAxis: {
                categories: jsondata.category
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} event</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: jsondata.series
        });
        }
    });
}

function getNotificationGraph(nbDay) {
    var dataString;
    var titleText;
    switch(nbDay) {
        case 1:
            dataString ='nb_day=1';

            titleText = 'Today';
            $('#not1').addClass('active');
            $('#not7').removeClass('active');
            $('#not30').removeClass('active');
            break;
        case 7:
            dataString ='nb_day=7';
            titleText = 'Last 7 days';
            $('#not1').removeClass('active');
            $('#not7').addClass('active');
            $('#not30').removeClass('active');
            break;
        case 30:
            dataString ='nb_day=30';
            titleText = 'Last Month';
            $('#not1').removeClass('active');
            $('#not7').removeClass('active');
            $('#not30').addClass('active');
            break;
    }
    $.ajax({
        url: '/admin/reports/notificationGraph',
        type: "POST",
        data: dataString,
        dataType: 'json',
        success: function (jsondata) {
            $('#chartContentNotif').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: titleText
                },
                /*subtitle: {
                 text: 'Source: WorldClimate.com'
                 },*/
                xAxis: {
                    categories: jsondata.category
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Number'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} event</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: jsondata.series
            });
        }
    });
}
