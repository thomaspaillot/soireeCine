jQuery(document).ready(function($) {
	
	$('a.vote').click(function(evt) {
		evt.preventDefault();
		
		var counter = $(this).parent().find('.votes_counter');
		
		var data = {
			'user_id': $('input[type="hidden"]').attr('value'),
			'movie_id': $(this).attr('id'),
			'votes': parseInt($(counter).html(), 10) + 1
		}

		$.post(BASE+'/increment_vote', data, function(data) {
			$(counter).html(data.votes);
		});
	})
	
});