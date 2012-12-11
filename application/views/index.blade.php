@layout('layout.main')

@section('content')

	{{ Form::open('add_movie', 'POST', array('id' => 'add_movie')) }}
		<h2>Ajouter<br>un film</h2>
	
		<label for="title">Titre</label>
		<input type="text" name="title">

		<label for="link">Lien</label>
		<input type="text" name="link">
	
		<input type="hidden" value="{{ Auth::user()->id }}" name="user">
		<input type="submit" value="Ajouter">
	{{ Form::close() }}
	
	<ul>
	@foreach($movies as $movie)
		<li>
			<h2>{{ $movie->title }} <a href="{{ $movie->link }}">Plus d’infos ›</a></h2>
			<p>Ajouté par {{ $movie->user->username }}</p>
			<p>Vote(s) : <span class="votes_counter">{{ $movie->votes }}</span></p>

			@if(count($movie->votes_all) == 0)
				<a href="" class="vote" id="{{ $movie->id }}">Voter</a>
			@endif
		</li>
	@endforeach
	</ul>

@endsection