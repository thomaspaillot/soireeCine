<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Soirée ciné alpha 0.2</title>
	
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
	
	{{ HTML::style('css/normalize.css')}}
	{{ HTML::style('css/font-awesome.css')}}
	{{ HTML::style('css/style.css')}}
</head>

<body id="{{ $page }}">
	<div id="container">
		<header>
			<h1>Soirée ciné</h1>
		
			@if(Auth::check())
				<div id="login_nav">Bienvenue {{ Auth::user()->username }} ! {{ HTML::link('logout', 'déconnexion') }}</div>
			@endif
		
		</header>
	
		<div class="content clearfix">
			@yield('content')
		</div>
	</div>
	
	<footer>
		<div>
			{{ HTML::image('img/tmdb-logo.png') }}
			<p>This product uses the TMDb API but is not endorsed or certified by TMDb. Thomas Paillot 2012</p>
		</div>
	</footer>
	
	<script type="text/javascript">
		var BASE = "{{ URL::base() }}";
	</script>
	
	{{ HTML::script('js/jquery.min.js') }}
	{{ HTML::script('js/underscore.min.js') }}
	{{ HTML::script('js/jquery.isotope.min.js') }}
	{{ HTML::script('js/script.js') }}
</body>
</html>