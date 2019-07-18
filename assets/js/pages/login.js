$(document).ready(function(){
	/* ---------- Placeholder Fix for IE ---------- */
	$('input').iCheck({
		checkboxClass: 'icheckbox_polaris'
	});
});

function selectRoom(event){
	var roomCount = $("input[name='staff_rooms[]']:checked").length;

	if (roomCount > 0) {
		return true
	} else {
		alert('Choose room')
		return false;
	}
}