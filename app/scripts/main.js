$(window).ready(function() {

	set_min_height()

	$(window).on('resize', function() {

		set_min_height()

	})

	function set_min_height() {

		const header = $('header')
		
		var height = header.outerHeight()

		if (header.css('position') != 'relative') {

			height = 0

		}

		$('main').css('min-height', 'calc(100vh - ' + height + 'px)')

	}

})