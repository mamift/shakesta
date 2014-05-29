@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<h2 class="">
		<a href="{{ URL::route('users.index') }}">&lt; Back to users</a>
	</h2>
	<div>
		{{ Form::open(['route' => 'users.store']) }}
			<table class="tabulus tabulus-form">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Create a new User</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<!-- <td>{{ Form::label('user_id', 'ID') }}</td>
						<td>
							{{-- Form::input('text', 'user_id', $new_id, ['readonly' => 'readonly']) --}}
						</td> -->
					</tr>
					<tr>
						<td>{{ Form::label('username','Username:') }}</td>
						<td>
							{{ Form::text('username') }}
							<span class="error">{{{ $username_message = $errors->first('username') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}</td>
						<td>
							{{ Form::textarea('email') }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retailer_id','Retailer:') }}</td>
						<td>
							{{ Form::select('retailer_id', $retailers) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('password','Password:') }}</td>
						<td>
							{{ Form::password('password', ['placeholder' => '(Minimum 6 chars)']) }} 
							<span class="error">{{{ $password_message = $errors->first('password') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('generate_or_delete_apikey','Generate API Key?') }}</td>
						<td>{{ Form::checkbox('generate_or_delete_apikey', "generate_apikey", true) }}</td>
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