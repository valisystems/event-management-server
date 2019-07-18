$(document).ready(function(){
	 /* attach a submit handler to the form */
    $("#formoid").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
        url = $form.attr( 'action' );
		var data =  {
						"action": $('#action').val(),
						"BaseName": $('#BaseName').val(), "DeviceType": $('#DeviceType').val(),
						"AntennaInt": $('#AntennaInt').val(), "EventType": $('#EventType').val(),
						"DeviceID": $('#DeviceID').val(), "PendantRxLevel": $('#PendantRxLevel').val(),
						"LowBattery": $('#LowBattery').val(), "TimeStamp": $('#TimeStamp').val(),
					}; 
		  
		
		//var tmp = JSON.stringify($('.dd').nestable('serialize'));
		  // tmp value: [{"id":21,"children":[{"id":196},{"id":195},{"id":49},{"id":194}]},{"id":29,"children":[{"id":184},{"id":152}]},...]
		  $.ajax({
			type: 'POST',
			datatype:'json',
			url: url,
			data: JSON.stringify(data),
			success: function(msg) {
				//console.log(data);
			   alert('Form data posted successfully');
			   $('#create-device').hide();
			},
			error:function(msg){
				alert('ERROR');
			}
		  });
		  
    });
	
	// Edit form
	$(".editButton").click(function(){
		var deviceID = $(this).attr('id');
		$.ajax({
				type: 'GET',
				datatype:'json',
				url: 'classes/ajax.php?device_id=' + deviceID,
				success: function(data) {
					doModal('Edit - '+ deviceID, data);
				},
				error:function(msg){
					alert('ERROR');
				}
		});
	});
	
	
	// Delete button
	$(".deleteButton").click(function(){
		var deviceID = $(this).attr('id');
		var data =  {
						"action": 'delete',
						"DeviceID": deviceID
					};
					
					
		if(confirm('Are you sure you want to delete this row?'))
		{
			$.ajax({
				type: 'POST',
				datatype:'json',
				url: 'classes/ajax.php',
				data: JSON.stringify(data),
				success: function(msg) {
					//console.log(data);
				   alert('Deleted successfully');
				},
				error:function(msg){
					alert('ERROR');
				}
			});
		$(this).parent().parent().animate({background: "#fbc7c7"}, "fast").animate({opacity:"hide"}, "slow");
		}
		
		return false;
	});
	
});


// bootstrap model
function doModal(heading, formContent) {
    html =  '<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
    html += '<div class="modal-dialog">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<a class="close" data-dismiss="modal">×</a>';
    html += '<h4>'+heading+'</h4>'
    html += '</div>';
    html += '<div class="modal-body">';
    html += formContent;
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '<span class="btn btn-primary" data-dismiss="modal">Close</span>';
    html += '</div>';  // content
    html += '</div>';  // dialog
    html += '</div>';  // footer
    html += '</div>';  // modalWindow
    $('body').append(html);
    $("#edit-modal").modal();
    $("#edit-modal").modal('show');
	formsubmit();

    $('#edit-modal').on('hidden.bs.modal', function (e) {
        $(this).remove();
    });

}

function formsubmit()
{
	$("#formoid2").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
        url = $form.attr( 'action' );
		var data =  {
						"action": $('#action2').val(),
						"BaseName": $('#BaseName2').val(), "DeviceType": $('#DeviceType2').val(),
						"AntennaInt": $('#AntennaInt2').val(), "EventType": $('#EventType2').val(),
						"DeviceID": $('#DeviceID2').val(), "PendantRxLevel": $('#PendantRxLevel2').val(),
						"LowBattery": $('#LowBattery2').val(), "TimeStamp": $('#TimeStamp2').val(),
					}; 
		  
		
		//var tmp = JSON.stringify($('.dd').nestable('serialize'));
		  // tmp value: [{"id":21,"children":[{"id":196},{"id":195},{"id":49},{"id":194}]},{"id":29,"children":[{"id":184},{"id":152}]},...]
		  $.ajax({
			type: 'POST',
			datatype:'json',
			url: url,
			data: JSON.stringify(data),
			success: function(msg) {
				//console.log(data);
			   alert('Form data posted successfully');
			   $('#edit-modal').remove();
			   location.reload();
			},
			error:function(msg){
				alert('ERROR');
			}
		  });
		  
    });
	
}

