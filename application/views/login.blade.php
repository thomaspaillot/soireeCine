@layout('layout.main')

@section('content')
	
	{{ Form::open('login', 'POST', array('id' => 'login')) }}
		{{ Form::label('username', 'Utilisateur') }}
		{{ Form::text('username') }}
		
		{{ Form::label('password', 'Mot de passe') }}
		{{ Form::password('password') }}
		
		{{ Form::submit('Connexion', array('class' => 'button')) }}
	{{ Form::close() }}
	
@endsection