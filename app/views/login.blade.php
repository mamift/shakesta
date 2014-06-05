@extends('layout')

@section('content')
<style> @import url('/login.css'); </style>
<div class="login">
	@if (Auth::check())
		
		<p>Hello, {{ Auth::user()->username; }} </p>
		{{-- this $User_message is displayed if a retailer user has tried to access an admin-only page --}}
		@if (Auth::user()->is_admin)
		<p class="center-aligned"><a href="{{ URL::route('users.edit', Auth::user()->id) }}" class="btn btn-danger">Click here to update your user details.</a></p>
		@else
		<p>If this is your first time here, you first must create a new product, then create a new deal (campaign) associated with it. All changes to products and deals are pushed automatically to the API. To view the API commands for connecting a phone app, see the command list <a href="{{ URL::to('/api/v1.2/') }}"> here (presented as JSON).</a></p>
		@endif
		@if ($user_message = Session::get('user_message'))
		<p><span class="error">{{ $user_message or "" }}</span></p>
		@endif
		<p>You are currently logged in.</p>
		<p>You are a <strong>{{ Auth::user()->user_type; }}</strong> user</p>
		{{-- <p>Retailer: {{ Retailer::find(Auth::user()->retailer_id); }}</p> --}}
		@if (Auth::user()->user_type === 'retailer')
		<p>Client: {{ $retailer = User::find(Auth::user()->user_id)->retailer->title; }}</p>
		@else
		<p>You are an administrator and can manage other users.</p>
		@endif

		@if (!Auth::user()->is_admin)
		<p>Want to change your password? </p>
		{{ Form::open(['method' => 'POST', 'url' => ['users-selfupdate', Auth::user()->id], 'role' => 'form', 'class' =>'form-inline' ]) }}
			{{ Form::password('reset_password', null, ['class' => 'form-control input-sm', 'placeholder' => 'Reset password']) }}
			{{ Form::password('reset_password_confirmation', null, ['class' => 'form-control input-sm', 'placeholder' => 'Reset password']) }}
			{{ Form::submit() }}
		<p class="error center-aligned">{{ Session::get('password_msg') }}</p>
		{{ Form::close() }}
		@endif

		@if (Auth::user()->apikey)
		<p>You API key is: <span class="error">{{ Auth::user()->apikey }}</span></p>
		@endif
		<p class="center-aligned"><a href="{{ URL::to('user-logout') }}" class="btn btn-danger">Click here to logout.</a></p>
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
	@endif
</div>	
@stop
 