@extends('layout')

@section('content')

	<h2 class="">
		<a href="/user-login">&lt; Back login</a>
	</h2>
	<div>
		{{ Form::open(['url' => 'user-signup', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline', 'id' => 'registration-form']) }}
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Register a new Client Account</h3>
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
						<td>{{ Form::label('username','Username:') }}<span class="error">&ast;</span></td>
						<td>
							{{ Form::text('username', null, ['class' => 'form-control input-sm']) }}
							@if (Session::get('username_message'))
							<span class="error">{{ Session::get('username_message') }}</span>
							@endif
							<span class="error">{{{ $errors->first('username') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('email','E-mail:') }}<span class="error">&ast;</span></td>
						<td>
							{{ Form::text('email', null, ['size' => '30', 'class' => 'form-control input-sm']) }}
							@if (Session::get('email_message'))
							<span class="error">{{ Session::get('email_message') }}</span>
							@endif
							<span class="error">{{ $errors->first('email') }}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('retailer_id','Retailer:') }}<span class="error"></span></td>
						<td>
							{{ Form::select('retailer_id', $retailers, null, ['class' => 'form-control input-sm']) }}

							{{ Form::text('suggested_retailer_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Enter your own client\' name', 'size' => '30', 'disabled' => 'disabled', 'id' => 'suggested_retailer_name', 'style' => 'display: none;'])}}
							<span class="error">
								{{ $errors->first('suggested_retailer_name') }} <br/>
								{{ Session::get('suggested_retailer_name') }}
							</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('password','Password:') }} <span class="error">&ast;</span></td>
						<td>
							{{ Form::password('password', ['placeholder' => '(Minimum 6 chars)', 'class' => 'form-control input-sm']) }} 
							<span class="error">{{{ $password_message = $errors->first('password') }}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('password_confirmation','Password (confirm):') }}<span class="error">&ast;</span></td>
						<td>
							{{ Form::password('password_confirmation', ['placeholder' => '(Minimum 6 chars)', 'class' => 'form-control input-sm']) }} 
							<span class="error">{{{ $password_message = $errors->first('password_confirmation') }}}</span>
						</td>
					</tr>
					<tr style="display:none; visibility:hidden;">
						<td>{{ Form::label('enabled','Enable user?') }}</td>
						<td>{{ Form::checkbox('enabled', "enabled", false) }}</td>
					</tr>
					<tr style="display:none; visibility: hidden;">
						<td>{{ Form::label('generate_or_delete_apikey','Generate API Key?') }}</td>
						<td>{{ Form::checkbox('generate_or_delete_apikey', "generate_apikey", true) }}</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<span class="error">User registration is subject to administrator approval.</span>
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
							{{ Form::submit('Save', ['class' => 'form-control btn btn-primary']) }}
						</td>
					</tr>
				</tfoot>
			</table>
		{{ Form::close() }}
	</div>
@stop