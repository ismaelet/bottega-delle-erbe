$(document).ready(function() {
	
	fix_height();

	$(window).resize(function() {fix_height();})
	
	function fix_height() {

		const height = $('#h-pan').outerHeight();

		$('header').css('height', height + 'px');
		
		$('#h-navM').css({'top': height + 'px', 'height': 'calc(100% - ' + height + 'px)'});

	}

	//megamenu
	$('header .megamenu').css('max-height', 'calc(100vh - ' + $('#h-pan').outerHeight() + 'px)');

	$('header .megamenu-open').hover(function() {

		const megamenu = $(this).data('megamenu');

		$('#h-pan').addClass('solid');
		$('#megamenu-' + megamenu).addClass('active');

	}, function() {

		$('#h-pan').removeClass('solid');
		$('.megamenu').removeClass('active');

	});

	$('header .megamenu').hover(function() {

		$('#h-pan').addClass('solid');
		$(this).addClass('active');

	}, function() {

		$('#h-pan').removeClass('solid');
		$('.megamenu').removeClass('active');

	});

});