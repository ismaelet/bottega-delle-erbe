$(document).ready(function() {

	//cycle images
	var i = 0;
	var j = 0;
	
	(function foo() {

		i++;
		j++;

		if (i > 3) {i = 1;}
		if (j > 4) {j = 1;}

		$('.about-bio-img').removeClass('active');
		$('#about-bio-img' + i).addClass('active');

		$('.about-shop-img').removeClass('active');
		$('#about-shop-img' + j).addClass('active');

		setTimeout(foo, 6000);
	})();

	//read more
	texts_fix_height();

	$(window).resize(function() { texts_fix_height(); });

	$('.read-more').click(function() {

		const self = $(this);
		const text = self.parents('.about-row').find('.about-txt');

		text.addClass('open');

		const height = text.outerHeight();

		text.parent().css('max-height', height + 'px');

		self.hide(200);

	});

	function texts_fix_height() {

		$('.about-txt').each(function() {

			const self = $(this);
			const height = self.outerHeight();

			self.parent().css('max-height', height + 'px');

		});

	}

});