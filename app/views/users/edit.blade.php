@extends('layout')

@section('content')

	<style> @import url('/css/tabulus.css'); </style>
	<h2>
		<a href="{{ URL::route('users.index') }}">&lt; Back to users</a>
	</h2>
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
							@if (Auth::user()->is_admin && Auth::user()->user_type == 'admin')
							{{ Form::select('retailer_id', $retailers, 'null', ['disabled' => 'disabled']) }}
							@else
							{{ Form::select('retailer_id', $retailers) }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('new_password','New passowrd:') }}</td>
						<td>
							{{ Form::password('new_password', ['placeholder' => 'Min 6 chars']) }} 
							<span class="error">{{{ $password_message1 = $errors->first('new_password') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('new_password_confirm','New passowrd (confirm):') }}</td>
						<td>
							{{ Form::password('new_password_confirmation', ['placeholder' => 'Min 6 chars']) }} 
							<span class="error">{{{ $password_message2 = $errors->first('new_password_confirmation') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('generate_apikey','Generate new api key?') }}</td>
						<td>
							{{ Form::checkbox('generate_apikey', 'generate_apikey', false) }}
							@if ($user->apikey) Existing API key is&colon; <span class="error">{{ $user->apikey }} </span> @endif
						</td>
					</tr>
					@if ($user->apikey)
					<tr>
						<td>{{ Form::label('delete_apikey','Delete API key?') }}</td>
						<td>
							{{ Form::checkbox('delete_apikey', 'delete_apikey', false) }}
						</td>
					</tr>

					@endif
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