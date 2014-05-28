@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<h2 class="">
		<a href="{{ URL::route('users.index') }}">&lt; Back to users</a>
	</h2>
	<div>
		{{ Form::model($user, ['method' => 'GET', 'route' => ['users.index', $user->id]]) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>User no. {{ $user->id }}</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('user_id', 'ID') }}</td>
						<td>
							{{ $user->id }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('username','Username:') }}</td>
						<td>
							{{ $user->username }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}</td>
						<td>
							{{ $user->email }}
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Back') }}
							<button type="button" onClick="window.location='{{ URL::route('users.edit', $user->user_id) }}'">Edit user</button>
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop