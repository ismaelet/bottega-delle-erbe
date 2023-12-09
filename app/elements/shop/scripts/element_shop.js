$(document).ready(function() {

	const itemN = $('#js-itemN').val();

	$('.itemN').html(itemN);

	//on type change
	$('.type-cbx').change(function() {

		$('.type-cbx').not(this).prop('checked', false);

		$('#filter-type').click();

	});

	//on use change
	$('.use-cbx').change(function() {

		$('.use-cbx').not(this).prop('checked', false);

		$('#filter-use').click();

	});


	//on tag change
	$('.tag-cbx').change(function() {
		$('.tag-cbx').prop('checked', false);
		$(this).prop('checked', true);

		$('#page-inp').val(1);

		$('#search-inp').val('');

		$('#filter_tag').click();
	});

	//on sorting change
	$('.sort-cbx').change(function() {
		$('.sort-cbx').prop('checked', false);
		$(this).prop('checked', true);

		$('#page-inp').val(1);

		$('#sort').click();
	});

	//remove type filter
	$('.remove-filter').click(function() {

		$('.type-cbx').prop('checked', false);
		$('.category-cbx').prop('checked', false);

		$('#page-inp').val(1);
		$('#search-inp').val('');

		$('#filter-type').click();

	});

	//change page
	$('.page_txt').click(function() {

		if (!$(this).hasClass('disabled')) {

			var page = $(this).data('page');

			$('#page-inp').val(page);

			$('#page-btn').click();
		}
		
	});

});

$(window).on('load', function() {

	$('#load').fadeOut();

});