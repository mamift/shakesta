@extends('layout')

@section('content')
	<h2 class="">
		<a href="{{ URL::route('users.index') }}">&lt; Back to users</a>
	</h2>
	<div>
		{{ Form::open(['route' => 'users.store', 'role' => 'form', 'class' => 'form-inline']) }}
			<table class="table table-hover table-striped table-condensed">
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
							{{ Form::text('username', null, ['class' => 'form-control input-sm']) }}
							<span class="error">{{ $errors->first('username') }}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}</td>
						<td>
							{{ Form::text('email', null, ['size' => '30', 'class' => 'form-control input-sm']) }}
							<span class="error">{{{ $username_message = $errors->first('email') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retailer_id','Client:') }}</td>
						<td>
							{{ Form::select('retailer_id', $retailers, null, ['class' => 'form-control input-sm']) }} <br />
							<a href="{{ URL::route('retailers.create') }}"> (Click here to create new client) </a>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('password','Password:') }}</td>
						<td>
							{{ Form::password('password', ['placeholder' => '(Minimum 6 chars)', 'class' => 'form-control input-sm']) }} 
							<span class="error">{{{ $password_message = $errors->first('password') }}}</span>
						</td>
					</tr>
					<tr style="display:none; visibility:hidden;">
						<td>{{ Form::label('enabled','Enable user?') }}</td>
						<td>{{ Form::checkbox('enabled', "enabled", true, ['class' => 'form-control input-sm']) }}</td>
					</tr>
					<tr style="display:none; visibility: hidden;">
						<td>{{ Form::label('generate_or_delete_apikey','Generate API Key?') }}</td>
						<td>{{ Form::checkbox('generate_or_delete_apikey', "generate_apikey", true, ['class' => 'form-control input-sm']) }}</td>
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
							{{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop