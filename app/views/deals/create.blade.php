@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>

	<div class="login" style="">

		{{ Form::open(['route' => 'deals.store']) }}
			{{ Formgenerator::generate('deal') }}
		{{ Form::close() }}

	</div>
@stop