@layout('layout.main')

@section('content')

	{{ Form::open('/', 'POST', array('id' => 'add_movie', 'class' => 'clearfix')) }}
		<h2>Ajouter un film</h2>
	
		<label for="title">Titre <span>(en V.O.)</span></label>
		<input type="text" name="title" placeholder="The Brooklyn Warriors">

		<label for="description">Description <span>(200 signes max.)</span></label>
		<textarea name="description" maxlength="200" placeholder="Tout simplement le meilleur film de tous les temps…"></textarea>
	
		<input type="hidden" value="{{ Auth::user()->id }}" name="user">
		<input type="submit" value="Ajouter" class="button">
	{{ Form::close() }}
	
	<ul id="film_list">
	@foreach($movies as $movie)
		<li class="clearfix">
			<div class="info">
				<h2>{{ $movie->title }}</h2>
				<h3>Ajouté par {{ $movie->user->username }}</h3>
				<p>{{ $movie->description }}</p>
			</div>
			
			<div class="toolbar">
				<h4 class="votes_counter">{{ $movie->votes }}</h4>
				@if(count($movie->votes_all) == 0)
				<button class="vote" id="{{ $movie->id }}"></button>
				@endif
			</div>
		</li>
	@endforeach
	</ul>

@endsection