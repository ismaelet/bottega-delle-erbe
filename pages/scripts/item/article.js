$(document).ready(function() {

	$('#infos .title').click(function() {

		const self = $(this);
		const id = self.data('id');

		$('#infos .title').removeClass('active');
		self.addClass('active');

		$('#infos p').removeClass('active');
		$('#infos p[data-id="' + id + '"]').addClass('active');

	});

});