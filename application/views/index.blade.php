@layout('layout.main')

@section('content')

	{{ Form::open('add_movie', 'POST', array('id' => 'add_movie', 'class' => 'clearfix')) }}
		<h2>Ajouter<br>un film</h2>
	
		<label for="title">Titre</label>
		<input type="text" name="title" placeholder="The Brooklyn Warriors">

		<label for="link">Lien</label>
		<input type="text" name="link" placeholder="http://imdb.com/the-brooklyn-warriors">
	
		<input type="hidden" value="{{ Auth::user()->id }}" name="user">
		<input type="submit" value="Ajouter" class="button">
	{{ Form::close() }}
	
	<ul id="film_list">
	@foreach($movies as $movie)
		<li class="clearfix">
			<h2>{{ $movie->title }} <a href="{{ $movie->link }}" target="_blank">Plus d’infos ›</a></h2>
			<div class="toolbar">
				<h3>Ajouté par {{ $movie->user->username }}</h3>
				<h4 class="votes_counter">{{ $movie->votes }}</h4>
				@if(count($movie->votes_all) == 0)
				<button class="vote" id="{{ $movie->id }}"></button>
				@endif
			</div>
		</li>
	@endforeach
	</ul>

@endsection