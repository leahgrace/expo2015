$('.fs-continue').on('click', function() {
	if ( ! $('li').hasClass('fs-current') ) {
		console.log('test');
		$('html body .container').css('overflow', 'auto');
	}
});