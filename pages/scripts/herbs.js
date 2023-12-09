$(document).ready(function() {

	$('.qty').on('change', function() { update_price($(this)); });
	$('.qty').keyup(function() { update_price($(this)); });

	function update_price(inp) {

		var qty = parseInt(inp.val());

		if (qty > inp.attr('max')) { qty = inp.attr('max'); }
		if (qty < 1) { qty = 1; }

		inp.val(qty);

		price = (inp.data('price') * qty).toFixed(2).replace('.', ',');

		inp.parents('.line').find('.price').html(price);

	}

	//show more
	$('.show-more').click(function() {
		$(this).parent().addClass('open');
	});

	//scroll to top
	$('html').addClass('smooth-scrolling');

	scrolling();

	$(window).scroll(function() { scrolling(); });

	function scrolling() {

		const windowTop = $(window).scrollTop();
		const windowBottom = windowTop + $(window).height();

		if (windowTop > $('#slider').outerHeight()) {

			$('.scroll-top').addClass('active');

		} else {

			$('.scroll-top').removeClass('active');

		}

		if (windowBottom > $('footer').offset().top) {

			$('.scroll-top').addClass('fixed');

		} else {

			$('.scroll-top').removeClass('fixed');

		}

	}

});