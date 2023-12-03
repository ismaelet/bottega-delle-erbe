$(window).ready(function() {

	$('.item-cart').click(function() {

		$('#add-to-cart-form input').val($(this).data('id'));

		$('#add-to-cart-form button').click();

	});
	
});