jQuery(document).ready(function($) {
	
	var $filmList = $('#film_list');
	
	$filmList.imagesLoaded(function() {
		$('#film_list').isotope({itemSelector: '.movie',
			getSortData : {
				votes : function($elem) {
					return $elem.find('.votes_counter').text();
				}
			},
			sortBy : 'votes',
			sortAscending : false
		});
	});
	
	var moviedbURL = 'http://api.themoviedb.org/3/';
	var apiKey = '?api_key=c1b8ad68dd05a38b411f3a6a0f45932c';
	var posterURL = '';
	var posterSize = '';
	
	// GET MOVIE DB SERVER BASE URL
	$.get(moviedbURL + 'configuration' + apiKey, function(data) {
		posterURL = data.images.base_url;
		posterSize = data.images.poster_sizes[0];
	}, "json");
	
	// PREPEND POSTER TO EACH MOVIE
	$('.movie').each(function() {
		var title = $(this).find('h2').text();
		var that = this;
		
		$.get(moviedbURL + 'search/movie' + apiKey + '&query=' + title, function(data) {
			if(data.total_results > 0) {
				$(that).attr('id', data.results[0].id);
				
				if("poster_path" in data.results[0])
					$(that).find('.poster').attr('src', posterURL + posterSize + data.results[0].poster_path);
			}	
		}, "json");
	});
	
	// ADD INFO POPUP ON ROLLOVER
	$('.movie .popup_button').mouseenter(function() {
		var movie_id = $(this).parents('.movie').attr('id');
		var that = this;
		
		$.get(moviedbURL + 'movie/' + movie_id + apiKey, function(data) {
			var movie_data = data;
			
			$.get(moviedbURL + 'movie/' + movie_id + '/casts' + apiKey, function(data) {
				$(that).append(buildInfoPopup(movie_data, data));
			}, "json");
		}, "json");
	}).mouseleave(function() {
		$(this).find('.movie_popup').remove();
	});
	
	// HANDLE VOTE
	$('.vote').click(function(evt) {		
		var counter = $(this).parents('.movie').find('.votes_counter');
		
		var data = {
			'user_id': $('input[type="hidden"]').attr('value'),
			'movie_id': $(this).parents('.movie').find('input[type="hidden"]').val(),
			'votes': parseInt($(counter).html(), 10) + 1
		}

		$.post(BASE+'/increment_vote', data, function(data) {
			$(counter).html(data.votes);
			$('#film_list').isotope('updateSortData', $('#film_list .movie'))
						   .isotope({ sortBy : 'votes', sortAscending : false });
		});
	});
	
	// HANDLE EDIT DESCRIPTION
	$('.edit').click(function(evt) {
		$(this).parent().hide();
		$(this).parent().parent().find('.update_movie').removeClass('hidden');
	});
	
	// HANDLE OPTIONS DROPDOWN MENU
	$('.options').mouseenter(function() {
		$(this).addClass('open');
		$(this).find('ul').show();
	}).mouseleave(function() {
		$(this).removeClass('open');
		$(this).find('ul').hide();
	});
});


function buildInfoPopup(movie_data, cast_data) {
	var genres = _.pluck(movie_data.genres, 'name');
	var director = _.where(cast_data.crew, {department: "Directing"});

	var popup = '<div class="movie_popup">'
			  +		'<p><strong>Réalisateur</strong> : ' + director[0].name + '</p>'
			  +		'<p><strong>Genres</strong> : ' + genres.join(', ') + '</p>'
			  +		'<p><strong>Date</strong> : ' + movie_data.release_date.substring(0, 4) + '</p>'
			  +	'</div>';
	
	return popup;
}