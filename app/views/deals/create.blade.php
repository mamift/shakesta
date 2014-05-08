@extends('layout')

@section('content')

	<style> @import url('/login.css'); </style>

	<div class="login" style="">

		{{ Form::open() }}
			{{ Formgenerator::generate('deal') }}
		{{ Form::close() }}

	</div>
@stop