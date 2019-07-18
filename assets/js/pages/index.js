$(document).ready(function(){
    getIndexGeneralInfo();
	getNotificationGraph(1);
});

function getIndexGeneralInfo(){
    $("#ajax_loader").ajaxStart(function(){
        $(this).show();
    }); 
    $.ajax({
        url: '/admin/default/generalInfo',                   //
        timeout: 30000,
        type: "POST",
        dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown)  {
            alert("An error has occurred making the request: " + errorThrown)
        },
        success: function(data){                                                        
             //Do stuff here on success such as modal info      
                 //$( this ).dialog( "close" );
             if (typeof(data.nbRooms) != 'undefined'){
                $('#roomNumber').html(data.nbRooms);
             }
             if (typeof(data.nbPatients) != 'undefined'){
                $('#patientsNb').html(data.nbPatients);
                gaugesPatientsSeats(data.nbPatients, data.nbOfSeats);
             }
             if (typeof(data.smsEvent) != 'undefined'){
                $('#smsEvents').html(data.smsEvent);
             }
             if (typeof(data.emailEvent) != 'undefined'){
                $('#emailEvents').html(data.emailEvent);
             }
             if (typeof(data.voipEvent) != 'undefined'){
                $('#voiceEvents').html(data.voipEvent);
             }
			if (typeof(data.transCount) != 'undefined'){
				$('#responseCall').html(data.transCount);
			}
			if (typeof(data.callTimesLastMonth) != 'undefined'){
				$('#totalCallThisMonth').html(data.callTimesLastMonth);
			}
			if (typeof(data.totalPositioningEvents) != 'undefined'){
				$('#positioningEvent').html(data.totalPositioningEvents);
			}

             if (typeof(data.activeCalls) != 'undefined'){
                gaugesActiveCalls(data.activeCalls);
             }
             if (typeof(data.callTimes) != 'undefined'){
                gaugesResponseTimes(data.callTimes);
             }
             
        }
   });
   timeDataCallActivity(1);
   timeDataResponseActivity(1);
   $("#ajax_loader").ajaxStop(function(){
        $(this).hide();
   });
}

function gaugesPatientsSeats(nbPatients, nbSeats){
	var maxCount;
	if (nbPatients > 0) {
		maxCount = nbPatients * 3;
	} else {
		maxCount = 12;
	}
    $('#gausePatientsSeats').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Patients'
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: maxCount,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'Patients'
	        },
	        plotBands: [{
	            from: 0,
	            to: maxCount/3,
	            color: '#55BF3B' // green
	        }, {
	            from: maxCount/3,
	            to: (maxCount/3)*2,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: (maxCount/3)*2,
	            to: maxCount,
	            color: '#DF5353' // red
	        }]        
	    },
	
	    series: [{
	        name: 'Patients',
	        data: [parseInt(nbPatients)],
	        tooltip: {
	            valueSuffix: ' Patients'
	        }
	    }]
	});
}
function gaugesActiveCalls(nbCalls){
    var  maxCount = 0;
	maxCount = nbCalls*3;
	$('#gauseActiveCalls').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Devices'
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: maxCount,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'Devices'
	        },
	        plotBands: [{
	            from: 0,
	            to: (maxCount /3),
	            color: '#55BF3B' // green
	        }, {
	            from: (maxCount/3),
	            to: (maxCount/3)*2,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: (maxCount/3)*2,
	            to: maxCount,
	            color: '#DF5353' // red
	        }]        
	    },
	
	    series: [{
	        name: 'Devices',
	        data: [parseInt(nbCalls)],
	        tooltip: {
	            valueSuffix: ' Devices'
	        }
	    }]
	});
}
function gaugesResponseTimes(resTimes){
    $('#gauseResponseTime').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Total Minutes'
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 1000000,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'Minutes'
	        },
	        plotBands: [{
	            from: 0,
	            to: 330000,
	            color: '#55BF3B' // green
	        }, {
	            from: 330000,
	            to: 660000,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 660000,
	            to: 1000000,
	            color: '#DF5353' // red
	        }]        
	    },
	
	    series: [{
	        name: 'Minutes',
	        data: [parseInt(resTimes)],
	        tooltip: {
	            valueSuffix: ' Minutes'
	        }
	    }]
	});
}

function timeDataCallActivity(nbDay){
    var dataString;
    var titleText;
	var timeLine;
    switch(nbDay) {
        case 1:
           dataString ='nb_day=1';
           titleText = 'Today';
			timeLine = 'Hour';
           $('#liToday').removeAttr('class');
           $('#liWeek').removeAttr('class');
           $('#liMonth').removeAttr('class');
           $('#liToday').attr('class', 'active');
           break;
        case 7:
           dataString ='nb_day=7';
           titleText = 'This week';
			timeLine = 'Hour';
           $('#liToday').removeAttr('class');
           $('#liWeek').removeAttr('class');
           $('#liMonth').removeAttr('class');
           $('#liWeek').attr('class', 'active');
           break;
        case 30:
           dataString ='nb_day=30';
           titleText = 'This Month';
			timeLine = 'Hour';
           $('#liToday').removeAttr('class');
           $('#liWeek').removeAttr('class');
           $('#liMonth').removeAttr('class');
           $('#liMonth').attr('class', 'active');
           break;
    }
    //$.ajax({
    //    url: '/admin/default/callActivity',
    //    type: "POST",
    //    data: dataString,
    //    dataType: 'json',
    //    success: function (jsondata) {
    //        $('#chartContent').highcharts({
    //        chart: {
    //            type: 'spline'
    //        },
    //        title: {
    //            text: titleText
    //        },
    //        /*subtitle: {
    //            text: 'Source: WorldClimate.com'
    //        },*/
    //        xAxis: {
    //            type: 'datetime',
    //            dateTimeLabelFormats: { // don't display the dummy year
    //                hour: '%H'
    //            },
    //            title: {
    //                text: timeLine
    //            }
    //        },
    //        yAxis: {
    //            title: {
    //                text: 'Number of call'
    //            },
    //            min: 0
    //        },
    //        tooltip: {
    //            headerFormat: '<b>{series.name}</b><br>',
    //            pointFormat: '{point.x:%e. %b}: {point.y:.2f} calls'
    //        },
    //        plotOptions: {
    //            column: {
    //                pointPadding: 0.2,
    //                borderWidth: 0
    //            }
    //        },
    //        series: jsondata.series
    //    });
    //    }
    //});
 }
 function timeDataResponseActivity(nbDay){
    var dataString;
    var titleText;
    switch(nbDay) {
        case 1:
           dataString ='nb_day=1';
           titleText = 'Today';
           $('#liResponseToday').removeAttr('class');
           $('#liResponseWeek').removeAttr('class');
           $('#liResponseMonth').removeAttr('class');
           $('#liResponseToday').attr('class', 'active');
           break;
        case 7:
           dataString ='nb_day=7';
           titleText = 'This week';
           $('#livToday').removeAttr('class');
           $('#livWeek').removeAttr('class');
           $('#liResponseMonth').removeAttr('class');
           $('#liResponseWeek').attr('class', 'active');
           break;
        case 30:
           dataString ='nb_day=30';
           titleText = 'This Month';
           $('#liResponseToday').removeAttr('class');
           $('#liResponseWeek').removeAttr('class');
           $('#liResponseMonth').removeAttr('class');
           $('#liResponseMonth').attr('class', 'active');
           break;
    }
    $.ajax({
        url: '/admin/default/responseActivity',             
        type: "POST",
        data: dataString,
        dataType: 'json',
        success: function (jsondata) { 
            $('#chartResponseContent').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: titleText
            },
            /*subtitle: {
                text: 'Source: WorldClimate.com'
            },*/
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    hour: '%H',
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: 'Time of Response'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b %H:%M}: {point.y:.2f} sec'
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
		url: '/admin/default/notificationGraph',
		type: "POST",
		data: dataString,
		dataType: 'json',
		success: function (jsondata) {
			$('#chartContentNotif').highcharts({
				chart: {
					type: 'column',
					options3d: {
						enabled: true,
						alpha: 15,
						beta: 15,
						viewDistance: 25,
						depth: 40
					},
					marginTop: 80,
					marginRight: 40
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
						stacking: 'normal',
						depth: 40
					}
				},
				series: jsondata.series
			});
		}
	});
}
