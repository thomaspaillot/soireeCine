<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::group(array('before' => 'auth'), function() {
	
	Route::any('/', function() {
		$movies = Movie::with(array('user', 'votes_all' => function($query) {
			$query->where('user_id', '=', Auth::user()->id);
		}))->order_by('votes', 'desc')->get();
		
		return View::make('index')->with('movies', $movies)->with('page', 'main_page');
	});
	
	Route::post('add_movie', function() {
		$new_movie = array(
			'user_id' 		=> Input::get('user'),
			'title' 		=> Input::get('title'),
			'description' 	=> Input::get('description')
		);
	
		$movie = new Movie($new_movie);
		$movie->save();
		
		return Redirect::to('/');
	});
	
	Route::post('update_movie', function() {
		$movie = Movie::find(Input::get('movie_id'));
		$movie->description = Input::get('description');
		$movie->save();
		
		return Redirect::to('/');
	});
	
	Route::post('remove_movie', function() {		
		$movie = Movie::find(Input::get('movie_id'));
		$movie->delete();
		
		return Response::json(array('movie_id'	=> Input::get('movie_id')));
	});
	
	Route::post('increment_vote', function() {		
		$movie = Movie::find(Input::get('movie_id'));
		$movie->votes = Input::get('votes');
		$movie->save();
		
		$new_vote = array(
			'user_id'	=> Input::get('user_id'),
			'movie_id'	=> Input::get('movie_id')
		);
		
		$vote = new Vote($new_vote);
		$vote->save();
		
		return Response::json(array('votes'	=> Input::get('votes')));
	});
	
	Route::get('logout', function() {
		Auth::logout();
		return Redirect::to('login');
	});
});

Route::get('login', function() {
	return View::make('login')->with('page', 'login_page');
});

Route::post('login', function() {
	if(Auth::check()) return Redirect::to('/');
	
	$credentials = array('username' => Input::get('username'), 
						 'password' => Input::get('password'));
					
	if(Input::get('new_user')) {
		$new_user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		
		$user = new User($new_user);
		$user->save();
	} 
	
	if(Auth::attempt($credentials)) {
		return Redirect::to('/');
	} else {
		return Redirect::to('login');
	}
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});