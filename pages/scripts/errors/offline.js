$(window).ready(function() {

	resize();

	$(window).on('resize', function() {resize();});

	function resize() {
		var height = $(window).height();

		$('main').css('height', height + 'px');
	}
});