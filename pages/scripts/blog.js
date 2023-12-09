$(document).ready(function() {

	organize();

	$(window).resize(function() { organize(); });

	function organize() {

		const wid = $(window).width();
		const imgHeight = $('.post .image').outerHeight();

		if (wid > 480) { organize_posts(wid, imgHeight); }

	}
	
	function organize_posts(wid, imgHeight) {

		$('.post').removeClass('.big').css('top', '0');

		$('.post').each(function() {

			const self = $(this);
			const id = self.data('id');

			var size = 4;

			if (wid <= 1440) { size = 3; }
			if (wid <= 768) { size = 2; }

			var line = Math.ceil(id / size);

			if (!(size % 2)) { if ((id + line) % 2) { self.addClass('big') } }
			else { if ((id) % 2) { self.addClass('big') } }

			if (id % 2 && line > 1) { self.css('top', '-' + imgHeight * Math.floor(line / 2) + 'px'); }
			else if (!(id % 2) && line > 2) { self.css('top', '-' + imgHeight * Math.floor((line - 1) / 2) + 'px'); }


		});

		fix_height();

	}

	function fix_height() {

		const last = $('.post.big').last();
		const bottom = last.position().top + last.outerHeight();

		$('.posts').css('height', bottom);

	}

});