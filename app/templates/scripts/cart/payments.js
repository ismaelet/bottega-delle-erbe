$(document).ready(function() {
	
	$('.payment').click(function() {

		$('.payment input').prop('checked', false);

		$(this).find('input').prop('checked', true);

	});
	
});