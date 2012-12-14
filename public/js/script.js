jQuery(document).ready(function($) {
	
	var moviedbURL = 'http://api.themoviedb.org/3/search/movie?api_key=c1b8ad68dd05a38b411f3a6a0f45932c';
	var posterURL = '';
	var posterSize = "w92";
	
	// GET MOVIE DB SERVER BASE URL
	$.get('http://api.themoviedb.org/3/configuration?api_key=c1b8ad68dd05a38b411f3a6a0f45932c', function(data) {
		posterURL = data.images.base_url;
		posterSize = data.images.poster_sizes[0];
	}, "json");
	
	// PREPEND POSTER TO EACH MOVIE
	$('#film_list li').each(function() {
		var title = $(this).find('h2').text();
		var that = this;
		
		$.get(moviedbURL + '&query=' + title, function(data) {
			console.log(data);
			if(data.total_results > 0) {
				if("poster_path" in data.results[0])
					$(that).prepend('<img src="' + posterURL + posterSize + data.results[0].poster_path + '">');
				else
					$(that).prepend('<img src="' + BASE + '/img/blank_poster.png">');
			} else { 
				$(that).prepend('<img src="' + BASE + '/img/blank_poster.png">');
			}
		}, "json");
	});
	
	$('#add_movie').submit(function() {
		var data_form = $(this).serialize();
		var title = $(this).find("input:first").val();
		console.log(title);
		
		$.get(apiURL + '&q=' + title, function(data) {
			//data += "&link=" + data.feed.movie[0].link.href;
			console.log(data);
			/*$.post(BASE+'/add_movie', data, function(data) {
				console.log("data posted");
			});*/
		}, "json");
	});
	
	$('button.vote').click(function(evt) {
		evt.preventDefault();
		
		var counter = $(this).parent().find('.votes_counter');
		
		var data = {
			'user_id': $('input[type="hidden"]').attr('value'),
			'movie_id': $(this).attr('id'),
			'votes': parseInt($(counter).html(), 10) + 1
		}

		$.post(BASE+'/increment_vote', data, function(data) {
			$(counter).html(data.votes);
			location.reload();
		});
	});
	
});