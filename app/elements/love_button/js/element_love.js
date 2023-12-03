$(window).ready(function() {

	var url = '/app/elements/love_button/php/element_love_ajax.php';

	$('.love-btn.working').click(function() {

		//setup variabiles
		var self = $(this);
		var id = self.data('id');
		var loved = self.data('loved');

		//run
		$.ajax({

			method: 'POST',
			url: url,
			data: {id: id, loved: loved},

			success: function(data) {}

		}).done(function() {

			if (loved) {
				self.removeClass('active');
				self.data('loved', 0);
			} else {
				self.addClass('active');
				self.data('loved', 1);
			}

		});		
	});
});