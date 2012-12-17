@layout('layout.main')

@section('content')

	{{ Form::open('add_movie', 'POST', array('id' => 'add_movie', 'class' => 'clearfix')) }}
		<h2>Ajouter un film</h2>
	
		<label for="title">Titre <span>(en V.O.)</span></label>
		<input type="text" name="title" placeholder="The Brooklyn Warriors">

		<label for="description">Description <span>(200 signes max.)</span></label>
		<textarea name="description" maxlength="200" placeholder="Faites nous rêver…"></textarea>
	
		<input type="hidden" value="{{ Auth::user()->id }}" name="user">
		<input type="submit" value="Ajouter" class="button">
	{{ Form::close() }}
	
	<ul id="film_list">
		
	@foreach($movies as $movie)
		<li class="movie clearfix">
			<div class="info">
				{{ HTML::image('img/blank_poster.png', '', array('class' => 'poster')) }}
				
				<h2>{{ $movie->title }}</h2>
				<span class="popup_button"><a href="http://www.allocine.fr/recherche/?q={{ $movie->title }}" target="_blank">i</a></span>
				<h3>Ajouté par {{ $movie->user->username }}</h3>
		    	<span class="options icon-cogs">
		    		<ul class="dropdown-menu">
						@if($movie->user_id == Auth::user()->id)
					    <li class="remove"><a href="#"><i class="icon-trash"></i> Supprimer</a></li>
					    @endif
						<li class="archive"><a href="#"><i class="icon-check"></i> Archiver</a></li>
				    </ul>
		    	</span>
				<p>
					@if($movie->user_id == Auth::user()->id)
					<button class="edit icon-pencil"></button>
					@endif
					{{ $movie->description }}
				</p>
				{{ Form::open('update_movie', 'POST', array('class' => 'update_movie hidden')) }}
					<textarea name="description" maxlength="200">{{ $movie->description }}</textarea>
					<input type="hidden" value="{{ $movie->id }}" name="movie_id">
					<input type="submit" value="OK" class="button">
				{{ Form::close() }}
			</div>
			
			<div class="vote_box">
				@if(count($movie->votes_all) == 0)
				<a class="vote icon-thumbs-up"></a>
				@endif
				<h4 class="votes_counter">{{ $movie->votes }}</h4>
			</div>
		</li>
	@endforeach
	
	</ul>

@endsection