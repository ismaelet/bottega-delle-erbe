$(document).ready(function() {

	$('.list .head .field.clickable').click(function() {
		$(this).submit();
	});

	$('.page').click(function() {

		$('#pageN').val($(this).data('page'));

		$(this).parent().find('button').click();

	});

	//search bar
	$('#body .search-bar .icon-box').click(function() {

		$(this).parent().find('button').click();

	});

	$('#body .search-bar .inp').focus(function() {

		$(this).parent().addClass('active');

	});

	$('#body .search-bar .inp').blur(function() {

		$(this).parent().removeClass('active');

	});

});