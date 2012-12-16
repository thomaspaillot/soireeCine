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
		<li class="clearfix">
			<div class="info">
				{{ HTML::image('img/blank_poster.png', '', array('class' => 'poster')) }}
				
				<h2>{{ $movie->title }}</h2>
				<span class="popup_button"><a href="http://www.allocine.fr/recherche/?q={{ $movie->title }}" target="_blank">i</a></span>
				<h3>Ajouté par {{ $movie->user->username }}</h3>
				
				<p>{{ $movie->description }}</p>
			</div>
			
			<div class="toolbar" id="{{ $movie->id }}">
				@if(count($movie->votes_all) == 0)
				<button class="vote icon-thumbs-up"></button>
				@endif
				@if($movie->user_id == Auth::user()->id)
				<button class="edit icon-pencil"></button>
				<button class="remove icon-remove"></button>
				@endif				
			</div>
			
			<h4 class="votes_counter">{{ $movie->votes }}</h4>
		</li>
	@endforeach
	
	</ul>

@endsection