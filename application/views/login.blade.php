@layout('layout.main')

@section('content')

	{{ Form::open('login', 'POST', array('id' => 'login', 'class' => 'clearfix')) }}
		{{ Form::label('username', 'Utilisateur') }}
		{{ Form::text('username') }}
		
		{{ Form::label('password', 'Mot de passe') }}
		{{ Form::password('password') }}
		
		{{ Form::checkbox('new_user', 'new_user') }}
		{{ Form::label('new_user', 'S’enregistrer ?') }}
		{{ Form::submit('Connexion', array('class' => 'button')) }}
	{{ Form::close() }}
	
@endsection