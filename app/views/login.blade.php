@extends('layout')

@section('content')
<style> @import url('/login.css'); </style>
<div class="login">
	@if (Auth::check())
		<p>Hello, {{ Auth::user()->username; }}</p>
		<p>You are already logged in.</p>
		<p>You are a <strong>{{ Auth::user()->user_type; }}</strong> user</p>
		{{-- <p>Retailer: {{ Retailer::find(Auth::user()->retailer_id); }}</p> --}}
		@if (Auth::user()->user_type === 'retailer')
		<p>Retailer: {{ $retailer = User::find(Auth::user()->user_id)->retailer->title; }}</p>
		@else
		<p>You are an administrator and can manage other users.</p>
		@endif
		<p><a href="{{ URL::to('user-logout') }}">Click here to logout.</a></p>
	@else
	<h1>Login to Web App</h1>

	<p class="error">{{ $errors->first('username') }}</p>
	<p class="error">{{ $errors->first('password') }}</p>

	@if (Session::has('flash_error'))
	<p class="error">{{ Session::get('flash_error') }}</p>
	@endif

	{{ Form::open(['url' => 'user-login']) }}
		{{ Form::label('username', 'Username:') }}
		{{ Form::text('username', Input::old('username'), ['placeholder' => 'Enter username (not e-mail address)']) }}

		{{ Form::label('password', 'Password:') }}
		{{ Form::password('password', Input::old('password')) }}

		{{ Form::label('remember_token','Remember me?') }}
		{{ Form::checkbox('remember_token', null, ['id' => 'remember_me']) }}

		<p class="submit">
			{{ Form::submit(); }}
		</p>
	{{ Form::close() }}
	<!-- old stuff
	<form method="post" action="index.html">
		<p><input type="text" name="username" value="" placeholder="Username or Email"></p>
		<p><input type="password" name="password" value="" placeholder="Password"></p>
		<p class="remember_me">
		<label>
			<input type="checkbox" name="remember_me" id="remember_me" />
			Remember me on this computer
		</label>
		</p>
		<p class="submit">
			<input type="submit" name="commit" value="Login">
		</p>
	</form>
	-->
	@endif
</div>	
@stop
 