@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<div class="">
		<a href="{{ URL::route('users.index') }}">Back to users</a>
	</div>
	<div>
		{{ Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Edit user</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Form::label('user_id', 'ID') }}</td>
						<td>
							{{ Form::input('text', 'user_id', $user->id, ['readonly' => 'readonly']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('username','Username:') }}</td>
						<td>
							{{ Form::text('username') }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}</td>
						<td>
							{{ Form::textarea('email') }}
						</td>
					</tr>
					<!-- <tr>
						<td>Created </td>
						<td>{{ Form::input('time', 'created_at', null, ['readonly' => 'readonly']) }}</td>
					</tr>
					<tr>
						<td>Last updated</td>
						<td>{{ Form::input('time', 'updated_at', null, ['readonly' => 'readonly']) }}</td>
					</tr> -->
				</tbody>
				<tfoot>
					<tr class="">
						<td colspan="2">
							{{ Form::submit('Save') }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop